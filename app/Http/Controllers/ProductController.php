<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset(request()->judul))
        {
            $products = Product::where('judul', 'like', '%'.request()->judul.'%')->orderBy('id', 'desc')->get();
        } else {
            $products = Product::orderBy('id', 'desc')->get();

        }
        // return response()->json($products);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'judul' => ['required','min:3', 'max:255'],
            'deskripsi' => ['required'],
            'foto' => ['required','min:15', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),412);
        }
        
        $product = Product::create($request->all());
        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // return response()->json($product, 200);
        return new ProductResource($product);
         
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'judul' => ['required','min:3', 'max:255'],
            'deskripsi' => ['required'],
            'foto' => ['required','min:15', 'max:255']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),412);
        }

        $product->update($request->all());
        return response()->json($product, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([], 204);
    }
}
