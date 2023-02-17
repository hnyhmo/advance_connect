<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Warehouse;
use App\Models\Item;
use App\Models\Log;
use App\Models\User;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $data = [];
        $data['transactions'] = Transaction::all();
        $data['items'] = Item::count();
        $data['pages'] = 0;
        $data['fs'] = 0;
        $data['logs'] = Log::orderBy('id', 'desc')->take(4)->get();
        $data['users'] = User::where('email', '!=', 'api@smc.com')->count();
        $data['title'] = "Reports";

        $files = [];
        foreach(getMonths() as $k => $m){
            $total_cnt = 0;
            $transactions = Transaction::where('type', 'out')->whereMonth('created_at', $k)->whereYear('created_at', date('Y'))->get();
            
            foreach($transactions as $t){
                $total_cnt += getTransactionTotal($t->id);
            }

            $files[$k] = [
                'month' => $m['month'],
                'cnt' =>  $total_cnt,
            ];
        }
        $data['uploads'] = $files;

        $cms = [];
        foreach(getMonths() as $k => $m){
            $cms[$k] = [
                'month' => $m['month'],
                'cnt' =>  Log::whereMonth('created_at', $k)->whereYear('created_at', date('Y'))->count(),
            ];
        }
        $data['cms'] = $cms;

        return view('dashboard.sales.index', $data);
    }
}