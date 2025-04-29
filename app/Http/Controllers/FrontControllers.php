<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ProductImages;
use App\Models\Products;
use App\Services\FrontService;
use Illuminate\Http\Request;

class FrontControllers extends Controller
{

    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }

    public function index()
    {
        // dd(session()->all());
        $data = $this->frontService->getFrontPage();

        return view('front.index', $data);
    }

    public function details($slug)
    {
        $product = Products::where('slug',$slug)->with('photos')->first();
        $allProduct = Products::with('categories')->get();
        $productImages = ProductImages::where('products_id', $product->id)->get();


        return view('front.details', compact('product', 'allProduct','productImages'));
    }

    public function category($slug)
    {
        $category = Categories::where('slug', $slug)->with('product.photos')->first();

        return view('front.category', compact('category'));

    }

    public function allProduct(){
        $products = Products::all();
        return view('front.products',compact('products'));
    }
}
