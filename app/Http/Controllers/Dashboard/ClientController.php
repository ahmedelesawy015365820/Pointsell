<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Client;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{


    function __construct(){

        $this->middleware('permission:client-list', ['only' => ['index']]);
        $this->middleware('permission:client-create', ['only' => ['create','store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $clients = Client::when($request->search,function ($q) use ($request){

            return $q->where('name','like',"%". $request->search ."%")
                ->orWhere('phone','like',"%". $request->search ."%")
                ->orWhere('address','like',"%". $request->search ."%");;

        })->latest()->paginate(10);

        return view('dashboard.clients.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.clients.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $client = Validator::make($request->all(),[
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        Client::create($request->all());

        return redirect()->route('dashboard.client.index')->with('success',trans('site.success'));

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);

        return view('dashboard.clients.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Validator::make($request->all(),[
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        Client::find($id)->update($request->all());

        return redirect()->route('dashboard.client.index')->with('success',trans('site.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //

        $client = Client::find($request->client_id);

        $order = Order::where('client_id' , $request->client_id );

        foreach($order->products as $product){

            $product->update([
                'stock' => ($product->stock + $product->pivot->amount)
            ]);

        }

        $order->delete();

        $client->delete();

        return redirect()->route('dashboard.client.index')->with('success',trans('site.true-delete'));

    }
}
