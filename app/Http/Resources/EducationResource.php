<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return  array(
            'title' => $this->title,
            'passing_year' => $this->passing_year,
            'total_marks' => $this->total_marks,
            'obtain_marks' => $this->obtain_marks,
            'university_name' => $this->university_name
        );
    }
}
