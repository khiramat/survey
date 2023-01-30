<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Majority extends Model
{
    use HasFactory;
    protected $fillable = ['event_id','user_id','point'];
}
