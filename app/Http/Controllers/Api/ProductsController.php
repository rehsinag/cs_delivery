<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller
{
    public function pList()
    {
        $params = Input::all();
        $params['actual'] = 1;

        $products = Product::getCollection($params)->get();

        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $products
        ]);
    }
}
