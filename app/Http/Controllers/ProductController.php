<?php

namespace App\Http\Controllers;

use App\Entities\Product;
use App\Entities\Category;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $this->validator($request, ['name', 'categories'], [
            'name' => 'required|max:255|unique:products',
            'categories' => 'required',
            'categories.*' => 'exists:App\Entities\Category,id'
        ]);

        if (!$validate) return $this->handler($request);
         
        return $validate;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return ProductResource::collection($product->all());
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entities\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $this->validator($request, ['name', 'categories'], [
            'name' => 'max:255',
            'categories' => 'array',
            'categories.*' => 'exists:App\Entities\Category,id'
        ]);

        $product = Product::find($id);

        if (!$validate) {
            return $this->handler($request, $product);
        } 
        
        return $validate;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {
        $currentProduct = Product::find($id);
        $currentProduct->categories()->detach();
        $currentProduct->delete();

        return ProductResource::collection($product->all());
    }

    private function validator(Request $request, Array $inputs, Array $validator)
    {
        $validate = Validator::make($request->only($inputs), $validator);
        
        return count($validate->errors()) == 0
            ? false 
            : response()->json($validate->errors(), 422);
    }

    private function handler(Request $request, Product $product = null)
    {
        if (!$product) {
            $product = new Product;
            $product->name = $request->input('name');
            $product->save();

            $attaching = []; 
            foreach ($request->categories as $key => $categoryFromRequest) {
                $attaching[] = ['category_id' => $categoryFromRequest];
            }

            $product->categories()->attach($attaching);

            return new ProductResource($product->first());
        }

        

        if ($request->input('categories')) { 
            $attachFromProductHasBeen = []; 
            foreach ($request->categories as $key => $categoryFromRequest) {
                $attachFromProductHasBeen[] = ['category_id' => $categoryFromRequest];
            }

            if ($attachFromProductHasBeen) {
                $product->categories()->detach();
                $product->categories()->attach($attachFromProductHasBeen);
            }
        }

        if ($request->input('name')) $product->name = $request->input('name');
        $product->save();

        return new ProductResource($product);
    }
}
