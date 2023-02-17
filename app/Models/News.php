<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
      'name',
      'slug',
      'teaser',
      'content',
      'photo',
      'banner_photo',
      'date',
      'featured',
      'publish',
      'type',
      'meta_title',
      'meta_description',
      'deleted_by_id',
      'deleted_at',
      'created_by',
      'updated_by',
    ];

}
