<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\MessOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use PhpParser\Node\Stmt\Block;

class BlogController extends Controller
{
    public function index()
    {
        $blog_categories = BlogCategory::get();
        $list_blog = Blog::with('blog_categories')->get();
        $messages = MessOrder::with('user','order')->get();
        return view('admin.blog.list', compact('list_blog','blog_categories','messages'));
    }

    public function submit_add_blog(BlogRequest $request)
    {
        $new_image = null;
        if ($request->hasFile('BlogImage')) {
            $image = $request->file('BlogImage');
            $get_name_image = $image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/blog/', $new_image);
        }
        $data=[
            'BlogTitle' => $request->BlogTitle,
            'BlogContent' => $request->BlogContent,
            'BlogSlug' => $request->BlogSlug,
            'Status' => $request->Status,
            'BlogDesc'=>$request->BlogDesc,
            'BlogImage' => $new_image,
            'blog_category_id' => $request->blog_category_id
        ];
        Blog::create($data);
        return redirect()->back()->with('message', 'Thêm bài viết thành công');
    }

    public function blog_details($BlogSlug)
    {
        $Blog = Blog::with('blog_categories')->where('BlogSlug', $BlogSlug)->first();
        $blog_categories = BlogCategory::get();
        $messages = MessOrder::with('user','order')->get();
        if ($Blog->Status != 0) {
            return view("admin.blog.blog-details")->with(compact('Blog','blog_categories','messages'));
        }
    }
    public function edit_blog($idBlog)
    {
        $blog = Blog::find($idBlog);
        $blog_categories = BlogCategory::get();
        $messages = MessOrder::with('user','order')->get();
        return view("admin.blog.edit-blog")->with(compact('blog','blog_categories','messages'));
    }

    public function submit_edit_blog(BlogRequest $request, $idBlog)
    {
        $blog = Blog::find($idBlog);
        $new_image = $blog->BlogImage;
        if ($request->hasFile('BlogImage')) {
            $image = $request->file('BlogImage');
            $get_name_image = $image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images/blog/', $new_image);
            Storage::delete('public/images/blog/' . $blog->BlogImage);
        }
        $data=[
            'BlogTitle' => $request->BlogTitle,
            'BlogContent' => $request->BlogContent,
            'BlogSlug' => $request->BlogSlug,
            'Status' => $request->Status,
            'BlogDesc'=>$request->BlogDesc,
            'BlogImage' => $new_image,
            'blog_category_id' => $request->blog_category_id
        ];
        $blog->update($data);
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

    public function destroy(Request $request)
    {
        $blog = Blog::findOrFail($request->idBlog);
        if ($blog->blog_image) {
            Storage::delete('public/storage/images/blog/' . $blog->BlogImage);
        }
        $blog->delete();
        return redirect()->route('admin.blog.list')->with('message', 'Bài viết đã được xóa thành công.');
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
