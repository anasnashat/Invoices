<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Import DB facade

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::paginate(20);
        return view('sections.index', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validated();
            $validatedData['created_by'] = auth()->id();
            Section::create($validatedData);

            DB::commit();
            return redirect()->route('sections.index')->with('success', 'تمت الإضافة بنجاح');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaction in case of error
            return redirect()->route('sections.index')->with('error', 'حدث خطأ أثناء إضافة القسم');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionRequest $request, Section $section)
    {
        try {
            DB::beginTransaction(); // Start transaction

            $section->update($request->validated());

            DB::commit(); // Commit transaction

            return redirect()->route('sections.index')->with('success', 'تم تعديل القسم بنجاح');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaction in case of error
            return redirect()->route('sections.index')->with('error', 'حدث خطأ أثناء تعديل القسم');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        try {
            DB::beginTransaction(); // Start transaction

            $section->delete();

            DB::commit(); // Commit transaction

            return redirect()->route('sections.index')->with('success', 'تم حذف القسم بنجاح');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback transaction in case of error
            return redirect()->route('sections.index')->with('error', 'حدث خطأ أثناء حذف القسم');
        }
    }


    public function getProducts($id)
    {
        $states =DB::table('products')->where('section_id', $id)->pluck('product_name','id');
        return json_decode($states);
    }
}
