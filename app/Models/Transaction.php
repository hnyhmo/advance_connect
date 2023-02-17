<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions';

    protected $fillable = [
      'warehouse_id',
      'type',
      'or_num',
      'consignee',
      'address',
      'deliver_to',
      'remarks',
      'date',
      'deleted_at',
      'created_by',
      'updated_by',
    ];

    public function stocks(){
      return $this->hasMany(Stock::class,'transaction_id');
    }
    
    public function warehouse(){
      return $this->hasOne(Warehouse::class,'id', 'warehouse_id');
    }
}
