<?php

namespace App\Http\Controllers\Api;

use App\BranchCatalog;
use App\CityCatalog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CatalogsController extends Controller
{
    public function branchesList()
    {
        $params = Input::all();
        $params['actual'] = 1;

        $branches = BranchCatalog::getCollection($params)->get();

        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $branches
        ]);
    }

    public function citiesList()
    {
        $params = Input::all();
        $params['actual'] = 1;

        $cities = CityCatalog::getCollection($params)->get();

        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $cities
        ]);
    }

    public function countiesList()
    {
        $params = Input::all();
        $params['actual'] = 1;

        $counties = CityCatalog::getCollection($params)->get();

        return response()->json([
            'success' => true,
            'status' => 200,
            'data' => $counties
        ]);
    }
}
