<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmploymentResource extends JsonResource
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
          'company_name'=>$this->company_name,
          'joining_date'=>$this->joining_date,
          'relieving_date'=>$this->relieving_date,
          'salary_per_annum'=>$this->salary_per_annum,
          'city'=>$this->city
      );  
    }
}
