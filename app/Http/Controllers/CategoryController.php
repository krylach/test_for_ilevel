<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;

class CategoryController extends Controller
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
        $validate = $this->validator($request, ['name'], ['name' => 'required|max:255|unique:products']);

        if (!$validate) {
            $category = new Category;
            $category->name = $request->input('name');
            $category->save();

            return new CategoryResource($category);
        }

        return $validate;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return CategoryResource::collection($category->all());
    }

    public function showProducts($id)
    {
        $category = Category::find($id);

        return $category 
            ? ProductResource::collection($category->products) 
            : response()->json(['message' => 'This `category` not defined!'], 422);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entities\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate = $this->validator($request, ['name'], ['name' => 'required|max:255|unique:products']);

        if (!$validate) {
            $category = Category::find($id);
            $category->name = $request->input('name');
            $category->save();

            return CategoryResource::collection($category->all());
        }

        return $validate;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, $id)
    {
        $currentCategory = Category::find($id);
        $currentCategory->products()->detach();
        $currentCategory->delete();

        return CategoryResource::collection($category->all());
    }

    private function validator(Request $request, Array $inputs, Array $validator)
    {
        $validate = Validator::make($request->only($inputs), $validator);
        
        return count($validate->errors()) == 0
            ? false 
            : response()->json($validate->errors(), 422);
    }
}
