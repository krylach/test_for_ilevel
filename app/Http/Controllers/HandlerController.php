<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HandlerController extends Controller
{
    /*
     *  Туточки будет многа букаф, вывод всего
     */

    private $headerToken = [];

    public function show()
    {
        //Обрабатываем токен
        $this->assignToken();

        //Список продуктов конкретной категории
        $listProductsFromCategory = $this->getProductsFromCategory();

        //Выбранный продукт
        $selectedProductId = request()->input('selected_product_id') 
            ? request()->input('selected_product_id') 
            : null;

        $selectedProduct = $selectedProductId 
            ? $this->getSelectedProduct($selectedProductId) 
            : [];

        $selectedCategoriesFromThisProduct = isset($selectedProduct['categories'])
            ? array_column($selectedProduct['categories'], 'id')
            : [];

        //Экшины, ужасный метод, я знаю
        if ($this->createCategory()) {
            return redirect()->to('/');
        }
        if ($this->editCategory()) {
            return redirect()->to('/');
        }
        if ($this->editProduct()) {
            return redirect()->to("/?selected_product_id={$selectedProductId}");
        }

        
        // ну вы поняли
        return view('handler', [
            'list_categories' => $this->getCategories()->json()['data'],
            'list_products' => $listProductsFromCategory['data'],
            'all_list_products' => $this->getProducts()->json()['data'],
            'selected_product'  => $selectedProduct,
            
            'select_category_id' => request()->input('select_category_id'),
            'selected_product_id' => $selectedProductId,
            'selected_categories_from_this_product' => $selectedCategoriesFromThisProduct,
        ]);       
    }

    private function editCategory()
    {
        if (request()->input('new_name_category') && $id = request()->input('select_category_id')) {
            $this->httpWithToken()
                ->post(\url('/') . "/api/categories/{$id}/edit", [
                    'name' => request()->input('new_name_category')
                ]);

            return true;
        }

        return false;
    }

    private function editProduct()
    {
        if (request()->input('product_categories') && request()->input('new_name_product') && $id = request()->input('selected_product_id')) {
            if (is_array(request()->input('product_categories'))) {
                $response = $this->httpWithToken()
                    ->post(\url('/') . "/api/products/{$id}/edit", [
                        'name' => request()->input('new_name_product'),
                        'categories' => request()->input('product_categories'),
                    ]);
                    
                return true;
            }
        }

        return false;
    }

    private function getSelectedProduct($id)
    {
        if ($id) {
            $products = $this->getProducts()->json()['data'];

            return $products[array_search($id, array_column($products, 'id'))];
        }

        return null;
    }

    private function createCategory()
    {
        if (request()->input('name_category')) {
            $this->httpWithToken()
                ->post(\url('/') . '/api/categories/create', [
                    'name' => request()->input('name_category')
                ]);

            return true;
        }

        return false;
    }

    private function getCategories()
    {
        // получаем список категорий
        return $this->httpWithToken()
            ->post(\url('/') . '/api/categories', []);
    }

    private function getProducts()
    {
        return $this->httpWithToken()
            ->post(\url('/') . '/api/products');
    }

    private function getProductsFromCategory()
    {
        if ($id = request()->input('select_category_id')) {
            return $this->httpWithToken()
                ->post(\url('/') . '/api/categories/' . $id . '/products', []);
        }
    }

    private function httpWithToken()
    {
        return Http::withHeaders($this->headerToken);
    }

    private function assignToken()
    {
        // Получаем токен
        $token = $this->getToken('email@email.com', '12345678')->json();

        if ($token && !request()->session()->get('token')) {
            request()->session()->put('token', $token['token']);
            $this->headerToken = ['Authorization' => 'Bearer ' . $token['token']];
        } else {
            $this->headerToken = ['Authorization' => 'Bearer ' . request()->session()->get('token')];
        }
    }

    private function getToken(String $email, String $password)
    {
        return Http::post(\url('/') . '/api/login', [
            'email' => $email,
            'password' => $password
        ]);
    }

}
