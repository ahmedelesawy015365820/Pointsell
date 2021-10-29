<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct(){

        $this->middleware('permission:orders-add', ['only' => ['create','store']]);
        $this->middleware('permission:orders-edit', ['only' => ['edit','update']]);

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Client $client)
    {

        $categories = Category::with(['product'=> function ($q){

            return $q->select('sale_price','stock','category_id', 'id','name');

        }])->get();

        $orders = $client->order()->with('products')->paginate(5);

        return view('dashboard.clients.orders.add', compact('categories','client','orders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , Client $client)
    {

        $request->validate([
            'products' => 'required|array',
            'amounts' => 'required|array',
            'price' => 'required'
        ]);


        $this->attach_order($request,$client);

        return redirect()->route('dashboard.orders.index')->with('success',trans('site.success'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Client $client ,Order $order)
    {

        $categories = Category::with(['product'=> function ($q){

            return $q->select('sale_price','stock','category_id', 'id','name');

        }])->get();

        $orders = $client->order()->with('products')->paginate(5);

        // return $order->products;
        return view('dashboard.clients.orders.edit', compact('categories','client','order','orders'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Client $client, Order $order ,Request $request)
    {

        $request->validate([
            'products' => 'required|array',
            'amounts' => 'required|array',
            'price' => 'required'
        ]);

        $this->dettach_order($order);

        $this->attach_order($request,$client);

        return redirect()->route('dashboard.orders.index')->with('success',trans('site.success'));

    }



    private function attach_order($request,$client)
    {

        $order = $client->order()->create([]);

        foreach($request->products as $index => $Product_id){

            $product = Product::find($Product_id);

            $order->products()->attach($Product_id, ['amount' => $request->amounts[$index]]);

            $product->update([
                'stock' => $product->stock -  $request->amounts[$index]
            ]);

        }

        $order->update([
            'price' => $request->price
        ]);

    }

    private function dettach_order($order)
    {

        foreach($order->products as $product){

            $product->update([
                'stock' => ($product->stock + $product->pivot->amount)
            ]);

        }

        $order->delete();
    }

}
