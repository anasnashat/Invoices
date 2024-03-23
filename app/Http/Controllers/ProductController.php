<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('section')->paginate(20);
        $sections = Section::all();
        return view('products.index',['products' => $products, 'sections' => $sections]);
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
            $validatedData = $request->validated();
            $validatedData['user_id'] = auth()->id();
            Product::create($validatedData);
            DB::commit();

            return redirect()->route('products.index')->with('success', 'تمت الإضافة بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('products.index')->with('error', 'حدث خطأ أثناء إضافة القسم');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
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
            $validatedData = $request->validated();
            $product->update($validatedData);
            DB::commit();

            return redirect()->route('products.index')->with('success', 'تمت التعديل بنجاح');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('products.index')->with('error', 'حدث خطأ أثناء تعديل القسم');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        try {
            DB::beginTransaction();
            DB::commit();
            return redirect()->route('products.index')->with('success', 'تم حذف هذا المتج بنجاح ');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('products.index')->with('error', 'حدث خطأ أثناء حذف المنتج');
        }
    }
}
