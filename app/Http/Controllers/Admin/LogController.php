<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\User;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = 'System Logs';
        $logs = Log::orderBy('created_at', 'desc')->where([
            ['type', '!=', Null],
            [function($query) use ($request){
                if($request->type)
                    $query->where('type', 'LIKE', '%'.$request->type.'%');
                if($request->action)
                    $query->where('action', 'LIKE', '%'.$request->action.'%');
                if($request->item)
                    $query->where('item', 'LIKE', '%'.$request->item.'%');
            
            }]
        ]);
        
        $data['logs'] = $logs->paginate(20)->appends($request->except(['page']));
        $data['users'] = User::all();
        return view('dashboard.log.index', $data);   
    }

}
