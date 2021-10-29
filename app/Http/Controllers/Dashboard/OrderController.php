<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $orders = Order::with(['clients' => function ($q) {

            return $q->select('id' , 'name');

        }])->whereHas('clients',function ($q) use ($request){

            return $q->where('name','like',"%". $request->search ."%");

        })->orderBy('id','ASC')->paginate(10);

        return view('dashboard.orders.index', compact('orders') );

    }


    public function product($id)
    {

        $products = Order::find($id)->products;

        // return $products;

        return response()->json([
            'products' => $products
        ]) ;

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $order = Order::find($request->order_id);

        foreach($order->products as $product){

            $product->update([
                'stock' => ($product->stock + $product->pivot->amount)
            ]);

        }

        $order->delete();

        return redirect()->route('dashboard.orders.index')->with('success',trans('site.true-delete'));

    }
}
