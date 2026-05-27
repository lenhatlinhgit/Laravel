<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\CrawlSource;
use App\Http\Controllers\PostController;
use Symfony\Component\DomCrawler\Crawler;

class CrawlNewsCommand extends Command
{
    protected $signature   = 'crawl:news';
    protected $description = 'Tự động crawl bài viết từ các nguồn báo';

    public function handle(): void
    {
        $sources = CrawlSource::where('is_active', true)
            ->where('is_done', false)
            ->get();

        if ($sources->isEmpty()) {
            $this->info('Không có nguồn nào đang active.');
            return;
        }

        foreach ($sources as $source) {

            if (!$source->isDue()) {
                $this->line("⏭  [{$source->name}] Chưa đến giờ, bỏ qua.");
                continue;
            }

            $this->info("🔄 [{$source->name}] Đang crawl {$source->url} ...");

            try {

                $this->crawlSource($source);

                // Cập nhật last_run_at
                $updateData = ['last_run_at' => now()];

                // Chế độ once → đánh dấu done
                if ($source->mode === 'once') {
                    $updateData['is_done'] = true;
                }

                $source->update($updateData);

                $this->info("✅ [{$source->name}] Hoàn thành!");

            } catch (\Throwable $e) {
                $this->error("❌ [{$source->name}] Lỗi: {$e->getMessage()}");
            }
        }
    }

    // =========================
    // CRAWL 1 SOURCE
    // =========================

    private function crawlSource(CrawlSource $source): void
    {
        $response = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])
            ->withOptions(['verify' => false])
            ->timeout(20)
            ->get($source->url);

        if ($response->failed()) {
            throw new \Exception("Không thể truy cập {$source->url}");
        }

        $crawler = new Crawler($response->body());
        $domain  = parse_url($source->url, PHP_URL_HOST);
        $parsed  = parse_url($source->url);
        $links   = collect();

        $crawler->filter('a')->each(function ($node) use ($domain, $parsed, &$links) {

            $href = $node->attr('href');
            if (!$href) return;

            // relative -> absolute
            if (str_starts_with($href, '/')) {
                $href = $parsed['scheme'] . '://' . $parsed['host'] . $href;
            }

            // Chỉ lấy link cùng domain + dạng bài viết
            if (
                str_contains($href, $domain) &&
                preg_match('/\d+\.html$/', $href)
            ) {
                $links->push($href);
            }
        });

        $links = $links->unique()->take($source->max_posts);

        if ($links->isEmpty()) {
            $this->warn("  ⚠  Không tìm thấy link bài nào.");
            return;
        }

        $postController = new PostController();

        foreach ($links as $link) {

            $exists = DB::table('posts')
                ->where('source_url', $link)
                ->exists();

            if ($exists) {
                $this->line("  ⏭  Đã có: {$link}");
                continue;
            }

            $this->line("  📄 Crawl: {$link}");

            try {

                $data = $postController->fetchSeoData($link);

                if (empty($data['title']) || empty($data['content'])) {
                    $this->warn("  ⚠  Thiếu dữ liệu, bỏ qua.");
                    continue;
                }

                $this->savePost($data, $link);
                $this->line("  ✅ Đã lưu: {$data['title']}");

            } catch (\Throwable $e) {
                $this->warn("  ⚠  Lỗi bài này: {$e->getMessage()}");
            }
        }
    }

    // =========================
    // LƯU BÀI VÀO DB
    // =========================

    private function savePost(array $data, string $sourceUrl): void
    {
        $bgPath = null;

        if (!empty($data['image_url'])) {

            try {

                $imgResponse = Http::withHeaders(['User-Agent' => 'Mozilla/5.0'])
                    ->withOptions(['verify' => false])
                    ->timeout(20)
                    ->get($data['image_url']);

                if ($imgResponse->successful()) {

                    $contentType = $imgResponse->header('Content-Type');
                    $ext = 'jpg';
                    if (str_contains($contentType, 'png'))  $ext = 'png';
                    if (str_contains($contentType, 'webp')) $ext = 'webp';

                    $bgName = time() . '_crawl_' . Str::random(6) . '.' . $ext;
                    $path   = public_path('uploads/backgrounds');

                    if (!file_exists($path)) mkdir($path, 0777, true);

                    file_put_contents("{$path}/{$bgName}", $imgResponse->body());
                    $bgPath = '/uploads/backgrounds/' . $bgName;
                }

            } catch (\Throwable) {}
        }

        if (!$bgPath) {
            $this->warn("  ⚠  Không tải được ảnh, bỏ qua.");
            return;
        }

        $postId = DB::table('posts')->insertGetId([
            'title'      => $data['title'],
            'author'     => $data['author'] ?: 'Sưu tầm',
            'content'    => clean($data['content']),
            'background' => $bgPath,
            'source_url' => $sourceUrl,
            'dateposted' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if (!empty($data['location'])) {

            $loc      = trim($data['location']);
            $location = DB::table('locations')->where('name', $loc)->first();

            $locationId = $location
                ? $location->id
                : DB::table('locations')->insertGetId([
                    'name'       => $loc,
                    'slug'       => Str::slug($loc),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            DB::table('post_locations')->insert([
                'post_id'     => $postId,
                'location_id' => $locationId,
            ]);
        }
    }
}
