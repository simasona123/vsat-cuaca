<?php

use App\Models\User;
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

Route::get('/pelaporan', function (Request $request) {
    $user = Auth::user();
    $data = [];
    $data['alor'] = DB::table('grafana_alor')->orderBy('Time', 'DESC')->first();
    $data['merauke'] = DB::table('grafana_merauke')->orderBy('Time', 'DESC')->first();
    $data['nama'] = ($user->name == 'alor') ? 'alor' : 'mopah';
    $data['stasiun'] = ($user->name == 'alor') ? 'Stasiun Meteorologi Alor' : 'Stasiun Meteorologi Mopah';
    $data['am_pm'] = [Carbon::parse($data['merauke']->Time)->hour < 18 ? 'am' : 'pm', Carbon::parse($data['alor']->Time)->hour < 18 ? 'am' : 'pm'];
    $data['cuaca'] = [
        'Cerah' => "https://bmkg.go.id/asset/img/icon-cuaca/cerah",
        'Hujan Ringan Sedang' => "https://bmkg.go.id/asset/img/icon-cuaca/hujan ringan",
        'Hujan Ringan-Sedang' => "https://bmkg.go.id/asset/img/icon-cuaca/hujan ringan",
        'Hujan Lebat' => "https://bmkg.go.id/asset/img/icon-cuaca/hujan lebat",
    ];
    // if($user->name == 'alor'){
    //     $data['feedbacks'] = DB::table('feedback_alor')->orderBy('Time', 'DESC')->limit(10)->get();
    //     $data['stasiun'] = 'Stasiun Meteorologi Alor';
    //     $data['nama'] = 'alor';
    // } else {
    //     $data['feedbacks'] = DB::table('feedback_merauke')->orderBy('Time', 'DESC')->limit(10)->get();
    //     $data['stasiun'] = 'Stasiun Meteorologi Mopah';
    //     $data['nama'] = 'mopah';
    // }
    return view('welcome', $data);
})->middleware('auth.basic');

Route::post('/pelaporan', function (Request $request){
    $form = $request->all();
    $user = Auth::user();
    $time = Carbon::now();
    $feedback_weather = $form['cuaca'];
    if($user->name == 'alor'){
        $insert = DB::insert('
            insert into alor_feedbacks (created_at, feedback) values (?, ?)', 
            [Carbon::now(), $feedback_weather]);
        
    } else {
        $insert = DB::insert('
            insert into merauke_feedbacks (created_at, feedback) values (?, ?)', 
            [Carbon::now(), $feedback_weather]);
    }
    return redirect('/')->with('status', 'true');
})->middleware('auth.basic');

Route::get('/setup', function(){
    if ($user = User::find(1)){
        return redirect('/');
    }else{
        User::create([
            'name'=> 'alor',
            'email'=> 'alor@admin.com',
            'password' => 'alorvsatcuaca'
        ]);
        User::create([
            'name'=> 'mopah',
            'email'=> 'mopah@admin.com',
            'password' => 'mopahvsatcuaca'
        ]);
        return redirect('/setup-berhasil');
    }
});

Route::get('/', function(){
    $data = [];
    $data['alor_feedbacks'] = DB::table('alor_feedbacks')->orderBy('created_at', 'DESC')->limit(10)->get();
    $data['merauke_feedbacks'] = DB::table('merauke_feedbacks')->orderBy('created_at', 'DESC')->limit(10)->get();
    $data['alor'] = DB::table('grafana_alor')->orderBy('Time', 'DESC')->first();
    $data['merauke'] = DB::table('grafana_merauke')->orderBy('Time', 'DESC')->first();
    $data['am_pm'] = [Carbon::parse($data['merauke']->Time)->hour < 18 ? 'am' : 'pm', Carbon::parse($data['alor']->Time)->hour < 18 ? 'am' : 'pm'];
    $data['cuaca'] = [
        'Cerah' => "https://bmkg.go.id/asset/img/icon-cuaca/cerah",
        'Hujan Ringan Sedang' => "https://bmkg.go.id/asset/img/icon-cuaca/hujan ringan",
        'Hujan Ringan-Sedang' => "https://bmkg.go.id/asset/img/icon-cuaca/hujan ringan",
        'Hujan Lebat' => "https://bmkg.go.id/asset/img/icon-cuaca/hujan lebat",
    ];
    return view('dashboard', $data);
});
