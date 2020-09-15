<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $uri = $request->url();
        return response()->json([
            'message' => 'Welcome to api kitana stroe'
        ]);
    }
}
