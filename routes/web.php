<?php
use Illuminate\Http\Request;
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
    return view('welcome');
});










//测试
Route::get('/zzw', function (Request $request) {
    return "web zzw";
});

Route::get('/zzw1', function (Request $request) {
    return "web zzw";
})->middleware('auth.basic');

//http://localhost/zzw/abc?name=1234
Route::get('/zzw2/{extra?}', function (Request $request, $extra1 = 'default') {
	$fullurl = $request->fullurl();
	$name = $request->input('name');
    return "zzw2 " . $extra1 . ' ' . $name;
    ;
});

Route::get('testCsrf1',function(){
    $csrf_field = csrf_field();
    $html = <<<GET
        <form method="POST" action="/testCsrf">
            {$csrf_field}
            <input type="submit" value="Test"/>
        </form>
GET;
    return $html;
});

Route::get('testCsrf2',function(){
    $html = <<<GET
        <form method="POST" action="/testCsrf">
            <input type="submit" value="Test"/>
        </form>
GET;
    return $html;
});

Route::post('testCsrf',function(){
    return 'Success!';
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
