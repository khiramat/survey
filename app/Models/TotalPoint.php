<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalPoint extends Model
{
    use HasFactory;
    protected $fillable = ['event_id','question_id','user_id','point'];
}
