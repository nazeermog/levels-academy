<?php

namespace  DataSource\Repositories\DB\Taxonomy\Student;


use Modules\DataResource\Entities\Taxonomy\Taxonomy;

class StudentTaxonomyRepository
{
    public function getCategories($GuestId)
    {
        $taxonomies = Taxonomy::where('is_active', 1)
            ->where('id', $GuestId)
            ->whereHas('Guests', function ($q) use ($GuestId) {
                return $q->where('Guest_id',$GuestId);
            })
            ->get();
        return [
            'data' => [
                'data' => $taxonomies,
                'status' => true,
                'message' => 'success'
            ],
            'code' => 200
        ];
    }
}
