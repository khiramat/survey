<?php

use App\Models\AllTotal;
use App\Models\Answer;
use App\Models\Chapter;
use App\Models\Event;
use App\Models\Majority;
use App\Models\Question;
use App\Models\TotalPoint;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AggregationController;
use App\Http\Controllers\TrendController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\InputStatusController;

Auth::id();
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'vision' => '掛け替えの無い存在になる',
        'mission' => 'ありがとうで満たす',
        'values' => Chapter::all(),
    ]);
});

Route::match(['get', 'post'],'/answer', [AnswerController::class, 'index'])->name('answer');
Route::match(['get', 'post'],'/answer_store', [AnswerController::class, 'store'])->name('answer_store');
Route::match(['get', 'post', 'put'],'/aggregation_summary', [AggregationController::class, 'summary'])->name('aggregation_summary');
Route::match(['get', 'post'],'/aggregation', [AggregationController::class, 'index'])->name('aggregation');
Route::match(['get', 'post'],'/trend', [TrendController::class, 'index'])->name('trend');
Route::match(['get', 'post'],'/individual', [IndividualController::class, 'index'])->name('individual');
Route::match(['get', 'post'],'/input_status', [InputStatusController::class, 'index'])->name('input_status');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/Index',[
        'chapters' => Chapter::Where('delete_flg','=', 0)
            ->orderByRaw('chapter_no')
            ->get(),

        'questions' => Question::Where('delete_flg','=', 0)
            ->orderByRaw('chapter_no, sort_no')
            ->get(),

        'events' => Event::Where('delete_flg','=', 0)
            ->Where('end_flg','=', 1)
            ->orderByRaw('event_date')
            ->get(),

        'majorities' => Majority::Select( 'event_id','point')
            ->Where('user_id', '=', Auth::id())
            ->get(),

        'avg_majorities' => Majority::Select('event_id')
            ->selectRaw('ROUND(AVG(point),0) AS avg_point')
            ->Groupby('event_id')
            ->get(),

        'total_points' => TotalPoint::Select( 'event_id','question_id')
            ->selectRaw('ROUND(point,2) AS point')
            ->Where('user_id', '=', Auth::id())
            ->orderByRaw('event_id,question_id')
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

        'sum_total_points' => TotalPoint::Select( 'event_id')
            ->selectRaw('ROUND(SUM(point),0) AS point')
            ->Where('user_id', '=', Auth::id())
            ->Groupby('event_id')
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

        'users' => User::Where('admin_flg','=', 0)
            ->Where('delete_flg','=', 0)
            ->orderbyRaw('id')
            ->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


require __DIR__.'/auth.php';

