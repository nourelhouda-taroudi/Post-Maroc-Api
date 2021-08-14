<?php

namespace App\Http\Controllers;

use App\Credit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;

class CreditController extends Controller
{
    public function createCredit($CIN , Request $request){
        $amount = $request->amount;
        $rate = 14;
        $monthly = $request->monthly;
        $min = 10000;

        $salary_std = DB::table('clients')
                        ->where('CIN_Number','=',$CIN)
                        ->select('salary')
                        ->first();
        // Check if client already exist in database
        if($salary_std == null){
            return response()->json(['error'=>"CIN invalid."],422);
        }
        // Get salary from Std salary object
        $salary = $salary_std->salary;
        if($amount < $min){
            return response()->json(['error'=>"Amount must be greater than 10000Dh."],422);
        }

        // 1500DH - 4000DH
        if($salary>=1500 && $salary<4000){
            $max = 200000;
            if($amount>=$max){
                return response()->json(['error'=>"Amount invalid."],422);
            }
            $credit = $this->calculateAndCreateCredit($amount,$rate,$CIN,$monthly);
            return response()->json(['credit'=>$credit],201);
        }

        // 40000DH - 10000DH
        if($salary >= 4000 && $salary < 10000){
            $age =  (DB::table('clients')
                            ->where('CIN_Number','=',$CIN)
                            ->select('age')
                            ->first()
                     )->age;

            if($age<40)$max=600000;
            if($age>=40)$max=400000;
            if($amount>=$max){
                return response()->json(['error'=>"Amount invalid."],422);
            }
            $credit = $this->calculateAndCreateCredit($amount,$rate,$CIN,$monthly);
            return response()->json(['credit'=>$credit],201);
        }

        // 10000DH - 50000DH
        if($salary >= 10000 && $salary < 50000){
            $age =  (DB::table('clients')
                            ->where('CIN_Number','=',$CIN)
                            ->select('age')
                            ->first()
                     )->age;

            if($age<40)$max=1000000;
            if($age>=40)$max=800000;
            if($amount>=$max){
                return response()->json(['error'=>"Amount invalid."],422);
            }
            $credit = $this->calculateAndCreateCredit($amount,$rate,$CIN,$monthly);
            return response()->json(['credit'=>$credit],201);
        }
        // >50000DH
        if($salary >= 50000){
            $age =  (DB::table('clients')
                            ->where('CIN_Number','=',$CIN)
                            ->select('age')
                            ->first()
                     )->age;

            if($age<40)$max=1500000;
            if($age>=40)$max=1000000;
            if($amount>=$max){
                return response()->json(['error'=>"Amount invalid."],422);
            }
            $credit = $this->calculateAndCreateCredit($amount,$rate,$CIN,$monthly);
            return response()->json(['credit'=>$credit],201);
        }
        return response()->json(['error'=>"Sorry, Can not create credit."],422);
    }

    private function calculateAndCreateCredit($amount,$rate,$CIN,$monthly){
        $duration = ($amount*(1+($rate/100)))/$monthly;
        $credit = new Credit();
        $credit->amount = $amount;
        $credit->rate = $rate;
        $credit->duration = $duration;
        $credit->monthly = $monthly;
        $credit->Client_CIN_Number = $CIN;
        $credit->save();

        return $credit;
    }
    public function sign(Request $request , $idCredit){
 
        $credit = Credit::where('idCredit',$idCredit)->first();
        if($credit== null){
            return response()->json(['error'=>'Credit is not found.'],404);
        }
        // generating an RSA key pair
        [$privateKey, $publicKey] = (new KeyPair())->generate();

        // Get PDF as base64
        $file = $request->document;

        // Hash file with SHA256
        $hash_file = hash('sha256',$file);

        //$data = base64_encode($file);

        // Create signature
        $signature = PrivateKey::fromString($privateKey)->sign($hash_file);
        DB::table('credits')
            ->where('idCredit', $idCredit)
            ->update([
            'signature' => $signature,
            'publicKey' => $publicKey
      ]);
        //$credit->signature = $signature;
        //$credit->publicKey = $publicKey;
        //$credit->save();

        return response()->json(['signature'=>$signature],201);
    }
}
