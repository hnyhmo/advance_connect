<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Stock;

class StockController extends Controller
{
    public function show($id){
        $a = Stock::where('item_id', $id)->findOrFail();
        return $a;
    }

}
