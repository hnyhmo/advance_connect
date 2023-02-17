<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'logs';

    protected $fillable = [
      'type',
      'action',
      'item',
      'user_id',
      'user_data',
      'created_by',
      'updated_by',
    ];
    
    public function user(){
      return $this->hasOne(User::class,'id', 'user_id');
    }

}
