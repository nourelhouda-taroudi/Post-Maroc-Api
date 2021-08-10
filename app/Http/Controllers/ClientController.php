<?php

namespace App\Http\Controllers;
use App\Client;
use Illuminate\Http\Request;

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
                return response()->json("age must be greater then 20 years");
            }
            else{
                return response()->json("age must be less then 50 years");
            }
        }
        if($request->salary<1500 ){
            return response()->json("salary must be greater then 1500 DH");
        }
        $client = Client::create($request->all());
        return response()->json($client);
    }
    public function getClient($CIN){
        $client=Client::where('CIN_Number','=',$CIN)->get(); ;
        return response()->json($client);
    }
    public function updateClient(){

    }
}
