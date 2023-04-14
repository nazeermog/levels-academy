<?php

namespace DataSource\Responses\Course\Student;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentCourseContentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->content->title,
            'type' => class_basename($this->content_type),
            'type_id' => $this->content_id,
        ];
    }

}
