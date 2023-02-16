<?php

namespace App\Http\Controllers;

use App\Models\AllTotal;
use App\Models\Event;
use App\Models\Majority;
use App\Models\Question;
use App\Models\TotalPoint;
use App\Models\User;
use App\Models\Answer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AggregationController extends Controller
{
    public function index(){
        $this_month = date("Y-m-d");
        return Inertia::render('Aggregation/Index',[
            'questions' => Question::Where('delete_flg','=', 0)
                ->orderByRaw('chapter_no, sort_no')
                ->get(),

            'events' => Event::Where('delete_flg','=', 0)
                ->Where('end_flg','=', 1)
                ->orderByRaw('event_date')
                ->get(),

            'opening_event' => Event::Select('id','event_date')
                ->Where('delete_flg','=', 0)
                ->Where('opening_flg','=', 1)
                ->get(),

            'majorities' => Majority::Select( 'event_id','user_id','point')
                ->orderByRaw('event_id, user_id')
                ->get(),

            'avg_majorities' => Majority::Select('event_id')
                ->selectRaw('ROUND(AVG(point),0) AS avg_point')
                ->Groupby('event_id')
                ->get(),

            'total_points' => TotalPoint::Select( 'event_id','question_id','user_id')
                ->selectRaw('ROUND(point,2) AS point')
                ->orderByRaw('event_id,question_id,user_id')
                ->get(),

            'total_points_companies' => TotalPoint::Select( 'event_id','question_id')
                ->selectRaw('ROUND(point,2) AS point')
                ->Where('user_id', '=', '0')
                ->orderByRaw('event_id,question_id,user_id')
                ->get(),

            'total_points_companies_summary' => TotalPoint::Select( 'event_id')
                ->selectRaw('ROUND(SUM(point)) AS summarise_point')
                ->Where('user_id', '=', '0')
                ->groupBy('event_id')
                ->orderByRaw('event_id')
                ->get(),

            'sum_total_points' => TotalPoint::Select( 'event_id','user_id')
                ->selectRaw('ROUND(SUM(point),0) AS point')
                ->Groupby('event_id', 'user_id')
                ->orderByRaw('event_id, user_id')
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

            'check_event_end' => Answer::select('event_id')
                ->selectRaw('COUNT(*) AS record_num')
                ->Where('delete_flg','=', 0)
                ->groupBy('event_id')
                ->get(),

            'users' => User::Where('admin_flg','=', 0)
                ->Where('delete_flg','=', 0)
                ->orderbyRaw('id')
                ->get(),
        ]);
    }



    public function summary(Request $request){

        $bind_pram = [$request->event_id];
        $event_id = $request->event_id;

        $insert_total_point_users = <<< SQL
INSERT IGNORE INTO total_points(event_id, question_id, user_id, point)
SELECT
    event_id,
    question_id,
    respondent_user_id,
    CASE WHEN question_id IN(3, 9, 16) THEN (COUNT(*) - SUM(result)) / COUNT(*) * 4 ELSE SUM(result) / COUNT(*) * 4 END AS mvv_point
FROM
    answers
GROUP BY
    event_id,
    question_id,
    respondent_user_id
ORDER BY
    event_id,
    question_id,
    respondent_user_id

SQL;
        $result_total_point_users_sql = DB::select($insert_total_point_users);

        $insert_total_point_company = <<< SQL
INSERT IGNORE INTO total_points(event_id, question_id, user_id, point)
SELECT
    event_id,
    question_id,
    0 AS respondent_user_id,
    CASE WHEN question_id IN(3, 9, 16) THEN(COUNT(*) - SUM(result)) / COUNT(*) * 4 ELSE SUM(result) / COUNT(*) * 4 END AS co_avg_point
FROM
    answers
GROUP BY
    event_id,
    question_id
ORDER BY
    event_id,
    question_id

SQL;
        $result_total_point_company_sql = DB::select($insert_total_point_company);

        $insert_majority_point = <<< SQL
INSERT IGNORE INTO majorities(event_id, user_id, point)
SELECT
    t.event_id,
    t.user_id,
    ROUND(
        SUM(t.points) /(COUNT(t.user_id) / 20)
    ) AS POINT
FROM
    (
    SELECT
        a.event_id,
        a.question_id,
        a.respondent_user_id,
        a.user_id,
        result,
        majority,
        CASE WHEN result = majority THEN 1 ELSE 0
END AS points
FROM
    answers a,
    (
    SELECT
        event_id,
        question_id,
        respondent_user_id,
        CASE WHEN SUM(result) > COUNT(*) / 2 THEN 1 ELSE 0
END AS majority
FROM
    answers
GROUP BY
    event_id,
    question_id,
    respondent_user_id
ORDER BY
    event_id,
    question_id,
    respondent_user_id
) AS m
WHERE
    a.event_id = m.event_id AND a.question_id = m.question_id AND a.respondent_user_id = m.respondent_user_id
ORDER BY
    a.event_id,
    a.question_id,
    a.respondent_user_id,
    a.user_id
) AS t
GROUP BY
    t.event_id,
    t.user_id

SQL;
        $result_majority_point_sql = DB::select($insert_majority_point);


        $userid_majority_sql = <<< SQL
SELECT users.id FROM users
left join (select user_id, point from majorities where event_id = ?) AS m_user
on users.id = m_user.user_id
WHERE users.id >= 6
AND point is null
SQL;
        $userid_majority_ary = DB::select($userid_majority_sql, $bind_pram);

        foreach ($userid_majority_ary as $userid) {
            Majority::create([
                'event_id' => $event_id,
                'user_id' => $userid->id,
                'point' => 0
            ]);
        }


        $stddev_sql = <<< SQL
SELECT
    ROUND(STDDEV(total_point),0) AS STDDEV
FROM
    (
    SELECT
        t.event_id,
        t.user_id,
        ROUND(SUM(t.point)),
        m.point,
        ROUND((SUM(t.point) + m.point)) AS total_point
    FROM
        total_points t,
        majorities m
    WHERE
        t.event_id = m.event_id AND t.user_id = m.user_id
    GROUP BY
        t.event_id,
        t.user_id
) AS total
WHERE event_id = ?
GROUP BY
    event_id

SQL;

        $result_stddev_sql = DB::select($stddev_sql, $bind_pram);
        $stddev = $result_stddev_sql[0]->STDDEV;
        Event::where('id', '=', $event_id)
            ->update([
                'stdev' => $stddev,
                'opening_flg' => 0,
                'end_flg' => 1,
            ]);


        $message = '集計が完了しました。一旦このページをリロードしてください。';
        return redirect()->route('aggregation')->with('message', $message);
    }
}
