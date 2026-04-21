<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use ZipArchive;

class PostController extends Controller
{
    public function form()
    {
        return view('admin');
    }

    public function upload(Request $request)
{
    // ✅ validate (đã bỏ dateposted)
    $request->validate([
        'title' => 'required',
        'location' => 'required',
        'author' => 'required',
        'zipfile' => 'required|file',
        'background' => 'required|image',
    ]);

    // 📁 tạo folder uploads
    $time = time();
    $baseFolder = public_path('uploads/' . $time);
    mkdir($baseFolder, 0777, true);

    // 📦 giải nén ZIP
    $zip = new ZipArchive;

    if ($zip->open($request->file('zipfile')->getRealPath()) !== TRUE) {
        return "Không mở được file ZIP";
    }

    $zip->extractTo($baseFolder);
    $zip->close();

    // 🔍 tìm index.html
    $htmlFile = null;

    foreach (new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($baseFolder)) as $file) {
        if ($file->getFilename() === 'index.html') {
            $htmlFile = $file->getPathname();
            break;
        }
    }

    if (!$htmlFile) {
        return "Không tìm thấy index.html";
    }

    // 📄 đọc nội dung HTML
    $content = file_get_contents($htmlFile);

    // 📂 lấy đường dẫn folder chứa index.html
    $relativePath = str_replace(public_path(), '', dirname($htmlFile));
    $relativePath = str_replace('\\', '/', $relativePath);

    // 🔥 chuẩn hóa content
    $content = str_replace('\\', '/', $content);
    $content = str_replace('./', '', $content);

    // 🔥 fix src (ảnh)
    $content = str_replace(
        'src="images/',
        'src="' . $relativePath . '/images/',
        $content
    );

    $content = str_replace(
        'src="./images/',
        'src="' . $relativePath . '/images/',
        $content
    );

    // 🔥 fix srcset (picture)
    $content = str_replace(
        'srcset="images/',
        'srcset="' . $relativePath . '/images/',
        $content
    );

    $content = str_replace(
        'srcset="./images/',
        'srcset="' . $relativePath . '/images/',
        $content
    );

    // 🖼 upload background
    $bgPath = null;

    if ($request->hasFile('background')) {
        $bg = $request->file('background');

        $bgName = time() . '_' . $bg->getClientOriginalName();
        $bg->move(public_path('uploads/backgrounds'), $bgName);

        $bgPath = '/uploads/backgrounds/' . $bgName;
    }

    // 💾 lưu DB
    DB::table('posts')->insert([
        'title' => $request->title,
        'location' => $request->location,
        'author' => $request->author,

        // 🔥 luôn lấy thời gian hiện tại
        'dateposted' => now(),

        'content' => $content,
        'background' => $bgPath,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->back()->with('success', 'Upload thành công');
}
    

    public function index()
    {
        $posts = DB::table('posts')->orderBy('id', 'desc')->paginate(4);
        return view('home', compact('posts'));
    }
    public function show($id)
{
    $post = DB::table('posts')->where('id', $id)->first();
    return view('post', compact('post'));
}

public function byLocation($location)
{
    $posts = Post::where('location', $location)->paginate(4);

    return view('location', compact('posts', 'location'));
}
}
