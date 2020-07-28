<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Resources\CartItemCollection;
use App\Order;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * checkout the cart Items and create and order.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return void
     */
    public function checkout(Cart $cart, Request $request)
    {

        if (Auth::guard('api')->check()) {
            $userEmail = auth('api')->user()->email;
        }

        $validator = Validator::make($request->all(), [
            'userEmail' => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 400);
        }

        $email = $request->input('userEmail');
        if ($userEmail == $email) {
            $TotalPrice = (float) 0.0;
            $items = $cart->items;

            foreach ($items as $item) {
                $product = Products::find($item->product_id);
                $price = $product->price;



                $TotalPrice = $TotalPrice + ($price * $item->quantity);

                $product->UnitsInStock = $product->UnitsInStock - $item->quantity;
                $product->save();
            }

            $order = Order::create([
                'products' => json_encode(new CartItemCollection($items)),
                'totalPrice' => $TotalPrice,
                'userID' => isset($userID) ? $userID : null,
            ]);

            $cart->delete();

            return response()->json([
                'orderID' => $order->id(),
                'Total Amount' => $order->$TotalPrice,
                'success' => 'True',
            ], 200);
        } else {
            return response()->json([
                'message' => 'The CarKey you provided does not match the Cart Key for this Cart.',
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
