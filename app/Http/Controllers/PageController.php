<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Team;
use App\Models\Product;
use App\Models\News;
use App\Models\Portfolio;

class PageController extends Controller
{

    /**
     * Show the application index.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function page($slug)
    {
        $data['page'] = Page::where('slug', $slug)->where('publish', 1)->first();
        if(!$data['page']) abort('404');
        $data['meta_title'] = $data['page']->meta_title;
        $data['meta_description'] = $data['page']->meta_description;

        if($data['page']->slug === 'the-team'){
            $data['team'] = Team::where('publish', 1)->orderBy('date', 'desc')->get();
        }

        if($data['page']->slug === 'products'){
            $data['product'] = Product::where('type', 'product')->where('publish', 1)->orderBy('date', 'desc')->get();
        }

        if($data['page']->slug === 'news-and-awards'){
            $data['featured_news'] = News::where('publish', 1)->where('featured', 1)->orderBy('date', 'desc')->first();
            $data['news'] = News::where('publish', 1)->orderBy('date', 'desc')->paginate(9);
        }

        if($data['page']->slug === 'portfolio'){
            $data['portfolio'] = Portfolio::where('publish', 1)->orderBy('date', 'desc')->get();
        }

        if($data['page']->slug === 'services'){
            $data['service'] = Product::where('type', 'service')->where('publish', 1)->orderBy('date', 'desc')->get();
        }
        
        $data['slug'] = $data['page']->slug;

        return view('frontend.page', $data);
    }


    /**
     * Show the application product inner page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function productInner($slug)
    {
        $data['product'] = Product::where('slug', $slug)->where('type', 'product')->where('publish', 1)->first();
        if(!$data['product']) abort('404');
        $data['meta_title'] = $data['product']->meta_title;
        $data['meta_description'] = $data['product']->meta_description;
        $data['service'] = Product::where('type', 'service')->where('publish', 1)->orderBy('date', 'desc')->take(3)->get();
        
        $data['slug'] = 'products';
        return view('frontend.product_inner', $data);
    }
    
    /**
     * Show the application service inner page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function serviceInner($slug)
    {
        $data['service'] = Product::where('slug', $slug)->where('type', 'service')->where('publish', 1)->first();
        if(!$data['service']) abort('404');
        $data['meta_title'] = $data['service']->meta_title;
        $data['meta_description'] = $data['service']->meta_description;

        $data['slug'] = 'services';
        return view('frontend.service_inner', $data);
    }

    /**
     * Show the application news inner page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function newsInner($slug)
    {
        $data['news'] = News::where('slug', $slug)->where('publish', 1)->first();
        if(!$data['news']) abort('404');
        $data['meta_title'] = $data['news']->meta_title;
        $data['meta_description'] = $data['news']->meta_description;

        $data['slug'] = 'news-and-awards';
        return view('frontend.news_inner', $data);
    }
    
    /**
     * Show the application service inner page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function portfolioInner($slug)
    {
        $data['portfolio'] = Portfolio::where('slug', $slug)->where('publish', 1)->first();
        if(!$data['portfolio']) abort('404');
        $data['meta_title'] = $data['portfolio']->meta_title;
        $data['meta_description'] = $data['portfolio']->meta_description;

        $data['slug'] = 'portfolio';
        return view('frontend.portfolio_inner', $data);
    }
    
}
