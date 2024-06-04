<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;

class TransectionController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function add(Request $request){

        try {


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


            }

            $success = true;
            $message = 'ບັນທຶກຂໍ້ມູນ ສຳເລັດ!';

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);

    }
}
