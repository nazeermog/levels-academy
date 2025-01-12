<?php

namespace DataSource\Repositories\DB\Blog\Admin;

use DataSource\Entities\Blog\Blog;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminBlogRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Blog::class;

    public static function list()
    {
        return Blog::all();
    }
}
