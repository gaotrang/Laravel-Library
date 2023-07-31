<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){

        $orders = Order::all();
        $countOrder = $orders->count();
        //Google Chart
        //total: 10 orders
        //5 orders status pending => 50%
        //3 orders status processing => 30%
        //2 orders status cancel => 20%

        $dataOrders = DB::table('order')->selectRaw('status, count(status) as number')->groupBy('status')->get();
        $arrayDatas = [];

        foreach($dataOrders as $data){
            $arrayDatas[] = [$data->status, $data->number];
        }

        return view('admin.pages.dashboard', compact('arrayDatas'));
    }
}
