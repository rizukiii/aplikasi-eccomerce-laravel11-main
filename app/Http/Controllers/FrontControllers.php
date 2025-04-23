<?php

namespace App\Http\Controllers;

use App\Models\Categories;
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
        $data = $this->frontService->getFrontPage();
        // dd($data);
        return view('front.index', $data);
    }

    public function details($prod)
    {
        // pengambilan data menggunakan method model binding
        $prod = Products::with('photos', 'sizes', 'categories', 'brands')->first();

        // dd($prod);
        $allProduct = Products::with('categories')->get();
        return view('front.details', compact('prod', 'allProduct'));
    }

    public function category($cat)
    {
        $cat = Categories::where('slug', $cat)->with('product.photos')->first();
        return view('front.category', compact('cat'));

    }
}
