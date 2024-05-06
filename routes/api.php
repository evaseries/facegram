<?php

use App\Http\Controllers\api\authController;
use App\Http\Controllers\api\postController;
use Illuminate\Http\Request;
use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'v1/auth'
], function () {
    Route::post('register', [authController::class, 'register']);
    Route::post('login', [authController::class, 'login']);
    Route::get('me', [authController::class, 'me']);

});
Route::group([
    'middleware'=> 'api',
    'prefix'=> 'v1/post'
], function () {
    Route::post('/', [postController::class,'create']);
    Route::delete('/:{id}', [postController::class,'delete']);
}
);
// route::group(
//     [
//         'middleware'=> 'api',
//         'prefix'=> 'v1/user'
//     ],
//     function () {
//         Route::get('/getalluser', [postController::class,'getalluser']);
//     }
// )
// );
