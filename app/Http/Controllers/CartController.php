<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Log;

class CartController extends Controller
{
    public function shop()
    {
        $products = Product::all();
        Log::info('$products');
        Log::info($products);

        return view('shop')
            ->withTitle('E-COMMERCE STORE | SHOP')
            ->with(['products' => $products]);
    }

    public function cart()
    {
        $cartCollection = \Cart::getContent();
        Log::info('$cartCollection');
        Log::info($cartCollection);

        return view('cart')
            ->withTitle('E-COMMERCE STORE | CART')
            ->with(['cartCollection' => $cartCollection]);;
    }

    public function add(Request $request): RedirectResponse
    {
        \Cart::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->img,
                'slug' => $request->slug
            )
        ));
        return redirect()
            ->route('cart.index')
            ->with('success_msg', 'Item is Added to Cart!');
    }

    public function remove(Request $request): RedirectResponse
    {
        \Cart::remove($request->id);
        return redirect()
            ->route('cart.index')
            ->with('success_msg', 'Item is removed!');
    }

    public function update(Request $request): RedirectResponse
    {
        \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            ));

        return redirect()
            ->route('cart.index')
            ->with('success_msg', 'Cart is Updated!');
    }

    public function clear(): RedirectResponse
    {
        \Cart::clear();
        return redirect()
            ->route('cart.index')
            ->with('success_msg', 'Cart is cleared!');
    }
}
