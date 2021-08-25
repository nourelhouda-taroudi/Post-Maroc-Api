<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable=['CIN_Number','firstName','lastName','email','phone','age','salary','job','address','accountBalance'];
// Relation Credit<->Client
    public function credit()
    {
        return $this->hasMany('App\Credit');
    }
    // Relation Document<->Client
    public function document()
    {
        return $this->hasMany('App\Document');
    }
}
