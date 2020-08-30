<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    public $fillable = ['name', 'email', 'phone', 'message'];
}
