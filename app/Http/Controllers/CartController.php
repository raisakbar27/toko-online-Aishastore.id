<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $carts = Cart::with(['product.galleries', 'user'])->where('users_id', Auth::user()->id)->get();
        return view('pages.cart', [
            'carts' => $carts
        ]);
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->delete();
        return redirect()->route('cart');
    }

    public function succes()
    {
        return view('pages.succes');
    }

    public function updateQuantity(Request $request)
    {
        // Validasi input
        $request->validate([
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Temukan cart berdasarkan ID
        $cart = Cart::findOrFail($request->cart_id);

        // Update kuantitas
        $cart->quantity = $request->quantity;
        $cart->save();

        // Kirim respons dengan informasi terbaru
        return response()->json([
            'status' => 'success',
            'message' => 'Quantity updated successfully',
            'cart' => $cart,
        ]);
    }
}
