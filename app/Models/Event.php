<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['event_date','opening_flg','end_flg','delete_flg','user_number','mmv','majority','total_avg','stdev'];
}
