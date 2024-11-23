<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\StoreBlogRequest;
use App\Models\Blog;
use App\Models\Blog_categories;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Block;

class BlogController extends Controller
{
    public function index()
    {
        // Lấy danh sách bài viết từ cơ sở dữ liệu (nếu có)
        $list_blog = Blog::get(); // Thay thế bằng logic lấy dữ liệu từ model
        // dd($blogs);
        return view('admin.blog.list', compact('list_blog'));
    }

    public function submit_add_blog(Request $request)
    {
        $data = $request->all();
        $blog = new Blog();

        $blog->BlogTitle = $data['BlogTitle'];
        $blog->BlogContent = $data['BlogContent'];
        $blog->Status = $data['Status'];
        $blog->BlogDesc = $data['BlogDesc'];
        $blog->BlogSlug = $data['BlogSlug'];

        $image = $request->file('BlogImage');
        $get_name_image = $image->getClientOriginalName();
        $name_image = current(explode('.', $get_name_image));
        $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images/blog', $new_image);
        $blog->BlogImage = $new_image;

        $blog->save();
        return redirect()->back()->with('insert-message', 'Thêm bài viết thành công');
    }


    public function blog_details($BlogSlug)
    {

        $Blog = Blog::where('BlogSlug', $BlogSlug)->first();


        if ($Blog->Status != 0){
        return view("admin.blog.blog-details")->with(compact('Blog'));
        }
    }
    public function edit_blog($idBlog)
    {
        $blog = Blog::where('idBlog', $idBlog)->first();

        return view("admin.blog.edit-blog")->with(compact('blog'));
    }

    public function submit_edit_blog(Request $request, $idBlog)
    {
        $data = $request->all();
        $blog = Blog::find($idBlog);

        $blog->BlogTitle = $data['BlogTitle'];
        $blog->BlogContent = $data['BlogContent'];
        $blog->Status = $data['Status'];
        $blog->BlogDesc = $data['BlogDesc'];
        $blog->BlogSlug = $data['BlogSlug'];

        if ($request->file('BlogImage')) {
            $image = $request->file('BlogImage');
            $get_name_image = $image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/blog/', $new_image);
            $blog->BlogImage = $new_image;

            $get_old_img = Blog::where('idBlog', $idBlog)->first();
            Storage::delete('public/images/blog/' . $get_old_img->BlogImage);
        }
        $blog->save();
        return redirect()->back()->with('message', 'Sửa bài viết thành công');
    }

    // public function category( ){
    //     $blog_categories = Blog_categories::paginate(5);

    //     return view('admin.blog.category', compact('blog_categories'));
    // }

    // public function categoryWithBlog(Request $request)
    // {
    //     // $blog_categories = Blog_categories::find($request->id);
    //     // $blogs = $blog_categories->blogs()->get();
    //     $blog_categories = Blog_categories::paginate(5);
    //     $categoryFollowId = Blog_categories::findOrFail($request->id);
    //     $blogs = $categoryFollowId->blogs()->get();
    //     $blogCount = $categoryFollowId->blogs()->count();
    //     // Create an array to store the information
    //     // $data = [
    //     //     'category_name' => $category->blog_categories_name,
    //     //     'blog_count' => $blogCount,
    //     //     'blogs' => $blogs,
    //     // ];
    //     // dd($blogs);


    //     return view('admin.blog.category', compact('categoryFollowId', 'blogs', 'blogCount', 'blog_categories'));
    //     // return view('admin.blog.category', compact('blog_categories'));
    // }


    // public function addBlog(StoreBlogRequest $request)
    // {
    //     // Tạo mới Blog và lưu trữ dữ liệu
    //     $blog = new Blog();
    //     $blog->status = $request->status;
    //     $blog->title = $request->title;
    //     $blog->short_content = $request->short_content;
    //     $blog->author = $request->author;
    //     $blog->full_content = $request->full_content;
    //     $blog->category_id = $request->category_id;
    //     $blog->published_at = now();

    //     // Lưu ảnh chính bài viết
    //     if ($request->hasFile('blog_image')) {
    //         $imagePath = $request->file('blog_image')->store('public/blog_images');
    //         $blog->blog_image = basename($imagePath);
    //     }

    //     // Lưu danh sách ảnh
    //     if ($request->hasFile('list_image')) {
    //         $listImages = [];
    //         foreach ($request->file('list_image') as $image) {
    //             $imagePath = $image->store('public/blog_images');
    //             $listImages[] = basename($imagePath);
    //         }
    //         $blog->list_image = json_encode($listImages); // lưu dưới dạng JSON
    //     }

    //     // Lưu blog vào database
    //     $blog->save();

    //     // Chuyển hướng sau khi lưu thành công
    //     return redirect()->route('admin.blog.list')->with('insert-message', 'Thêm dữ liệu thành công');
    // }

    // public function Blog_categories_destroy(Request $request)// Xóa danh mục bài viết
    // {
    //     $blog_category = Blog_categories::find($request->id);
    //     $blog_category->delete();
    //     return redirect()->route('admin.blog.category')->with('delete-message', 'Xóa dữ liệu thành công');
    // }

    // public function update(BlogCategoriesRequest $request)
    // {
    //     // $data = $request->all();
    //     $data = $request->except('_token', '_method');
    //     Blog_categories::where('id', $request->id)->update($data);
    //     return redirect()->back()->with('insert-message', 'Cập nhật dữ liệu thành công');
    // }

    public function destroy($id)
    {
        // Tìm blog theo ID và xóa nó
        $blog = Blog::findOrFail($id);

        // Xóa ảnh nếu có
        if ($blog->blog_image) {
            Storage::delete('public/storage/images/blog/' . $blog->BlogImage);
        }


        // Xóa bài blog
        $blog->delete();

        // Thông báo xóa thành công
        return redirect()->route('admin.blog.list')->with('delete-message', 'Blog đã được xóa thành công.');
    }
    // public function updateBlog(Request $request, $id)
    // {
    //     $request->validate([
    //         'status' => 'required',
    //         'blog_image' => 'nullable|image',
    //         'list_image' => 'nullable|array',
    //         'title' => 'required|string|max:255',
    //         'short_content' => 'nullable|string',
    //         'author' => 'nullable|string|max:255',
    //         'full_content' => 'required|string',
    //         'category_id' => 'required|exists:blog_categories,id',
    //     ]);

    //     $blog = Blog::findOrFail($id);
    //     $blog->status = $request->status;
    //     $blog->title = $request->title;
    //     $blog->short_content = $request->short_content;
    //     $blog->author = $request->author;
    //     $blog->full_content = $request->full_content;
    //     $blog->category_id = $request->category_id;

    //     // Lưu ảnh chính bài viết
    //     if ($request->hasFile('blog_image')) {
    //         $imagePath = $request->file('blog_image')->store('public/blog_images');
    //         $blog->blog_image = basename($imagePath);
    //     }

    //     // Lưu danh sách ảnh
    //     if ($request->hasFile('list_image')) {
    //         $listImages = [];
    //         foreach ($request->file('list_image') as $image) {
    //             $imagePath = $image->store('public/blog_images');
    //             $listImages[] = basename($imagePath);
    //         }
    //         $blog->list_image = json_encode($listImages); // lưu dưới dạng JSON
    //     }

    //     $blog->save();

    //     return redirect()->route('admin.blog.list')->with('update-message', 'Cập nhật bài viết thành công');
    // }


}
