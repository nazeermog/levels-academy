<?php

namespace DataSource\Repositories\DB\Taxonomy\Admin;

use DataSource\Entities\Taxonomy\Taxonomy;
use DataSource\Traits\Admin\AdminCRUDGenericRepository;

class AdminTaxonomyRepository
{
    use AdminCRUDGenericRepository;

    protected $model = Taxonomy::class;
}
