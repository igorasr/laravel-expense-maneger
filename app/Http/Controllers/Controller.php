<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Server(url="http//localhost:8000")
 * @OA\Info(title="Expense Maneger", version="1.0")
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;


    public function success($dto){
        return response()->json($dto, 200);
    }

    public function created($dto){
        return response()->json($dto, 201);
    }

    public function clientFail($dto){
        return response()->json($dto, 400);
    }

    public function fail(){
        return response()->json('Internal Server Error', 500);
    }
}
