<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    protected $fillable=['amount','rate','duration','signature','monthly','Client_CIN_Number'];

    // Relation Client<->Credit
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}
