<?php

namespace App\Http\Controllers;

use App\Document;
use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    public function storeDocument(Request $request,$CIN){
        // $client=Client::where('CIN_Number','=',$CIN)->get();
        $client=DB::table('clients')
                ->where('CIN_Number','=',$CIN)
                ->select('clients.*')
                ->first();
        if($client==null){
            return response()->json('This CIN is invalid');
        }
        if($request->files){
            $destinationPath = 'uploads';
            if ($request->hasFile('CIN_front')){
                $CIN_front = $request->file('CIN_front');
                $CIN_front_filename = time().$CIN_front->getClientOriginalName();
                $CIN_front->move($destinationPath,$CIN_front_filename);
                $CIN_front_path=env('APP_URL', 'http://127.0.0.1').":".env('APP_PORT','8000').'/'.$destinationPath.'/'.$CIN_front_filename;
            }

            if ($request->hasFile('CIN_back')){
                $CIN_back =  $request->file('CIN_back');
                $CIN_back_filename=time().$CIN_back->getClientOriginalName();
                $CIN_back->move($destinationPath,$CIN_back_filename);
                $CIN_back_path=env('APP_URL', 'http://127.0.0.1').":".env('APP_PORT','8000').'/'.$destinationPath.'/'.$CIN_back_filename;
            }

            if ($request->hasFile('salaryCertificate')){
                $salaryCertificate =  $request->file('salaryCertificate');
                $salaryCertificate_filename=time().$salaryCertificate->getClientOriginalName();
                $salaryCertificate->move($destinationPath,$salaryCertificate_filename);
                $salaryCertificate_path=env('APP_URL', 'http://127.0.0.1').":".env('APP_PORT','8000').'/'.$destinationPath.'/'.$salaryCertificate_filename;            
            }

            if ($request->hasFile('certificateResWaterElec')){
                $certificateResWaterElec =  $request->file('certificateResWaterElec');
                $certificateResWaterElec_filename=time().$certificateResWaterElec->getClientOriginalName();
                $certificateResWaterElec->move($destinationPath,$certificateResWaterElec_filename);
                $certificateResWaterElec_path=env('APP_URL', 'http://127.0.0.1').":".env('APP_PORT','8000').'/'.$destinationPath.'/'.$certificateResWaterElec_filename;
            }
            
            if ($request->hasFile('jobCertificate')){
                $jobCertificate =  $request->file('jobCertificate');
                $jobCertificate_filename=time().$jobCertificate->getClientOriginalName();
                $jobCertificate->move($destinationPath,$jobCertificate_filename);
                $jobCertificate_path=env('APP_URL', 'http://127.0.0.1').":".env('APP_PORT','8000').'/'.$destinationPath.'/'.$jobCertificate_filename;
            }

            $document=new Document();
            $document->CIN_front=$CIN_front_path;
            $document->CIN_back=$CIN_back_path;
            $document->salaryCertificate=$salaryCertificate_path;
            $document->certificateResWaterElec=$certificateResWaterElec_path;
            $document->jobCertificate=$jobCertificate_path;
            $document->client_CIN_Number=$CIN;
            $document->save();
            return response()->json($document);
        }
        
        return response()->json(["Aucun fichier entrer"],422);
    }
}