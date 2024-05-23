<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use JWTAuth;


class UserController extends Controller
{
    //
    public function register(Request $request){

        try {
            
            $user = new User([
                'name' => $request->from_user_name,
                'email' => $request->from_user_email,
                'password' => hash::make($request->from_password),
            ]);
            $user->save();

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


    public function login(Request $request){

        $user_login = [
            'email' => $request->login_email,
            'password' => $request->login_password,
        ];

        $token = JWTAuth::attempt($user_login); /// ກວດຊອບ email ແລະ ລະຫັດຜ່ານ
        $user_data = Auth::user(); /// ການດຶງເອົາຂໍ້ user ທີ່ທຳການ login

        if($token){

            $response = [
                'success' => true,
                'message' => 'ສຳເລັດ!',
                'user_data' => $user_data,
                'token' => $token
            ];
            
        } else {

            $response = [
                'success' => false,
                'message' => 'ອີເມວລ໌ ຫຼື ລະຫັດຜ່ານບໍ່ຖຶກຕ້ອງ!'
            ];

        }

       

        return response()->json($response);

    }

    public function logout(){

        $token = JWTAuth::getToken();
        $invalidate = JWTAuth::invalidate($token);
        if($invalidate){
            $response = [
                'success' => true,
                'message' => 'ສຳເລັດ!'
            ];
        } else {
            $response = [
                'success' => false,
                'message' => 'ບໍ່ສຳເລັດ!'
            ];
        }

        return response()->json($response);

    }
}
