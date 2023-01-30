<?php

namespace App\Http\Controllers;

use App\Models\AllTotal;
use App\Models\Event;
use App\Models\Majority;
use App\Models\Question;
use App\Models\TotalPoint;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
class IndividualController extends Controller
{
    public function index(){
        $this_month = date("Y-m-d");
        return Inertia::render('Individual/Index',[
            'questions' => Question::Where('delete_flg','=', 0)
                ->orderByRaw('chapter_no, sort_no')
                ->get(),

            'events' => Event::Where('delete_flg','=', 0)
                ->Where('end_flg','1=', 1)
                ->orderByRaw('event_date')
                ->get(),

            'majorities' => Majority::Select( 'event_id','user_id','point')
                ->orderByRaw('event_id, user_id')
                ->get(),

            'total_points' => TotalPoint::Select( 'event_id','question_id','user_id')
                ->selectRaw('ROUND(point,2) AS point')
                ->orderByRaw('event_id,question_id,user_id')
                ->get(),

            'sum_total_points' => TotalPoint::Select( 'event_id','user_id')
                ->selectRaw('ROUND(SUM(point),0) AS point')
                ->Groupby('event_id', 'user_id')
                ->orderByRaw('event_id, user_id')
                ->get(),

            'total_points_companies_summary' => TotalPoint::Select( 'event_id')
                ->selectRaw('ROUND(SUM(point)) AS summarise_point')
                ->Where('user_id', '=', '0')
                ->groupBy('event_id')
                ->orderByRaw('event_id')
                ->get(),

            'avg_majorities' => Majority::Select('event_id')
                ->selectRaw('ROUND(AVG(point),0) AS avg_point')
                ->Groupby('event_id')
                ->get(),

            'total_addition' =>
                TotalPoint::select('event_id','user_id')
                    ->selectRaw('ROUND(SUM(point)) AS mvv_point')
                    ->addSelect(['maj_point'=>Majority::selectRaw('ROUND(point)')
                        ->whereColumn('event_id','total_points.event_id')
                        ->whereColumn('user_id','total_points.user_id')
                    ])
                    ->where('user_id', '!=', 0)
                    ->groupBy('event_id','user_id')
                    ->orderByRaw('event_id, user_id')
                    ->get(),

            'users' => User::Where('admin_flg','=', 0)
                ->Where('delete_flg','=', 0)
                ->orderbyRaw('id')
                ->get(),
        ]);
    }

}
