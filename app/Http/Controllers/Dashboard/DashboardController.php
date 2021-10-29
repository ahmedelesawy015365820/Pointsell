<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //

    public function index()
    {

        $count_product = Product::count();
        $count_order = Order::count();
        $count_client = Client::count();
        $count_category = Category::count();
        $price_order = Order::sum('price') ;

        $sale_data = Order::select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('sum(price) as price'),
        )->groupBy('month')->get();

        // ExampleController.php
        $m = [];
        $p = [];
        $i = [];

        $month = ['January ','February','March ','April','May','June', 'July','August','Septemper','Octaber','Noverber','December'];

        foreach($sale_data as $data) {
            $i[]= $data->month;
            $p[]= $data->price;
        }

        foreach($i as $w){

            $m[] = $month[$w - 1];

        }

        $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('line')
        ->size(['width' => 400, 'height' => 200])
        ->labels($m)
        ->datasets([
            [
                "label" => "The Sales",
                'backgroundColor' => "rgba(38, 185, 154, 0.31)",
                'borderColor' => "rgba(38, 185, 154, 0.7)",
                "pointBorderColor" => "rgba(38, 185, 154, 0.7)",
                "pointBackgroundColor" => "rgba(38, 185, 154, 0.7)",
                "pointHoverBackgroundColor" => "#fff",
                "pointHoverBorderColor" => "rgba(220,220,220,1)",
                'data' => $p,
            ],
        ]);

        return view('dashboard.index',
        compact('count_product','count_order','count_client','count_category','price_order','chartjs'));
    }


}
