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

class InputStatusController extends Controller
{
    public function index(){

        $sql = <<< SQL
SELECT id, name, count
FROM  users
LEFT JOIN (
	SELECT `user_id`, COUNT(*) AS count
	FROM `answers`
	WHERE `event_id` = (SELECT id FROM events WHERE opening_flg = 1 AND delete_flg = 0)
    group by `user_id`
    ) AS answer
ON users.id = answer.user_id
WHERE id >2
ORDER BY id ASC;
SQL;
        $result = DB::select($sql);

        return Inertia::render('InputStatus/Index',[
            'inputs' => $result,

            'user_num' => User::selectRaw('COUNT(*) AS user_num')
                ->Where('delete_flg','=', 0)
                ->Where('id','>=', 6)
                ->get(),

            'opening_event' => Event::Select('id','event_date')
                ->Where('delete_flg','=', 0)
                ->Where('opening_flg','=', 1)
                ->get(),

        ]);
    }
}
