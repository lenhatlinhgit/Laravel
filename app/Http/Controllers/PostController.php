<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\User;
use ZipArchive;

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
        'background' => 'required|image|max:4096',
    ]);

    // Upload background
    $bg = $request->file('background');
    $bgName = time() . '_' . $bg->getClientOriginalName();
    $bg->move(public_path('uploads/backgrounds'), $bgName);
    $bgPath = '/uploads/backgrounds/' . $bgName;

    // Sanitize content (loại bỏ script độc hại)
    $content = clean($request->content);

    DB::table('posts')->insert([
        'title'      => $request->title,
        'location'   => $request->location,
        'author'     => $request->author,
        'dateposted' => now(),
        'content'    => $content,
        'background' => $bgPath,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

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
        'location'   => $request->location,
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

    DB::table('posts')->where('id', $id)->update($data);

    return redirect('/admin')->with('success', 'Cập nhật thành công!');
}

    public function index()
    {
        $posts = DB::table('posts')->orderBy('views', 'desc')->paginate(4);
        return view('home', compact('posts'));
    }
    public function show($id)
{
    $post = Post::findOrFail($id);

    // 🔥 tăng view mỗi lần reload / truy cập
    $post->increment('views');

    return view('post', compact('post'));
}

public function byLocation($location)
{
    $posts = Post::where('location', $location)->paginate(4);

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
    $post = Post::findOrFail($id);
    return view('editpost', compact('post'));
}

public function destroy($id)
{
    $post = Post::findOrFail($id);

    // nếu có file ZIP / background thì có thể xóa thêm (tuỳ bạn)
    DB::table('posts')->where('id', $id)->delete();

    return redirect('/admin')->with('success', 'Xóa bài viết thành công!');
}
}
