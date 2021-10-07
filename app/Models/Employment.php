<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employment extends Model
{
    use HasFactory;
    use SoftDeletes;

     protected $fillable = [
        'user_id',
        'company_name',
        'joining_date',
        'relieving_date',
        'salary_per_annum',
        'city',
    ];
}
