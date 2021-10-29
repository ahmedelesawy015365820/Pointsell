<?php

namespace  App\Http\Controllers\Dashboard;

use App\Category;
use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct(){

        $this->middleware('permission:product-list', ['only' => ['index']]);
        $this->middleware('permission:product-create', ['only' => ['create','store']]);
        $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);

    }


    public function index(Request $request)
    {

        $categories = Category::all();

        $products = Product::when($request->search,function ($q) use ($request){

            return $q->where('name','like',"%". $request->search ."%");

        })->when($request->category_id,function ($q) use ($request){

            return $q->where('category_id','=',$request->category_id );

        })->latest()->paginate(10);

        return view('dashboard.product.index',compact('products','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::all();

        return view('dashboard.product.add',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:products,name',
            'description' => 'required',
            'category_id' => 'required',
            'purchase_price' => 'required',
            'sale_price'  => 'required',
            'stock' => 'required',
            'image' => 'image:png,jepg,jpg'
        ]);

        $input = $request->all();

        if(!$request->hasFile('image')){

            $input['image'] = '6.jpg';

        }else{

            // picture move
            $img = Image::make(request()->image)->resize(100, null, function ($constraint) {

            $constraint->aspectRatio();

            })->save(public_path('assets/img/product/'. request()->image->hashName()));

            $input['image'] = $request->image->hashName();

        }

        $product = Product::create($input);

        return redirect()->route('dashboard.product.index')->with('success',trans('site.success'));
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $product = Product::with(['category' => function ($q)
        {
            return $q->select('id','name');
        }])->find($id);

        // return $product;

        $categories = Category::all();

        return view('dashboard.product.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'category_id' => 'required',
            'purchase_price' => 'required',
            'sale_price'  => 'required',
            'stock' => 'required',
            'image' => 'image:png,jepg,jpg'
        ]);

        $input = $request->all();

        $product = Product::find($id);
        $input = $request->all();

        if ($request->hasFile('image') && $product->image != '6.jpg'){

            Storage::disk('product')->delete( $product->image );

            $img = Image::make(request()->image)->resize(100, null, function ($constraint) {

            $constraint->aspectRatio();

            })->save(public_path('assets/img/product/'. request()->image->hashName()));

            $input['image'] = $request->image->hashName();

        }

        $product->update($input);

        return redirect()->route('dashboard.product.index')->with('success',trans('site.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::find($request->product_id);

        if($product->image != '6.jpg')
            Storage::disk('product')->delete( $product->image );

        $product->delete();

        return redirect()->route('dashboard.product.index')->with('success',trans('site.true-delete'));
    }
}
