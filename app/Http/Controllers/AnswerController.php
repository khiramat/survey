<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\Event;
use App\Models\Answer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnswerController extends Controller
{
    public function index(){
        $componentKey = mt_rand();

        return Inertia::render('Answer/Index',[
            'chapters' => Chapter::Where('delete_flg','=', 0)
                ->get(),
            'questions' => Question::Where('delete_flg','=', 0)
                ->get(),
            'events' => Event::Where('delete_flg','=', 0)
                ->Where('opening_flg','=', 1)
                ->Where('end_flg','=', 0)
                ->orderByRaw('event_date')
                ->first(),
            'answers' => Answer::distinct()
                ->Select('event_id','user_id','respondent_user_id')
                ->Where('delete_flg','=', 0)
                ->get(),
            'users' => User::Select('id','name')
                ->Where('id','!=', Auth::id())
                ->Where('admin_flg','=', 0)
                ->Where('delete_flg','=', 0)
                ->orderByRaw('RAND()')
                ->get(),
            'componentKey' => $componentKey
        ]);
    }

    public function store(Request $request){
        $componentKey = mt_rand();
        $answer1 = $request->answers1;
        $answer2 = $request->answers2;
        $answer3 = $request->answers3;
        $answer4 = $request->answers4;
        $answer5 = $request->answers5;
        $answer6 = $request->answers6;
        $answer7 = $request->answers7;
        $answer8 = $request->answers8;
        $answer9 = $request->answers9;
        $answer10 = $request->answers10;
        $answer11 = $request->answers11;
        $answer12 = $request->answers12;
        $answer13 = $request->answers13;
        $answer14 = $request->answers14;
        $answer15 = $request->answers15;
        $answer16 = $request->answers16;
        $answer17 = $request->answers17;
        $answer18 = $request->answers18;
        $answer19 = $request->answers19;
        $answer20 = $request->answers20;

        for($i = 1; $i <= 20; $i++){
            Answer::create([
                'question_id' => $i,
                'event_id' => $request->event_id,
                'user_id' => $request->user_id,
                'respondent_user_id' => $request->respondent_user_id,
                'result' => ${'answer'.$i},
            ]);
        }

        return Inertia::render('Answer/Store',[
            'respondent_user_name' => $request->respondent_user_name
        ]);
    }
}
