<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Portfolio;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = 'Portfolio';
        $portfolio = Portfolio::orderBy('date', 'desc')->where([
            ['name', '!=', Null],
            [function($query) use ($request){
                if($request->name)
                    $query->where('name', 'LIKE', '%'.$request->name.'%');
                if($request->date)
                    $query->where('date', $request->date);
            }]
        ]);
        
        $data['portfolio'] = $portfolio->paginate(20)->appends($request->except(['page']));
        return view('dashboard.portfolio.index', $data);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Portfolio- New';
        return view('dashboard.portfolio.form', $data);   
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data= ['msg' => "Something went wrong, please try again", 'success'=>false];
        $validator =  \Validator::make($request->all(),[
            'name'=>'required|max:255|min:2'
        ]);

        if ($validator->fails())
        {
            $errors = '';
            foreach ($validator->getMessageBag()->toArray() as $vv) {
                $errors .= $vv[0]."<br />";
            }
            $data['error'] = $errors;
        }else{

            $dd = [
                'name' => $request->name,
                'slug' => \Str::slug($request->name),
                'teaser' => $request->teaser,
                'date' => $request->date,
                'publish' => $request->publish ? 1 : 0,
                'featured' => $request->featured ? 1 : 0,
                'content' => $request->content,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ];

            if($request->file('photo')){
                $dd['photo'] = uploadImage($request->file('photo'), '/images/');
            }
            if($request->file('banner_photo')){
                $dd['banner_photo'] = uploadImage($request->file('banner_photo'), '/images/');
            }

            $d = Portfolio::create($dd);
            // Log
            logThis(['type'=>'Portfolio', 'action'=>'ADD', 'item'=>$d->name]);
            // Return Message
            Session::flash('message',['type'=>'success', 'msg'=>'Item was added successfully.']);

            $data= ['msg' => "Item was added successfully", 'category'=>$d, 'success'=>true];
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $d = Portfolio::findOrFail($id);
        $data['d'] = $d;
        return view('dashboard.portfolio.stock', $data);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $d = Portfolio::findOrFail($id);
        $data['title'] = 'Portfolio- '.$d->name;
        $data['d'] = $d;
        return view('dashboard.portfolio.form', $data);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data= ['msg' => "Something went wrong, please try again", 'success'=>false];
        $validator =  \Validator::make($request->all(),[
            'name'=>'required|max:255|min:2'
        ]);
        $d = Portfolio::find($id);
        if(!$d){            
            $data['error'] = "Item not found";
        }
        else if ($validator->fails())
        {
            $errors = '';
            foreach ($validator->getMessageBag()->toArray() as $vv) {
                $errors .= $vv[0]."<br />";
            }
            $data['error'] = $errors;
        }else{

            $dd = [
                'name' => $request->name,
                'date' => $request->date,
                'teaser' => $request->teaser,
                'publish' => $request->publish ? 1 : 0,
                'featured' => $request->featured ? 1 : 0,
                'content' => cleanBase64Content($request->content),
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ];

            
            if($request->file('photo')){
                $dd['photo'] = uploadFile($request->file('photo'), '/images/');
            }
            if($request->file('banner_photo')){
                $dd['banner_photo'] = uploadImage($request->file('banner_photo'), '/images/');
            }

            $d->update($dd);
            // Log
            logThis(['type'=>'Portfolio', 'action'=>'UPDATE', 'item'=>$d->name]);
            // Return Message
            Session::flash('message',['type'=>'success', 'msg'=>'Item was updated successfully.']);

            $data= ['msg' => "Portfolio was updated successfully", 'file'=>$d, 'success'=>true];
        }
        return response()->json($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Portfolio::find($id);
        if($delete->delete()){
            \DB::table('Portfolio')->where('id', $delete->id)->update(['deleted_by_id' => auth()->user()->id]);
            $d = \DB::table('Portfolio')->where('id', $delete->id)->first();
            // Log
            logThis(['type'=>'Portfolio', 'action'=>'DELETE', 'item'=>$d->name]);
            // Return Message
            Session::flash('message',['type'=>'success', 'msg'=>'Item was deleted successfully.']);
        }else{            
            // Return Message
            Session::flash('message',['type'=>'danger', 'msg'=>'Something went wrong, please try gain.']);
        }

    }


}
