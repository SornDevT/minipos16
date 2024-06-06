<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;
use App\Models\Bill;
use App\Models\Bill_list;
use App\Models\Store;

class TransectionController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function add(Request $request){

        try {


            // ບັນທຶກ ຂໍ້ມູນໃບບິນ
            $bill_id='';
            $read_bill = Bill::all()->sortByDesc('id')->take(1)->toArray();
            foreach($read_bill as $new){
                $bill_id = $new['bill_id'];
            }

            if($bill_id!=''){
                $bill_id = (int)$bill_id+1; // 1+1 = 2
                $length = 5;
                $bill_id = substr(str_repeat(0,$length).$bill_id, - $length); //00002
            } else {
                $bill_id = 1;
                $length = 5;
                $bill_id = substr(str_repeat(0,$length).$bill_id, - $length); //00001
            }

            $bill = new Bill([
                "bill_id" => $bill_id,
                "customer_name" => $request->customer_name,
                "customer_tel" => $request->customer_tel,
            ]);
            $bill->save();


            // ບັນທຶກ ການເຄື່ອນໄຫວ
            foreach($request->listorder as $item){

                // gen id transection 
    
                $number='';
                $read_tran = Transection::all()->sortByDesc('id')->take(1)->toArray();
                foreach($read_tran as $new){
                    $number = $new['tran_id'];
                }
    
                if($number!=''){
                    $number1 = str_replace("INC","",$number); // INC00001 = 00001
                    $number2 = str_replace("EXP","",$number1);
                    $number3 = (int)$number2+1; // 1+1 = 2
                    $length = 5;
                    $number = substr(str_repeat(0,$length).$number3, - $length); //00002
                } else {
                    $number3 = 1;
                    $length = 5;
                    $number = substr(str_repeat(0,$length).$number3, - $length); //00001
                }

                $tran = new Transection([
                    "tran_id" => "INC".$number,
                    "tran_type" => "income",
                    "product_id"=> $item["id"],
                    "qty"=> $item["order_qty"],
                    "price"=> $item["price_sell"],
                    "tran_detail"=> $item["name"]
                ]);

                $tran->save();

                /// ບັນທຶກລາຍການ ໃບບິນ

                $bill_list = new Bill_list([
                    "bill_id" => $bill_id,
                    "name" => $item["name"],
                    "qty" => $item["order_qty"],
                    "price" => $item["price_sell"]
                ]);
                $bill_list->save();

                // ທຳການຕັດສະຕ໋ອກ
                $store = Store::find($item["id"]);
                $store_update = Store::find($item["id"]);

                $store_update->update([
                    "qty" => $store->qty - $item["order_qty"]
                ]);


            }

            $success = true;
            $message = 'ບັນທຶກຂໍ້ມູນ ສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
            $bill_id = null;
        }

        $response = [
            'bill_id' => $bill_id,
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }

    public function index(Request $request){

        $sort = \Request::get("sort");
        $perpage = \Request::get("perpage");

        $month_type = $request->month_type;
        $dmy = $request->dmy;
        $m = explode("-",$dmy)[1];
        $y = explode("-",$dmy)[0];

        if($month_type == "m"){

            $tran = Transection::orderBy("id",$sort)
            ->whereYear("created_at",$y)
            ->whereMonth("created_at",$m)
            ->paginate($perpage)
            ->toArray();

        } else if($month_type == "y"){

            $tran = Transection::orderBy("id",$sort)
            ->whereYear("created_at",$y)
            ->paginate($perpage)
            ->toArray();

        }

        return array_reverse($tran);

    }
}
