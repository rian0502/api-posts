<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryModel;
use App\Http\Controllers\Controller;

class CateogryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $categori = CategoryModel::all();
        return response()->json([
            'status' => 'success',
            'data' => $categori
        ]);
    }
}
