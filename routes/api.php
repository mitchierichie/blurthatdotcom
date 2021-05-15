<?php

use App\Models\ImageHash;
use Bepsvpt\Blurhash\Facades\BlurHash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use function Ramsey\Uuid\v5;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/blur/encode/', function (Request $request) {
        $image  = $request->input('image');
        $result = ['hash' => 'L1TSUA?bfQ?b~qj[fQj[fQfQfQfQ'];

        try {
            $result['hash'] = BlurHash::encode($image);
        } catch (\Throwable $error) {

            Log::error($error->getMessage(), [
                'code' => $error->getCode(),
                'image' => $image
            ]);
        }

        return $result;
    });

    Route::post('/blur/store/string', function (Request $request) {
        $image  = $request->input('image');
        $result = [
            'id' => null,
            'hash' => 'L1TSUA?bfQ?b~qj[fQj[fQfQfQfQ'
        ];

        try {
            if (!is_string($image)) {
                throw new Exception('Image or URL must be a string!');
            }
            $id   = v5(ImageHash::IMAGE_HASH_UUID_NAMESPACE, $image);
            $hash = $request->user()->image_hashes()->where([
                'urlHash' => $id,
            ])
                ->firstOr(function () use ($request, $image, $id) {
                    $hash                  = BlurHash::encode($image);
                    $storedHash            = new ImageHash();
                    $storedHash->imageHash = $hash;
                    $storedHash->urlHash   = $id;
                    $storedHash->user()->associate($request->user());
                    $storedHash->save();

                    return $storedHash;
                });

            $result['id']   = $id;
            $result['hash'] = $hash->imageHash ?? $result['hash'];
        } catch (\Throwable $error) {
            Log::error($error->getMessage(), [
                'code' => $error->getCode(),
                'url' => $image
            ]);
        }

        return $result;
    });

});
