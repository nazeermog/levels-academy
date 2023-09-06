<?php

namespace DataSource\Repositories\DB\Taxonomy\Admin;

use DataSource\Entities\Taxonomy\Taxonomy;
use DataSource\Http\Requests\Admin\Taxonomy\Store;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminTaxonomyRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Taxonomy::class;
    protected string $module = 'datasource::management.taxonomy';
    protected string $table_name = 'categories';
    protected string $route_name = 'taxonomy';
    protected string $store_request = Store::class;

    public static function list()
    {
        return Taxonomy::all();
    }
}
