<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'portfolio';

    protected $fillable = [
      'name',
      'slug',
      'teaser',
      'content',
      'photo',
      'banner_photo',
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
