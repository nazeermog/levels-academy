<?php

namespace DataSource\Http\Controllers\Admin\Taxonomy;

use DataSource\Http\Controllers\BaseController;
use DataSource\Http\Requests\Admin\Taxonomy\Store;
use DataSource\Repositories\DB\Taxonomy\Admin\AdminTaxonomyRepository;
use DataSource\Traits\Admin\AdminCRUDControllerActions;

class AdminTaxonomyController extends BaseController
{
    use AdminCRUDControllerActions;

    protected string $module = 'datasource::management.taxonomy';
    protected string $table_name = 'Category';
    protected string $route_name = 'taxonomies';
    protected string $interface = AdminTaxonomyRepository::class;
    protected string $store_request = Store::class;
}
