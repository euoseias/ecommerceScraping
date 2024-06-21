<?php

namespace App\Http\Controllers;
use Goutte\Client;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    private $result = array();

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));

    }
}
