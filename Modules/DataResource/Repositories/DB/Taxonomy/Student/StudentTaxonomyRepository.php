<?php

namespace Modules\DataResource\Repositories\DB\Taxonomy\Student;


use Modules\DataResource\Entities\Taxonomy\Taxonomy;

class StudentTaxonomyRepository
{
    public function getCategories($partnerId)
    {
        $taxonomies = Taxonomy::where('is_active', 1)
            ->where('id', $partnerId)
            ->whereHas('partners', function ($q) use ($partnerId) {
                return $q->where('partner_id',$partnerId);
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
