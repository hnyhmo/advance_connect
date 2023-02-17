<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPassword extends Model
{
    use HasFactory;

    protected $table = 'user_passwords';

    protected $fillable = [
      'user_id',
      'password',
      'created_by',
      'updated_by',
    ];

}
