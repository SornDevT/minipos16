<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transection;

class ReportController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api');
    }

    public function created_report(Request $request){


        $month_type = $request->month_type;
        $dmy = $request->dmy;
        $m = explode("-",$dmy)[1];
        $y = explode("-",$dmy)[0];

        $labels = [];
        $income = [];
        $expense = [];


        if($month_type == "m"){

            // ຊອກຫາວັນທີ່ສຸດທ້າຍຂອງເດືອນ ຈາກ ວັນເດືອນປີ ທີ່ສົ່ງມາ $dmy
            $last_day = date("t",strtotime($dmy));
            for ($i=1; $i <= $last_day; $i++) { 
                array_push($labels, "ວັນທີ່ ".$i);
            }

            /// ດຶງຂໍ້ມູນ ການເຄື່ອນໄຫວ ລາຍຮັບ ທີ່ເກີດຂື້ນ ປະຈຳວັນ ຕັ້ງແຕ່ວັນທີ່ເລີ່ມຕົ້ນ ຫາ ສຸດທ້າຍຂອງເດືອນ
            for ($i=1; $i <= $last_day; $i++) { 
                $inc = Transection::whereMonth("created_at",$m)
                ->whereYear("created_at",$y)
                ->whereDay("created_at",$i)
                ->where("tran_type","income")
                ->sum("price");
                array_push($income,$inc);
            }

             /// ດຶງຂໍ້ມູນ ການເຄື່ອນໄຫວ ລາຍຈ່າຍ ທີ່ເກີດຂື້ນ ປະຈຳວັນ ຕັ້ງແຕ່ວັນທີ່ເລີ່ມຕົ້ນ ຫາ ສຸດທ້າຍຂອງເດືອນ
             for ($i=1; $i <= $last_day; $i++) { 
                $exp = Transection::whereMonth("created_at",$m)
                ->whereYear("created_at",$y)
                ->whereDay("created_at",$i)
                ->where("tran_type","expense")
                ->sum("price");
                array_push($expense,$exp);
            }

            // sum income & expense
            $sum_income = Transection::whereMonth("created_at",$m)
            ->whereYear("created_at",$y)
            ->where("tran_type","income")
            ->sum("price");

            $sum_expense = Transection::whereMonth("created_at",$m)
            ->whereYear("created_at",$y)
            ->where("tran_type","expense")
            ->sum("price");


        } else if($month_type == "y"){

            for ($i=1; $i <= 12; $i++) { 
                array_push($labels, "ເດືອນ ".$i);
            }


            for ($i=1; $i <= 12; $i++) { 
                $inc = Transection::whereMonth("created_at",$i)
                ->whereYear("created_at",$y)
                ->where("tran_type","income")
                ->sum("price");
                array_push($income,$inc);
            }

            for ($i=1; $i <= 12; $i++) { 
                $exp = Transection::whereMonth("created_at",$i)
                ->whereYear("created_at",$y)
                ->where("tran_type","expense")
                ->sum("price");
                array_push($expense,$exp);
            }

            // sum income & expense
            $sum_income = Transection::whereYear("created_at",$y)
            ->where("tran_type","income")
            ->sum("price");

            $sum_expense = Transection::whereYear("created_at",$y)
            ->where("tran_type","expense")
            ->sum("price");


        }



        $response = [
            "labels" => $labels,
            "income" => $income,
            "expense" => $expense,
            "sum_income" => $sum_income,
            "sum_expense" => $sum_expense
        ];

        return response()->json($response);

    }
}
