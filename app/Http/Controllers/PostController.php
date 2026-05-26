<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Post;
use App\Models\Location;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class PostController extends Controller
{
    public function form()
    {
        return view('admin');
    }

    public function index()
    {
        $posts = Post::with('locations')
            ->orderBy('views', 'desc')
            ->paginate(4);

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

        $posts = $location->posts()->paginate(4);

        return view('location', compact('posts', 'location'));
    }

    public function admin()
    {
        $posts = Post::latest()->get();

        return view('admin', compact('posts'));
    }

    public function createPost()
    {
        return view('createpost');
    }

    // =========================
    // CREATE POST
    // =========================

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

        // upload file
        if ($request->hasFile('background')) {

            $bg = $request->file('background');

            $bgName = time() . '_' . $bg->getClientOriginalName();

            $bg->move(
                public_path('uploads/backgrounds'),
                $bgName
            );

            $bgPath = '/uploads/backgrounds/' . $bgName;
        }

        // download image
        elseif ($request->image_url) {

            try {

                $imageResponse = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0',
                    'Accept' => 'image/*,*/*;q=0.8',
                ])
                ->withOptions([
                    'allow_redirects' => true,
                    'verify' => false
                ])
                ->timeout(20)
                ->get($request->image_url);

                if ($imageResponse->failed()) {
                    throw new \Exception();
                }

            } catch (\Throwable $e) {

                return back()
                    ->withErrors([
                        'image_url' => 'Không thể tải ảnh'
                    ])
                    ->withInput();
            }

            $contentType = $imageResponse
                ->header('Content-Type');

            $extension = 'jpg';

            if (str_contains($contentType, 'png')) {
                $extension = 'png';
            }

            if (str_contains($contentType, 'webp')) {
                $extension = 'webp';
            }

            $bgName = time() . '_seo_image.' . $extension;

            $uploadPath = public_path(
                'uploads/backgrounds'
            );

            if (!file_exists($uploadPath)) {

                mkdir($uploadPath, 0777, true);
            }

            file_put_contents(
                $uploadPath . '/' . $bgName,
                $imageResponse->body()
            );

            $bgPath = '/uploads/backgrounds/' . $bgName;
        }

        if (!$bgPath) {

            return back()
                ->withErrors([
                    'background' => 'Vui lòng chọn ảnh'
                ])
                ->withInput();
        }

        $postId = DB::table('posts')
            ->insertGetId([

                'title' => $request->title,
                'author' => $request->author,
                'content' => clean($request->content),
                'background' => $bgPath,
                'dateposted' => now(),

                'created_at' => now(),
                'updated_at' => now(),
            ]);

        // location
        $locations = explode(',', $request->location);

        foreach ($locations as $loc) {

            $loc = trim($loc);

            if (empty($loc)) {
                continue;
            }

            $location = DB::table('locations')
                ->where('name', $loc)
                ->first();

            if (!$location) {

                $locationId = DB::table('locations')
                    ->insertGetId([

                        'name' => $loc,
                        'slug' => Str::slug($loc),

                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

            } else {

                $locationId = $location->id;
            }

            DB::table('post_locations')->insert([
                'post_id' => $postId,
                'location_id' => $locationId,
            ]);
        }

        return redirect('/admin')
            ->with('success', 'Đăng bài thành công');
    }

    // =========================
    // EDIT
    // =========================

    public function edit($id)
    {
        $post = Post::with('locations')
            ->findOrFail($id);

        $locationString = $post->locations
            ->pluck('name')
            ->implode(', ');

        return view(
            'editpost',
            compact('post', 'locationString')
        );
    }

    // =========================
    // UPDATE
    // =========================

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $data = [

            'title' => $request->title,
            'author' => $request->author,
            'content' => clean($request->content),

            'updated_at' => now(),
        ];

        if ($request->hasFile('background')) {

            $bg = $request->file('background');

            $bgName = time()
                . '_'
                . $bg->getClientOriginalName();

            $bg->move(
                public_path('uploads/backgrounds'),
                $bgName
            );

            $data['background']
                = '/uploads/backgrounds/' . $bgName;
        }

        DB::table('posts')
            ->where('id', $id)
            ->update($data);

        // update location
        DB::table('post_locations')
            ->where('post_id', $id)
            ->delete();

        $locations = explode(',', $request->location);

        foreach ($locations as $loc) {

            $loc = trim($loc);

            if (empty($loc)) {
                continue;
            }

            $location = DB::table('locations')
                ->where('name', $loc)
                ->first();

            if (!$location) {

                $locationId = DB::table('locations')
                    ->insertGetId([

                        'name' => $loc,
                        'slug' => Str::slug($loc),

                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);

            } else {

                $locationId = $location->id;
            }

            DB::table('post_locations')->insert([
                'post_id' => $id,
                'location_id' => $locationId,
            ]);
        }

        return redirect('/admin')
            ->with('success', 'Cập nhật thành công');
    }

    // =========================
    // DELETE
    // =========================

    public function destroy($id)
    {
        DB::table('posts')
            ->where('id', $id)
            ->delete();

        return redirect('/admin')
            ->with('success', 'Xóa thành công');
    }

    // =========================
    // FETCH SEO
    // =========================

    public function fetchSeo(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        try {

            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0',
                'Accept' => 'text/html'
            ])
            ->withOptions([
                'verify' => false
            ])
            ->timeout(20)
            ->get($request->url);

        } catch (\Throwable $e) {

            return response()->json([
                'error' => 'Không thể truy cập URL'
            ], 422);
        }

        if ($response->failed()) {

            return response()->json([
                'error' => 'URL lỗi'
            ], 422);
        }

        $html = $response->body();

        $crawler = new Crawler($html);

        // ======================
        // title
        // ======================

        $title = $this->crawlFirst($crawler, [

            'meta[property="og:title"]' => 'content',
            'meta[name="twitter:title"]' => 'content',
            'title' => null,
        ]);

        // ======================
        // author
        // ======================

        $author = $this->crawlFirst($crawler, [

            // meta
            'meta[name="author"]' => 'content',
            'meta[property="article:author"]' => 'content',

            // VnExpress
            '.author_mail' => null,
            '.author' => null,

            // Vietnamnet
            '.ArticleAuthor' => null,
            '.vnn-author' => null,
        ]);

        if (!$author) {

            try {

                $authorNode = $crawler->filter(

                    '.author_mail,
                     .author,
                     .ArticleAuthor,
                     .vnn-author'
                );

                if ($authorNode->count() > 0) {

                    $author = trim(
                        $authorNode->first()->text()
                    );
                }

            } catch (\Throwable $e) {
            }
        }

        if (!$author || strlen(trim($author)) < 2) {

            $author = 'Sưu tầm';
        }

        // ======================
        // location
        // ======================

        $location = $this->crawlFirst($crawler, [

            // category/meta
            'meta[property="article:section"]' => 'content',
            'meta[name="section"]' => 'content',

            // VnExpress
            '.breadcrumb li:last-child' => null,
            '.box-breadcrumb a:last-child' => null,

            // Vietnamnet
            '.bread-crumb-detail__item:last-child' => null,
            '.breadcrumb-box__link:last-child' => null,
        ]);

        // fallback
        if (!$location || strlen(trim($location)) < 2) {

            $location = 'Thế giới';
        }

        // ======================
        // image
        // ======================

        $imageUrl = $this->crawlFirst($crawler, [

            'meta[property="og:image"]' => 'content',
            'meta[name="twitter:image"]' => 'content',
        ]);

        // ======================
        // content
        // ======================

        $content = $this->extractMainContent(
            $crawler,
            $request->url
        );

        return response()->json([

            'title' => $title,
            'author' => $author,
            'location' => $location,
            'image_url' => $imageUrl,
            'content' => $content,
        ]);
    }

    // =========================
    // GET META
    // =========================

    private function crawlFirst(
        Crawler $crawler,
        array $selectors
    ): string {

        foreach ($selectors as $selector => $attr) {

            try {

                $node = $crawler->filter($selector);

                if ($node->count() === 0) {
                    continue;
                }

                $value = $attr
                    ? trim($node->first()->attr($attr))
                    : trim($node->first()->text());

                if (!empty($value)) {
                    return $value;
                }

            } catch (\Throwable $e) {
            }
        }

        return '';
    }

    // =========================
    // FIX IMAGE
    // =========================

    private function fixImages(
        $html,
        $baseUrl
    ) {

        $parsed = parse_url($baseUrl);

        $origin =
            $parsed['scheme']
            . '://'
            . $parsed['host'];

        $html = preg_replace_callback(

            '/<img([^>]*?)>/i',

            function ($matches) use ($origin) {

                $tag = $matches[1];

                $lazyAttrs = [

                    'data-src',
                    'data-original',
                    'data-lazy',
                    'data-image',
                ];

                $src = null;

                foreach ($lazyAttrs as $attr) {

                    if (
                        preg_match(
                            '/'.$attr.'=["\']([^"\']+)["\']/i',
                            $tag,
                            $m
                        )
                    ) {

                        $candidate = trim($m[1]);

                        if (
                            !empty($candidate)
                            && !str_starts_with(
                                $candidate,
                                'data:image'
                            )
                        ) {

                            $src = $candidate;

                            break;
                        }
                    }
                }

                // fallback src
                if (!$src) {

                    if (
                        preg_match(
                            '/src=["\']([^"\']+)["\']/i',
                            $tag,
                            $m
                        )
                    ) {

                        $candidate = trim($m[1]);

                        if (
                            !str_starts_with(
                                $candidate,
                                'data:image'
                            )
                        ) {

                            $src = $candidate;
                        }
                    }
                }

                if (!$src) {
                    return '';
                }

                // relative -> absolute
                if (str_starts_with($src, '//')) {

                    $src = 'https:' . $src;

                } elseif (
                    !preg_match(
                        '/^https?:\/\//i',
                        $src
                    )
                ) {

                    $src = $origin . '/'
                        . ltrim($src, '/');
                }

                // alt
                $alt = '';

                if (
                    preg_match(
                        '/alt=["\']([^"\']*)["\']/i',
                        $tag,
                        $m
                    )
                ) {

                    $alt = htmlspecialchars(
                        $m[1],
                        ENT_QUOTES
                    );
                }

                return '
                    <img
                        src="'.$src.'"
                        alt="'.$alt.'"
                        width="100%"
                        style="height:auto;"
                    >
                ';
            },

            $html
        );

        return $html;
    }

    // =========================
    // EXTRACT CONTENT
    // =========================

    private function extractMainContent(
        Crawler $crawler,
        string $baseUrl
    ) {

        $contentSelectors = [

            // VnExpress
            '.fck_detail',
            '.sidebar-1',

            // Tuổi Trẻ
            '.detail-content',
            '.content-fck',

            // Thanh Niên
            '.detail__content',
            '.cms-body',

            // Vietnamnet
            '.maincontent',
            '.ArticleContent',

            // Generic
            'article',
            '.article-content',
            '.article-body',
            '.post-content',
            '.entry-content',
        ];

        $contentNode = null;

        foreach ($contentSelectors as $selector) {

            try {

                $node = $crawler->filter($selector);

                if ($node->count() > 0) {

                    $textLength = strlen(
                        trim($node->text())
                    );

                    if ($textLength > 500) {

                        $contentNode = $node->first();

                        break;
                    }
                }

            } catch (\Throwable $e) {
            }
        }

        // fallback auto detect
        if (!$contentNode) {

            $bestNode = null;

            $bestScore = 0;

            $crawler->filter(
                'article, div, section'
            )->each(function ($node)
            use (&$bestNode, &$bestScore) {

                try {

                    $textLength = strlen(
                        trim($node->text())
                    );

                    $pCount = $node
                        ->filter('p')
                        ->count();

                    $imgCount = $node
                        ->filter('img')
                        ->count();

                    $score =
                        $textLength
                        + ($pCount * 200)
                        + ($imgCount * 100);

                    if ($score > $bestScore) {

                        $bestScore = $score;

                        $bestNode = $node;
                    }

                } catch (\Throwable $e) {
                }
            });

            $contentNode = $bestNode;
        }

        if (!$contentNode) {
            return '';
        }

        $html = $contentNode->html();

        $innerCrawler = new Crawler(
            '<div id="wrapper">'
            . $html .
            '</div>'
        );

        // remove rác
        $removeSelectors = [

            'script',
            'style',
            'nav',
            'aside',

            '[class*="ads"]',
            '[class*="banner"]',
            '[class*="google"]',

            '[class*="related"]',
            '[class*="Related"]',
            '[class*="relate"]',

            '[class*="comment"]',

            '[class*="social"]',
            '[class*="share"]',
        ];

        foreach ($removeSelectors as $selector) {

            try {

                $innerCrawler
                    ->filter($selector)
                    ->each(function ($node) {

                        foreach ($node as $domNode) {

                            $domNode
                                ->parentNode
                                ?->removeChild($domNode);
                        }
                    });

            } catch (\Throwable $e) {
            }
        }

        $cleanHtml = $innerCrawler
            ->filter('#wrapper')
            ->html();

        // fix image
        $cleanHtml = $this->fixImages(
            $cleanHtml,
            $baseUrl
        );

        // allow rich text
        $allowedTags =

            '<p><br>'

            . '<h1><h2><h3><h4><h5><h6>'

            . '<strong><em><u><b><i>'

            . '<ul><ol><li>'

            . '<blockquote>'

            . '<a>'

            . '<img>'

            . '<table><thead><tbody><tr><td><th>'

            . '<figure><figcaption>';

        $cleanHtml = strip_tags(
            $cleanHtml,
            $allowedTags
        );

        // remove attribute rác
        $cleanHtml = preg_replace(

            '/\s+(class|id|data-[a-z-]+)="[^"]*"/i',

            '',

            $cleanHtml
        );

        // remove empty p
        $cleanHtml = preg_replace(
            '/<p>\s*<\/p>/i',
            '',
            $cleanHtml
        );

        // remove too many br
        $cleanHtml = preg_replace(
            '/(\s*<br\s*\/?>\s*){3,}/i',
            '<br><br>',
            $cleanHtml
        );

        return trim($cleanHtml);
    }
}