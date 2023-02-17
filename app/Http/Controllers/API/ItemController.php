<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(){
        $a = Item::with('warehouse')->paginate(30);
        return $a;
    }

    public function show($id){
        $a = Item::where('warehouse_id', $id)->findOrFail();
        return $a;
    }

}
