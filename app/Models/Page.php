<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'page';

    protected $fillable = [
      'name',
      'slug',
      'teaser',
      'content',
      'photo',
      'date',
      'featured',
      'publish',
      'locked',
      'meta_title',
      'meta_description',
      'deleted_by_id',
      'deleted_at',
      'created_by',
      'updated_by',
    ];

}
