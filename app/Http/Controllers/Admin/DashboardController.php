<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;


class DashboardController extends Controller
{
    public function index(Request $request){
        $data['title'] = 'Transactions';
        $transactions = Transaction::orderBy('date', 'desc')->where([
            ['or_num', '!=', Null],
            [function($query) use ($request){
                if($request->name)
                    $query->where('or_num', 'LIKE', '%'.$request->or_num.'%');
            }]
        ]);
        
        $data['transactions'] = $transactions->paginate(20)->appends($request->except(['page']));
        return view('dashboard.transaction.index', $data);
    }
    

}