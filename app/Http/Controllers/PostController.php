<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Location;
use Symfony\Component\DomCrawler\Crawler;

class PostController extends Controller
{
    public function form()
    {
        return view('admin');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'location'   => 'required|string|max:255',
            'author'     => 'required|string|max:255',
            'content'    => 'required|string',
            'background' => 'nullable|image|max:4096',
            'image_url'  => 'nullable|url',
        ]);

        $bgPath = null;

        if ($request->hasFile('background')) {
            $bg = $request->file('background');
            $bgName = time() . '_' . $bg->getClientOriginalName();
            $bg->move(public_path('uploads/backgrounds'), $bgName);
            $bgPath = '/uploads/backgrounds/' . $bgName;
        } elseif ($request->image_url) {
            try {
                $imageResponse = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
                    'Accept'     => 'image/*,*/*;q=0.8',
                ])->withOptions(['allow_redirects' => true])->timeout(15)->get($request->image_url);

                if ($imageResponse->failed()) {
                    throw new \Exception('HTTP status ' . $imageResponse->status());
                }
            } catch (\Throwable $e) {
                try {
                    $imageResponse = Http::withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
                        'Accept'     => 'image/*,*/*;q=0.8',
                    ])->withOptions(['allow_redirects' => true, 'verify' => false])->timeout(15)->get($request->image_url);

                    if ($imageResponse->failed()) {
                        throw new \Exception('HTTP status ' . $imageResponse->status());
                    }
                } catch (\Throwable $e2) {
                    return back()->withErrors(['image_url' => 'Không thể tải ảnh nền từ URL.'])->withInput();
                }
            }

            $contentType = $imageResponse->header('Content-Type');
            $extension = 'jpg';
            if (stripos($contentType, 'png') !== false) $extension = 'png';
            elseif (stripos($contentType, 'gif') !== false) $extension = 'gif';
            elseif (stripos($contentType, 'webp') !== false) $extension = 'webp';

            $urlPath  = parse_url($request->image_url, PHP_URL_PATH);
            $fileName = pathinfo($urlPath, PATHINFO_FILENAME) ?: 'og_image';
            $bgName   = time() . '_' . preg_replace('/[^A-Za-z0-9-_]/', '_', $fileName) . '.' . $extension;

            $uploadPath = public_path('uploads/backgrounds');
            if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);

            file_put_contents($uploadPath . '/' . $bgName, $imageResponse->body());
            $bgPath = '/uploads/backgrounds/' . $bgName;
        }

        if (!$bgPath) {
            return back()->withErrors(['background' => 'Vui lòng chọn ảnh background hoặc sử dụng hình từ Link Preview.'])->withInput();
        }

        $content = clean($request->content);

        $postId = DB::table('posts')->insertGetId([
            'title'      => $request->title,
            'author'     => $request->author,
            'dateposted' => now(),
            'content'    => $content,
            'background' => $bgPath,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $locations = explode(',', $request->location);

        foreach ($locations as $loc) {
            $loc = trim($loc);
            if (empty($loc)) continue;

            $location = DB::table('locations')->where('name', $loc)->first();

            if (!$location) {
                $locationId = DB::table('locations')->insertGetId([
                    'name'       => $loc,
                    'slug'       => Str::slug($loc),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $locationId = $location->id;
            }

            DB::table('post_locations')->insert([
                'post_id'     => $postId,
                'location_id' => $locationId,
            ]);
        }

        return redirect('/admin')->with('success', 'Đăng bài thành công!');
    }

    public function uploadImage(Request $request)
    {
        $request->validate(['file' => 'required|image|max:2048']);

        $uploadPath = public_path('uploads/editor');
        if (!file_exists($uploadPath)) mkdir($uploadPath, 0777, true);

        $file = $request->file('file');
        $name = time() . '_' . $file->getClientOriginalName();
        $file->move($uploadPath, $name);

        return response()->json(['location' => url('uploads/editor/' . $name)]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'author'   => 'required|string|max:255',
            'content'  => 'required|string',
        ]);

        $data = [
            'title'      => $request->title,
            'author'     => $request->author,
            'content'    => clean($request->content),
            'updated_at' => now(),
        ];

        if ($request->hasFile('background')) {
            $bg     = $request->file('background');
            $bgName = time() . '_' . $bg->getClientOriginalName();
            $bg->move(public_path('uploads/backgrounds'), $bgName);
            $data['background'] = '/uploads/backgrounds/' . $bgName;
        }

        DB::table('posts')->where('id', $id)->update($data);
        DB::table('post_locations')->where('post_id', $id)->delete();

        $locations = explode(',', $request->location);

        foreach ($locations as $loc) {
            $loc = trim($loc);
            if (empty($loc)) continue;

            $location = DB::table('locations')->where('name', $loc)->first();

            if (!$location) {
                $locationId = DB::table('locations')->insertGetId([
                    'name'       => $loc,
                    'slug'       => Str::slug($loc),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $locationId = $location->id;
            }

            DB::table('post_locations')->insert([
                'post_id'     => $id,
                'location_id' => $locationId,
            ]);
        }

        return redirect('/admin')->with('success', 'Cập nhật thành công!');
    }

    public function index()
    {
        $posts = Post::with('locations')->orderBy('views', 'desc')->paginate(4);
        return view('home', compact('posts'));
    }

    public function show($id)
    {
        $post = Post::with('locations')->findOrFail($id);
        $post->increment('views');
        return view('post', compact('post'));
    }

    public function byLocation($slug)
    {
        $location = Location::where('slug', $slug)->firstOrFail();
        $posts    = $location->posts()->paginate(4);
        return view('location', compact('posts', 'location'));
    }

    public function admin()
    {
        $data['posts'] = $this->getPosts();
        return view('admin', $data);
    }

    public function createPost()
    {
        return view('createpost');
    }

    public function fetchSeo(Request $request)
    {
        $request->validate(['url' => 'required|url']);

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
                'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
            ])->timeout(15)->get($request->url);
        } catch (\Throwable $e) {
            $err = $e->getMessage();

            if (stripos($err, 'curl error 60') !== false || stripos($err, 'SSL') !== false || stripos($err, 'self-signed') !== false) {
                try {
                    $response = Http::withOptions(['verify' => false])->withHeaders([
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
                        'Accept'     => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                    ])->timeout(15)->get($request->url);
                } catch (\Throwable $e2) {
                    return response()->json(['error' => 'Không thể truy cập URL (SSL fallback thất bại): ' . $e2->getMessage()], 422);
                }
            } else {
                return response()->json(['error' => 'Không thể truy cập URL: ' . $err], 422);
            }
        }

        if (!isset($response) || $response->failed()) {
            return response()->json(['error' => 'Không thể truy cập URL đã nhập.'], 422);
        }

        $html    = $response->body();
        $baseUrl = $request->url;
        $crawler = new Crawler($html);

        $title = $this->crawlFirst($crawler, [
            'meta[property="og:title"]'     => 'content',
            'meta[name="twitter:title"]'    => 'content',
            'meta[name="title"]'            => 'content',
            'title'                         => null,
        ]);

        $author = $this->crawlFirst($crawler, [
            'meta[name="author"]'             => 'content',
            'meta[property="article:author"]' => 'content',
            'meta[name="twitter:creator"]'    => 'content',
        ]);

        $location = $this->crawlFirst($crawler, [
            'meta[property="article:section"]' => 'content',
            'meta[name="section"]'             => 'content',
            'meta[property="og:site_name"]'    => 'content',
            'meta[name="application-name"]'    => 'content',
        ]);
        if (empty($location)) {
            $location = parse_url($request->url, PHP_URL_HOST) ?: '';
        }

        $imageUrl = $this->crawlFirst($crawler, [
            'meta[property="og:image"]'            => 'content',
            'meta[property="og:image:secure_url"]' => 'content',
            'meta[itemprop="thumbnailUrl"]'         => 'content',
            'meta[name="twitter:image"]'           => 'content',
            'meta[name="twitter:image:src"]'       => 'content',
            'meta[name="image"]'                   => 'content',
        ]);

        $content = $this->extractMainContent($crawler, $baseUrl);

        return response()->json([
            'title'     => $title,
            'location'  => $location,
            'author'    => $author,
            'content'   => $content,
            'image_url' => $imageUrl,
        ]);
    }

    /**
     * Lấy giá trị đầu tiên tìm thấy từ danh sách CSS selector.
     */
    private function crawlFirst(Crawler $crawler, array $map): string
    {
        foreach ($map as $selector => $attr) {
            try {
                $node = $crawler->filter($selector);
                if ($node->count() === 0) continue;

                $value = $attr
                    ? trim($node->first()->attr($attr) ?? '')
                    : trim($node->first()->text(''));

                if ($value !== '') return $value;
            } catch (\Throwable) {
                continue;
            }
        }
        return '';
    }

    /**
     * Xử lý ảnh trong HTML:
     * 1. Ưu tiên data-src / data-lazy / data-original hơn src (lấy ảnh gốc thay vì thumbnail)
     * 2. Chuyển src tương đối → tuyệt đối
     * 3. Gán width="100%" cho tất cả ảnh
     */
    private function fixImages(string $html, string $baseUrl): string
    {
        $parsed = parse_url($baseUrl);
        $origin = $parsed['scheme'] . '://' . $parsed['host'];

        // Bước 1 + 3: xử lý từng thẻ <img>
        $html = preg_replace_callback(
            '/<img([^>]*?)>/i',
            function ($matches) use ($origin) {
                $tag = $matches[1];

                // Ưu tiên data-src hơn src để lấy ảnh gốc (không phải thumbnail)
                $lazyAttrs = ['data-src', 'data-lazy', 'data-original', 'data-url', 'data-image'];
                $newSrc    = null;

                foreach ($lazyAttrs as $attr) {
                    if (preg_match('/' . preg_quote($attr, '/') . '=["\']([^"\']+)["\']/i', $tag, $m)) {
                        $val = trim($m[1]);
                        if ($val !== '') {
                            $newSrc = $val;
                            break;
                        }
                    }
                }

                // Nếu không có data-src thì lấy src hiện tại
                if (!$newSrc) {
                    if (preg_match('/\bsrc=["\']([^"\']+)["\']/i', $tag, $m)) {
                        $newSrc = trim($m[1]);
                    }
                }

                if (!$newSrc) {
                    return ''; // Không có src nào → bỏ thẻ img
                }

                // Bước 2: src tương đối → tuyệt đối
                if (str_starts_with($newSrc, '//')) {
                    $newSrc = 'https:' . $newSrc;
                } elseif (!preg_match('/^https?:\/\//i', $newSrc)) {
                    $newSrc = $origin . '/' . ltrim($newSrc, '/');
                }

                // Bước 3: trả về thẻ img gọn, width 100%
                $alt = '';
                if (preg_match('/\balt=["\']([^"\']*)["\']/', $tag, $m)) {
                    $alt = ' alt="' . htmlspecialchars($m[1], ENT_QUOTES) . '"';
                }

                return '<img src="' . $newSrc . '"' . $alt . ' width="100%" style="height:auto;">';
            },
            $html
        );

        return $html;
    }

    /**
     * Lấy nội dung chính dạng rich text HTML cho TinyMCE.
     */
    private function extractMainContent(Crawler $crawler, string $baseUrl): string
    {
        $contentSelectors = [
            'article',
            'div.article-body',
            'div.article-content',
            'div.article-detail',
            'div.post-content',
            'div.post-body',
            'div.entry-content',
            'div.content-detail',
            'div.detail-content',
            'div#article-body',
            'div#article-content',
            'div#post-content',
            'main',
        ];

        $contentNode = null;

        foreach ($contentSelectors as $selector) {
            try {
                $node = $crawler->filter($selector);
                if ($node->count() > 0) {
                    $contentNode = $node->first();
                    break;
                }
            } catch (\Throwable) {
                continue;
            }
        }

        if (!$contentNode) {
            return $this->crawlFirst($crawler, [
                'meta[property="og:description"]' => 'content',
                'meta[name="description"]'        => 'content',
            ]);
        }

        $html = $contentNode->html();

        // Xóa node rác
        $innerCrawler = new Crawler('<div id="__wrapper__">' . $html . '</div>');

        $removeSelectors = [
            'script', 'style', 'iframe', 'ins', 'nav', 'aside',
            '[class*="ads"]', '[class*="adsbygoogle"]', '[class*="advertisement"]',
            '[class*="related"]', '[class*="share"]', '[class*="social"]',
            '[class*="comment"]', '[class*="sidebar"]', '[class*="banner"]',
            '[class*="newsletter"]', '[class*="subscription"]',
            '[id*="ads"]', '[id*="comment"]', '[id*="sidebar"]',
        ];

        foreach ($removeSelectors as $sel) {
            try {
                $innerCrawler->filter($sel)->each(function (Crawler $node) {
                    foreach ($node as $domNode) {
                        $domNode->parentNode?->removeChild($domNode);
                    }
                });
            } catch (\Throwable) {
                continue;
            }
        }

        $cleanHtml = $innerCrawler->filter('#__wrapper__')->html();

        // Xử lý ảnh TRƯỚC khi strip_tags
        $cleanHtml = $this->fixImages($cleanHtml, $baseUrl);

        // Chỉ giữ các thẻ phù hợp với TinyMCE
        $allowedTags = '<p><br><h1><h2><h3><h4><h5><h6>'
                     . '<strong><em><u><b><i><s>'
                     . '<ul><ol><li>'
                     . '<a><img>'
                     . '<blockquote>'
                     . '<table><thead><tbody><tr><td><th>'
                     . '<figure><figcaption>';

        $cleanHtml = strip_tags($cleanHtml, $allowedTags);

        // Xóa class, style, id, data-* rác — giữ src, href, alt, width
        $cleanHtml = preg_replace('/\s+(class|id|data-[a-z-]+)="[^"]*"/i', '', $cleanHtml);

        // Dọn dẹp <br> thừa
        $cleanHtml = preg_replace('/(\s*<br\s*\/?>\s*){3,}/i', '<br><br>', $cleanHtml);

        // Xóa <p> rỗng
        $cleanHtml = preg_replace('/<p>\s*<\/p>/i', '', $cleanHtml);

        return trim($cleanHtml);
    }

    private function getPosts()
    {
        return Post::latest()->get();
    }

    public function edit($id)
    {
        $post           = Post::with('locations')->findOrFail($id);
        $locationString = $post->locations->pluck('name')->implode(', ');
        return view('editpost', compact('post', 'locationString'));
    }

    public function destroy($id)
    {
        DB::table('posts')->where('id', $id)->delete();
        return redirect('/admin')->with('success', 'Xóa bài viết thành công!');
    }
}