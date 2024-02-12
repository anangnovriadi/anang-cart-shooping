<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CartController extends Controller
{
    public function list() {
        $carts = Cart::all();
        $carts = DB::table('carts')
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->select('carts.id', 'carts.qty', 'carts.sub_total', 'carts.product_id', 'products.image', 'products.name', 'products.code', 'products.price', 'carts.code_discount')
            ->get();
        
        $getTotal = DB::select("select sum(sub_total) as total from carts");
        $code_discount = '';
        $total = 0;
        
        if (count($carts) > 0) {
            $total = $getTotal[0]->total;
            $code_discount = $carts[0]->code_discount;
            $day = Carbon::now()->format('l');
            $time = Carbon::now()->format('H:m');

            if ($carts[0]->code_discount === 'FA111') {
                $total = $total - ($total * 0.10);
            } 

            if ($carts[0]->code_discount === 'FA222') {
                $total = $total - 50000;
            } 

            if ($carts[0]->code_discount === 'FA333') {
                if ($total >= 400000) {
                    $total = $total - ($total * 0.06);
                }
            } 

            if ($day === 'Tuesday' && ($time > '13:00' && $time < '15:00')) {
                $total = $total - ($total * 0.05);
            }
        }
        
        $qty_data = [1, 2, 3, 4];
        $count = DB::table('carts')->count();

        return view('cart', compact('carts', 'total', 'code_discount', 'qty_data', 'count'));
    }

    public function addCart(Request $req) {
        $product = Product::find($req->input('product_id'));

        $cart = Cart::create([
            'product_id' => $req->input('product_id'),
            'qty' => 1,
            'code_discount' => '',
            'sub_total' => $product->price
        ]);

        return redirect()->route('product.list');
    }

    public function updateCart(Request $req) {
        $cart = $post = Cart::findOrFail($req->input('id'));
        $product = Product::findOrFail($cart->product_id);
        $subTotal = $req->input('qty') * $product->price;

        $cart->update([
            'qty' => $req->input('qty'),
            'sub_total' => $subTotal
        ]);

        return redirect()->route('cart.list');
    }

    public function updateDiscount(Request $req) {
        DB::table('carts')->update(array('code_discount' => strtoupper($req->input('code'))));

        return redirect()->route('cart.list');
    }   

    public function destroy($id) {
        $cart = Cart::find($id);
        $cart->delete();

        return redirect()->route('cart.list');
    }

    public function updateQty(Request $req) {
        $cart = $post = Cart::findOrFail($req->input('id'));
        $product = Product::findOrFail($cart->product_id);
        $subTotal = $req->input('qty') * $product->price;

        $cart->update([
            'qty' => $req->input('qty'),
            'sub_total' => $subTotal
        ]);

        return redirect()->route('cart.list');
    }
}
