<?php

use App\Models\ImageHash;
use Bepsvpt\Blurhash\Facades\BlurHash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/blur/url/', function (Request $request) {
    $url    = $request->input('url');
    $result = ['hash' => 'L1TSUA?bfQ?b~qj[fQj[fQfQfQfQ'];

    try {
        $result['hash'] = BlurHash::encode($url);
    } catch (\Throwable $error) {

        Log::error($error->getMessage(), [
            'code' => $error->getCode(),
            'url' => $url
        ]);
    }

    return $result;
});

Route::post('/blur/url/store', function (Request $request) {
    $url    = $request->input('url');
    $result = ['hash' => 'L1TSUA?bfQ?b~qj[fQj[fQfQfQfQ'];

    try {
        $hash = ImageHash::where(['urlHash' => md5($url)])
            ->firstOr(function () use ($url) {
                $hash                  = BlurHash::encode($url);
                $storedHash            = new ImageHash();
                $storedHash->imageHash = $hash;
                $storedHash->urlHash   = md5($url);
                $storedHash->save();

                return $storedHash;
            });

        $result['hash'] = $hash->imageHash ?? $result['hash'];
    } catch (\Throwable $error) {

        Log::error($error->getMessage(), [
            'code' => $error->getCode(),
            'url' => $url
        ]);
    }

    return $result;
});
