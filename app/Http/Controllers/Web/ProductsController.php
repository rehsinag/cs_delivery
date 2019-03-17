<?php

namespace App\Http\Controllers\Web;

use App\Product;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ProductsController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function pList()
    {
        $params = Input::all();

        $products = Product::getCollection($params)->get();

        return view('products.list', [
            'products' => $products
        ]);
    }

    public function editForm()
    {
        $productId = Input::get('productId');

        $product = new Product();
        if($productId)
        {
            $product = Product::find($productId);
        }

        return view('products.edit', [
            'product' => $product,
        ]);
    }

    public function submitForm()
    {
        $productData = Input::all();

        $successMessage = $productData['id'] ? 'Продукт был успешно обновлен.' : 'Продукт был успешно добавлен.';

        $product = new Product();

        $product->setDataFromArray($productData);

        $errors = $product->validateData();

        if(!$errors)
        {
            if($product->submitData())
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

    public function delete()
    {
        $productId = Input::get('productId');

        if($productId)
        {
            $product = Product::find($productId);
            if($product)
            {
                $product->status = Status::DELETED;

                if($product->save())
                {
                    return response()->json([
                        'success' => true,
                        'message' => 'Продукт был успешно удален.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ошибка! Произошла ошибка при удалении продукта.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка! Не найден продукт с указанным идентификатором.'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка! Не передан идентификатор продукта.'
            ]);
        }
    }
}
