<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Post;
use App\Models\User;
use ZipArchive;
use Illuminate\Support\Str;
use App\Models\Location;

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
                'Accept' => 'image/*,*/*;q=0.8',
            ])->withOptions(['allow_redirects' => true])->timeout(15)->get($request->image_url);

            if ($imageResponse->failed()) {
                throw new \Exception('HTTP status ' . $imageResponse->status());
            }
        } catch (\Throwable $e) {
            try {
                $imageResponse = Http::withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
                    'Accept' => 'image/*,*/*;q=0.8',
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
        if (stripos($contentType, 'png') !== false) {
            $extension = 'png';
        } elseif (stripos($contentType, 'gif') !== false) {
            $extension = 'gif';
        } elseif (stripos($contentType, 'webp') !== false) {
            $extension = 'webp';
        } elseif (stripos($contentType, 'jpeg') !== false || stripos($contentType, 'jpg') !== false) {
            $extension = 'jpg';
        }

        $urlPath = parse_url($request->image_url, PHP_URL_PATH);
        $fileName = pathinfo($urlPath, PATHINFO_FILENAME) ?: 'og_image';
        $bgName = time() . '_' . preg_replace('/[^A-Za-z0-9-_]/', '_', $fileName) . '.' . $extension;

        $uploadPath = public_path('uploads/backgrounds');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

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

    return redirect('/admin')->with('success', 'Đăng bài thành công!');
}

// Upload ảnh từ TinyMCE
public function uploadImage(Request $request)
{
    $request->validate([
        'file' => 'required|image|max:2048',
    ]);

    // Tạo thư mục nếu chưa có
    $uploadPath = public_path('uploads/editor');
    if (!file_exists($uploadPath)) {
        mkdir($uploadPath, 0777, true);
    }

    $file = $request->file('file');
    $name = time() . '_' . $file->getClientOriginalName();
    $file->move($uploadPath, $name);

    return response()->json([
    'location' => url('uploads/editor/' . $name)
]);
}

// Sửa update() thêm content
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

    // Nếu có upload background mới
    if ($request->hasFile('background')) {
        $bg = $request->file('background');
        $bgName = time() . '_' . $bg->getClientOriginalName();
        $bg->move(public_path('uploads/backgrounds'), $bgName);
        $data['background'] = '/uploads/backgrounds/' . $bgName;
    }

    // Update bảng posts
    DB::table('posts')->where('id', $id)->update($data);

    // ============================
    // FIX LOCATION (many-to-many)
    // ============================

    // Xóa location cũ
    DB::table('post_locations')->where('post_id', $id)->delete();

    // Tách location theo dấu phẩy
    $locations = explode(',', $request->location);

    foreach ($locations as $loc) {

        $loc = trim($loc);

        if (empty($loc)) continue;

        // tìm location đã tồn tại chưa
        $location = DB::table('locations')
            ->where('name', $loc)
            ->first();

        // nếu chưa có thì tạo mới
        if (!$location) {
            $locationId = DB::table('locations')->insertGetId([
                'name' => $loc,
                'slug' => Str::slug($loc),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $locationId = $location->id;
        }

        // gán vào pivot table
        DB::table('post_locations')->insert([
            'post_id' => $id,
            'location_id' => $locationId,
        ]);
    }

    return redirect('/admin')->with('success', 'Cập nhật thành công!');
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

    // 🔥 tăng view mỗi lần reload / truy cập
    $post->increment('views');

    return view('post', compact('post'));
}

public function byLocation($slug)
{
    $location = Location::where('slug', $slug)
        ->firstOrFail();

    $posts = $location->posts()
        ->paginate(4);

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
    $request->validate([
        'url' => 'required|url',
    ]);

    try {
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
        ])->timeout(15)->get($request->url);
    } catch (\Throwable $e) {
        $err = $e->getMessage();

        // nếu lỗi liên quan đến SSL (cURL 60 hoặc chứng chỉ self-signed), thử lại với verify=false
        if (stripos($err, 'curl error 60') !== false || stripos($err, 'SSL') !== false || stripos($err, 'self-signed') !== false) {
            try {
                $response = Http::withOptions(['verify' => false])->withHeaders([
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36',
                    'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                ])->timeout(15)->get($request->url);
            } catch (\Throwable $e2) {
                return response()->json([
                    'error' => 'Không thể truy cập URL đã nhập (SSL fallback thất bại): ' . $e2->getMessage(),
                ], 422);
            }
        } else {
            return response()->json([
                'error' => 'Không thể truy cập URL đã nhập: ' . $err,
            ], 422);
        }
    }

    if (!isset($response) || $response->failed()) {
        return response()->json(['error' => 'Không thể truy cập URL đã nhập.'], 422);
    }

    $html = $response->body();
    libxml_use_internal_errors(true);
    $dom = new \DOMDocument();
    if (!@$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'))) {
        return response()->json(['error' => 'Không thể phân tích HTML của URL.'], 422);
    }
    $xpath = new \DOMXPath($dom);

    $title = $this->getMetaValue($xpath, [
        '//title',
        '//meta[@property="og:title"]/@content',
        '//meta[@name="twitter:title"]/@content',
        '//meta[@name="title"]/@content',
    ]);

    $author = $this->getMetaValue($xpath, [
        '//meta[@name="author"]/@content',
        '//meta[@property="article:author"]/@content',
        '//meta[@name="article:author"]/@content',
        '//meta[@name="twitter:creator"]/@content',
    ]);

    $location = $this->getMetaValue($xpath, [
        '//meta[@property="article:section"]/@content',
        '//meta[@name="section"]/@content',
        '//meta[@property="og:site_name"]/@content',
        '//meta[@name="application-name"]/@content',
    ]);
    if (empty($location)) {
        $location = parse_url($request->url, PHP_URL_HOST) ?: '';
    }

    $imageUrl = $this->getMetaValue($xpath, [
        '//meta[@property="og:image"]/@content',
        '//meta[@property="og:image:secure_url"]/@content',
        '//meta[@itemprop="thumbnailUrl"]/@content',
        '//meta[@name="twitter:image"]/@content',
        '//meta[@name="twitter:image:src"]/@content',
        '//meta[@name="image"]/@content',
    ]);

    $content = $this->extractMainContent($dom, $xpath);

    return response()->json([
        'title' => $title,
        'location' => $location,
        'author' => $author,
        'content' => $content,
        'image_url' => $imageUrl,
    ]);
}

private function getMetaValue(\DOMXPath $xpath, array $queries)
{
    foreach ($queries as $query) {
        $nodes = $xpath->query($query);
        if ($nodes && $nodes->length) {
            $value = trim($nodes->item(0)->nodeValue);
            if ($value !== '') {
                return $value;
            }
        }
    }
    return '';
}

private function extractMainContent(\DOMDocument $dom, \DOMXPath $xpath)
{
    $paragraphs = [];

    $articleNodes = $xpath->query('//article//p');
    if ($articleNodes && $articleNodes->length > 0) {
        foreach ($articleNodes as $node) {
            $text = trim($node->textContent);
            if ($text !== '') {
                $paragraphs[] = preg_replace('/\s+/', ' ', $text);
            }
            if (count($paragraphs) >= 6) {
                break;
            }
        }
    }

    if (empty($paragraphs)) {
        $mainNodes = $xpath->query('//main//p | //div[contains(translate(@class, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz"), "content")]//p | //div[contains(translate(@id, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz"), "content")]//p | //div[contains(translate(@class, "ABCDEFGHIJKLMNOPQRSTUVWXYZ", "abcdefghijklmnopqrstuvwxyz"), "article")]//p');
        if ($mainNodes && $mainNodes->length > 0) {
            foreach ($mainNodes as $node) {
                $text = trim($node->textContent);
                if ($text !== '') {
                    $paragraphs[] = preg_replace('/\s+/', ' ', $text);
                }
                if (count($paragraphs) >= 6) {
                    break;
                }
            }
        }
    }

    if (empty($paragraphs)) {
        $bodyParagraphs = $xpath->query('//body//p');
        if ($bodyParagraphs && $bodyParagraphs->length > 0) {
            foreach ($bodyParagraphs as $node) {
                $text = trim($node->textContent);
                if ($text !== '') {
                    $paragraphs[] = preg_replace('/\s+/', ' ', $text);
                }
                if (count($paragraphs) >= 6) {
                    break;
                }
            }
        }
    }

    if (empty($paragraphs)) {
        $description = $this->getMetaValue($xpath, [
            '//meta[@property="og:description"]/@content',
            '//meta[@name="twitter:description"]/@content',
            '//meta[@name="description"]/@content',
        ]);
        if ($description !== '') {
            return $description;
        }
    }

    return implode("\n\n", array_slice($paragraphs, 0, 6));
}

private function getDashboardStats()
{
    return [
        'totalPosts' => Post::count(),
        'todayPosts' => Post::whereDate('created_at', today())->count(),
        'totalViews' => Post::sum('views'),
        'totalUsers' => User::where('role', 'user')->count(),
    ];
}

private function getPosts()
{
    return Post::latest()->get();
}
public function edit($id)
{
    $post = Post::with('locations')->findOrFail($id);

    // convert locations thành chuỗi "A, B, C"
    $locationString = $post->locations
        ->pluck('name')
        ->implode(', ');

    return view('editpost', compact('post', 'locationString'));
}

public function destroy($id)
{
    $post = Post::with('locations')->findOrFail($id);

    // nếu có file ZIP / background thì có thể xóa thêm (tuỳ bạn)
    DB::table('posts')->where('id', $id)->delete();

    return redirect('/admin')->with('success', 'Xóa bài viết thành công!');
}
}
