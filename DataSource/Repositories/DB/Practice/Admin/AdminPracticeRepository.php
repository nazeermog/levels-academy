<?php

namespace DataSource\Repositories\DB\Practice\Admin;

use DataSource\Entities\Practice\Practice;

class AdminPracticeRepository
{
    public static function list()
    {
        return Practice::all();
    }
}
