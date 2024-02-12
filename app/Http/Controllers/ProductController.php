<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function list() {
        $products = Product::all();
        $count = DB::table('carts')->count();

        return view('product', compact('products', 'count'));
    }
}
