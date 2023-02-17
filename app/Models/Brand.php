<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brand';

    protected $fillable = [
      'name',
      'slug',
      'description',
      'photo',
      'date',
      'publish',
      'featured',
      'meta_title',
      'meta_description',
      'deleted_by_id',
      'deleted_at',
      'created_by',
      'updated_by',
    ];

}
