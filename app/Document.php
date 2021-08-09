<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable=['CIN_front','CIN_back','salaryCertificate','certificateResWaterElec','jobCertificate','Client_CIN_Number'];

    // Relation Client<->Document
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
