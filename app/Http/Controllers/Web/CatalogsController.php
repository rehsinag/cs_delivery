<?php

namespace App\Http\Controllers\Web;

use App\BranchCatalog;
use App\CityCatalog;
use App\CountyCatalog;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CatalogsController extends Controller
{
    /*
     *  ФИЛИАЛЫ (начало)
     */
    public function branchesIndex()
    {
        return view('catalogs.branches.index');
    }

    public function branchesList()
    {
        $params = Input::all();

        $branches = BranchCatalog::getCollection($params)->get();

        return view('catalogs.branches.list', [
            'branches' => $branches
        ]);
    }

    public function branchesEditForm()
    {
        $branchId = Input::get('branchId');

        $branch = new BranchCatalog();
        if($branchId)
        {
            $branch = BranchCatalog::find($branchId);
        }

        return view('catalogs.branches.edit', [
            'branch' => $branch,
        ]);
    }

    public function branchesSubmitForm()
    {
        $branchData = Input::all();

        $successMessage = $branchData['id'] ? 'Филиал был успешно обновлен.' : 'Филиал был успешно добавлен.';

        $branch = new BranchCatalog();

        $branch->setDataFromArray($branchData);

        $errors = $branch->validateData();

        if(!$errors)
        {
            if($branch->submitData())
            {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => $errors[0]
            ]);
        }
    }

    public function branchesDelete()
    {
        $branchId = Input::get('branchId');

        if($branchId)
        {
            $branch = BranchCatalog::find($branchId);
            if($branch)
            {
                $branch->status = Status::DELETED;

                if($branch->save())
                {
                    return response()->json([
                        'success' => true,
                        'message' => 'Филиал был успешно удален.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ошибка! Произошла ошибка при удалении филиала.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка! Не найден филиал с указанным идентификатором.'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка! Не передан идентификатор филиала.'
            ]);
        }
    }
    /*
     *  ФИЛИАЛЫ (конец)
     */


    /*
     *  ГОРОДА (начало)
     */
    public function citiesIndex()
    {
        return view('catalogs.cities.index');
    }

    public function citiesList()
    {
        $params = Input::all();

        $cities = CityCatalog::getCollection($params)->get();

        return view('catalogs.cities.list', [
            'cities' => $cities
        ]);
    }

    public function citiesEditForm()
    {
        $cityId = Input::get('cityId');

        $city = new CityCatalog();
        if($cityId)
        {
            $city = CityCatalog::find($cityId);
        }

        return view('catalogs.cities.edit', [
            'city' => $city,
        ]);
    }

    public function citiesSubmitForm()
    {
        $cityData = Input::all();

        $successMessage = $cityData['id'] ? 'Город был успешно обновлен.' : 'Город был успешно добавлен.';

        $city = new CityCatalog();

        $city->setDataFromArray($cityData);

        $errors = $city->validateData();

        if(!$errors)
        {
            if($city->submitData())
            {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => $errors[0]
            ]);
        }
    }

    public function citiesDelete()
    {
        $cityId = Input::get('cityId');

        if($cityId)
        {
            $city = CityCatalog::find($cityId);
            if($city)
            {
                $city->status = Status::DELETED;

                if($city->save())
                {
                    return response()->json([
                        'success' => true,
                        'message' => 'Город был успешно удален.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ошибка! Произошла ошибка при удалении города.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка! Не найден город с указанным идентификатором.'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка! Не передан идентификатор города.'
            ]);
        }
    }
    /*
     *  ГОРОДА (конец)
     */


    /*
     *  РАЙОНЫ (начало)
     */
    public function countiesIndex()
    {
        return view('catalogs.counties.index');
    }

    public function countiesList()
    {
        $params = Input::all();

        $counties = CountyCatalog::getCollection($params)->get();

        return view('catalogs.counties.list', [
            'counties' => $counties
        ]);
    }

    public function countiesEditForm()
    {
        $countyId = Input::get('countyId');

        $county = new CountyCatalog();
        if($countyId)
        {
            $county = CountyCatalog::find($countyId);
        }

        $cities = CityCatalog::getCollection(['actual' => 1])->get();

        return view('catalogs.counties.edit', [
            'county' => $county,
            'cities' => $cities
        ]);
    }

    public function countiesSubmitForm()
    {
        $countyData = Input::all();

        $successMessage = $countyData['id'] ? 'Район был успешно обновлен.' : 'Район был успешно добавлен.';

        $county = new CountyCatalog();

        $county->setDataFromArray($countyData);

        $errors = $county->validateData();

        if(!$errors)
        {
            if($county->submitData())
            {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => $errors[0]
            ]);
        }
    }

    public function countiesDelete()
    {
        $countyId = Input::get('countyId');

        if($countyId)
        {
            $county = CountyCatalog::find($countyId);
            if($county)
            {
                $county->status = Status::DELETED;

                if($county->save())
                {
                    return response()->json([
                        'success' => true,
                        'message' => 'Район был успешно удален.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ошибка! Произошла ошибка при удалении района.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка! Не найден район с указанным идентификатором.'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка! Не передан идентификатор района.'
            ]);
        }
    }
    /*
     *  РАЙОНЫ (конец)
     */
}
