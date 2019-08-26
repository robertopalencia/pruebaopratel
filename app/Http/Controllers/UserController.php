<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Mongodb\Auth\User;

class UserController extends Controller
{
    //
    public function addUser(Request $request){

        $v = Validator::make($request->all(), [
            'phone' => 'required|unique:users|max:11',
            'password' => 'required',
            'site' => 'required',
        ]);
        if ($v->fails())
        {
            return response($v->errors()->first(), 400)
                ->header('Content-Type', 'text/plain');
        }

        $user= new User();
        $user->phone = $request->phone;
        $user->password = $request->password;
        $user->site = $request->site;
        $user->save();
        return response(['Usuario guardado con exito', $user->id], 200)
            ->header('Content-Type', 'text/plain');
    }
    public function addPayment(Request $request){

        $v = Validator::make($request->all(), [
            'phone' => 'required|max:11',
            'amount' => 'required',
        ]);
        if ($v->fails())
        {
            return response($v->errors()->first(), 400)
                ->header('Content-Type', 'text/plain');
        }
        $user = User::where('phone', $request->phone)->first();
        if(!$user){
            return response('El usuario no existe en la base de datos', 400)
                ->header('Content-Type', 'text/plain');
        }

        $payment= new Payment();
        $payment->phone = $request->phone;
        $payment->amount = $request->amount;
        $payment->save();
        return response(['Pago guardado con exito', $payment->id], 200)
            ->header('Content-Type', 'text/plain');
    }
    public function getUsers(){
        $users = User::all();
        return response($users, 200)
            ->header('Content-Type', 'text/plain');
    }
}
