<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductReques;
use App\Http\Requests\Api\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductResourceCollection;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $perPage = '6';
            $product = Product::query()->filterFromRequest()->whereStatusId('1')->latest()->paginate($perPage);
            return response_data(
                true,
                200,
                new ProductResourceCollection($product)
            );
        } catch (Exception $e) {
            return response_data(false, 500, null, 'Something went wrong...' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $product = Product::create($request->getData());
            DB::commit();
            return response_data(true, 200, ProductResource::make($product), 'Product Created successfully!');
        } catch (Exception $e) {
            DB::rollback();
            return response_data(false, 500, null, 'Something went wrong...' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $product = Product::query()->with('seller')->whereId($id)->firstOrFail();
            return response_data(true, 200, new ProductResource($product));
        } catch (Exception $e) {
            return response_data(false, 404, null, 'Something went wrong...' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();
            $productUpdate = $product->update($request->getData());
            DB::commit();
            return response_data(true, 200, ProductResource::make($product), 'Product Updated successfully!');
        } catch (Exception $e) {
            DB::rollback();
            return response_data(false, 500, null, 'Something went wrong...' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {


        try {
            $product = Product::query()->whereId($id)->delete();
            return response_data(true, 200, null, 'Product deleted successfully!');
        } catch (Exception $e) {
            return response_data(false, 404, null, 'Something went wrong...' . $e->getMessage());
        }
    }
}
