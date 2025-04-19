<?php

namespace DataSource\Http\Controllers\Admin\Blog;

use Illuminate\Http\Request;
use DataSource\Entities\Blog\Blog;
use Illuminate\Support\Facades\Storage;
use DataSource\Http\Requests\Admin\Blog\Store;
use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Lesson\Update;
use DataSource\Traits\Admin\AdminCRUDControllerActions;
use DataSource\Repositories\DB\Blog\Admin\AdminBlogRepository;

class AdminBlogController  extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.blogs';
    protected string $table_name = 'blogs';
    protected string $route_name = 'blogs';
    protected string $interface = AdminBlogRepository::class;
    //    protected string $interface_category = AdminCategoryRepository::class;
    protected string $store_request = Store::class;
    //    protected string $update_request = Update::class;
    //    protected $id_request = Id::class;
    public function store(Request $request)
    {
        $blog = new Blog;
        foreach (localeSupported() as $locale) {
            $blog->translateOrNew($locale)->title = $request['title-' . $locale];
            $blog->translateOrNew($locale)->desc = $request['desc-' . $locale];
        }

        $photo = $request->file('photo')->store('public/photos');
        $blog->photo = Storage::url($photo);
        $blog->user_id = $request->user_id;
        $blog->save();
        return redirect()->route('admin.blogs.index')->withSuccess('blog created successfully');
    }
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        foreach (localeSupported() as $locale) {
            $blog->translateOrNew($locale)->title = $request['title-' . $locale];
            $blog->translateOrNew($locale)->desc = $request['desc-' . $locale];
        }

        if ($request->hasFile('photo')) {
            if ($blog->photo) {
                Storage::delete(str_replace('/storage/', 'public/', $blog->photo));
            }
            $photo = $request->file('photo')->store('public/photos');
            $blog->photo = Storage::url($photo);
        }
        $blog->user_id = $request->user_id;
        $blog->save();

        return redirect()->route('admin.blogs.index')->withSuccess('blog updated successfully');
    }
}
