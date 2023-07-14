<?php

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function (Request $request) {
    $user = Auth::user();
    $data = [];
    $data['alor'] = DB::table('grafana_alor')->orderBy('Time', 'DESC')->first();
    $data['merauke'] = DB::table('grafana_merauke')->orderBy('Time', 'DESC')->first();
    if($user->name == 'alor'){
        $data['feedbacks'] = DB::table('feedback_alor')->orderBy('Time', 'DESC')->limit(10)->get();
        $data['stasiun'] = 'Stasiun Meteorologi Alor';
        $data['nama'] = 'alor';
    } else {
        $data['feedbacks'] = DB::table('feedback_merauke')->orderBy('Time', 'DESC')->limit(10)->get();
        $data['stasiun'] = 'Stasiun Meteorologi Mopah';
        $data['nama'] = 'mopah';
    }
    return view('welcome', $data);
})->middleware('auth.basic');

Route::post('/', function (Request $request){
    $form = $request->all();
    $user = Auth::user();
    $time = Carbon::now();
    $location = $form['lat'] . ", " . $form['lon'];
    $feedback_weather = $form['cuaca'];
    if($user->name == 'alor'){
        $insert = DB::insert('
            insert into feedback_alor (time, location, feedback_weather) values (?, ?, ?)', 
            [$time, $location, $feedback_weather]);
        
    } else {
        $insert = DB::insert('
            insert into feedback_merauke (time, location, feedback_weather) values (?, ?, ?)', 
            [$time, $location, $feedback_weather]);
    }
    return redirect('/');
})->middleware('auth.basic');
