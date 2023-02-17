<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['title'] = 'Products and Services';
        $products = Product::orderBy('date', 'desc')->where([
            ['name', '!=', Null],
            [function($query) use ($request){
                if($request->name)
                    $query->where('name', 'LIKE', '%'.$request->name.'%');
                if($request->date)
                    $query->where('date', $request->date);
            }]
        ]);
        
        $data['products'] = $products->paginate(20)->appends($request->except(['page']));
        return view('dashboard.product.index', $data);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = 'Product - New';
        return view('dashboard.product.form', $data);   
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
                'date' => $request->date,
                'content' => $request->content,
                'publish' => $request->publish ? 1 : 0,
                'featured' => $request->featured ? 1 : 0,
                'type' => $request->type,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
            ];

            if($request->file('photo')){
                $dd['photo'] = uploadImage($request->file('photo'), '/images/');
            }
            if($request->file('banner_photo')){
                $dd['banner_photo'] = uploadImage($request->file('banner_photo'), '/images/');
            }

            $d = Product::create($dd);
            // Log
            logThis(['type'=>'Product', 'action'=>'ADD', 'item'=>$d->name]);
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
        $d = Product::findOrFail($id);
        $data['d'] = $d;
        return view('dashboard.product.stock', $data);   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $d = Product::findOrFail($id);
        $data['title'] = 'Product - '.$d->name;
        $data['d'] = $d;
        return view('dashboard.product.form', $data);   
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
        $d = Product::find($id);
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
                'content' => cleanBase64Content($request->content),
                'publish' => $request->publish ? 1 : 0,
                'featured' => $request->featured ? 1 : 0,
                'type' => $request->type,
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
            logThis(['type'=>'Product', 'action'=>'UPDATE', 'item'=>$d->name]);
            // Return Message
            Session::flash('message',['type'=>'success', 'msg'=>'Item was updated successfully.']);

            $data= ['msg' => "Product was updated successfully", 'file'=>$d, 'success'=>true];
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
        $delete = Product::find($id);
        if($delete->delete()){
            \DB::table('product')->where('id', $delete->id)->update(['deleted_by_id' => auth()->user()->id]);
            $d = \DB::table('product')->where('id', $delete->id)->first();
            // Log
            logThis(['type'=>'Product', 'action'=>'DELETE', 'item'=>$d->name]);
            // Return Message
            Session::flash('message',['type'=>'success', 'msg'=>'Item was deleted successfully.']);
        }else{            
            // Return Message
            Session::flash('message',['type'=>'danger', 'msg'=>'Something went wrong, please try gain.']);
        }

    }


}
