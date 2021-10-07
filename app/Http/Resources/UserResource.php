<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\EmploymentResource;
use App\Http\Resources\EducationResource;
class UserResource extends JsonResource
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
        return array(
            'user_id' => $this->id,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name,
            'email'=>$this->email,
            'mobile'=>$this->mobile,
            'date_of_birth'=>$this->date_of_birth,
            'collage_name'=>$this->collage_name,
            'address'=>$this->address,
            'ratting' => $this->ratting, 
            'education_data'=> EducationResource::collection($this->educations),
            'employment_data'=> EmploymentResource::collection($this->employments),
        );
    }
}
