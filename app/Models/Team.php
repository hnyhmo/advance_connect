<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'team';

    protected $fillable = [
      'name',
      'slug',
      'teaser',
      'content',
      'photo',
      'date',
      'publish',
      'meta_title',
      'meta_description',
      'deleted_by_id',
      'deleted_at',
      'created_by',
      'updated_by',
    ];

}
