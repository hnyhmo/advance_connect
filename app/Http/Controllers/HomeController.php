<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Portfolio;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['page'] = Page::where('slug', "home")->where('publish', 1)->first();
        $data['portfolio']  = Portfolio::where('publish', 1)->where('featured', 1)->orderBy('date', 'desc')->take(10)->get();
        $data['products']   = Product::where('publish', 1)->where('featured', 1)->orderBy('date', 'desc')->take(10)->get();
        $data['brand']      = Brand::where('publish', 1)->where('featured', 1)->orderBy('date', 'desc')->get();
        if(!$data['page']) abort('404');
        $data['meta_title'] = $data['page']->meta_title;
        $data['meta_description'] = $data['page']->meta_description;

        $data['slug'] = 'home';
        return view('frontend.home', $data);
    }

    /**
     * Endpoint to submit contact us inquiries.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function contact_us_now(Request $request)
    {
        $data = [];
        // recaptcha secret - 6LfexIgkAAAAAN0UC9y37fsCgiRPZzn9336VOHaF
        $validator =  \Validator::make($request->all(),[
            'first_name'=>'required|max:255|min:2',
            'last_name'=>'required|max:255|min:2',
            'email'=>'email|required|max:255|min:2',
            'message'=>'required|max:255|min:2',
            'g-recaptcha-response'=>'required',
        ]);
        
        if ($validator->fails())
        {
            $errors = '';
            foreach ($validator->getMessageBag()->toArray() as $vv) {
                $errors .= "<p class='full' style='color:red'>".$vv[0]."</p>";
            }
            
            return back()->with('error', $errors);
        } 
        elseif(!$this->validateCaptcha($request->get('g-recaptcha-response'))){
            return back()->with('success', "<p class='full' style='color:red'>Invalid Recaptcha</p>");
        }
        else{
            
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <webmaster@example.com>' . "\r\n";
            $headers .= 'Cc: myboss@example.com' . "\r\n";
            $fullname = $request->first_name.' '.$request->last_name;
            
            $message = 'test';

            @mail($request->email, "Contact Us Inquiry - ".$fullname, $message,$headers);
            
            return back()->with('success', "<p class='full' style='color:green'>Message sent</p>");
        }
        

    }

    protected function validateCaptcha($captcha=''){
        $response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LfexIgkAAAAAN0UC9y37fsCgiRPZzn9336VOHaF&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']), true);
        return $response['success'];
    }
}
