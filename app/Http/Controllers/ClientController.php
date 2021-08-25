<?php

namespace App\Http\Controllers;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Create a new Client
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createClient(Request $request)
    {
        if($request->age <20 || $request->age>50){
            if($request->age<20){
                return response()->json(['age must be greater then 20 years'],422);
            }
            else{
                return response()->json(["age must be less then 50 years"],422);
            }
        }
        if($request->salary<1500 ){
            return response()->json(["salary must be greater then 1500 DH"],422);
        }
        $client = Client::create($request->all());
        return response()->json([$client,$request->all()]);
    }
    public function getClient($CIN){
        $client=Client::where('CIN_Number','=',$CIN)->first();
        return response()->json($client,201);
    }
    public function getAccountBalance($CIN){
        $accountBalance_obj=DB::table('clients')
        ->where('CIN_Number','=',$CIN)
        ->select('accountBalance')
        ->first();
        if($accountBalance_obj!=null){
            $accountBalance=$accountBalance_obj->accountBalance;
            return response()->json($accountBalance);
        }
        return response()->json("Not found",404);

    }
}
