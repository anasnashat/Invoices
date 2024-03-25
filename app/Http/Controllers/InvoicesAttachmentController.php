<?php

namespace App\Http\Controllers;

use App\Http\Requests\AttachmentRequest;
use App\Models\InvoicesAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttachmentRequest $request)
    {
        $attachment = $request->validated();
        $attachment['user_id'] = auth()->id();
//        dd($request->file('attachment'));
        $attachment['attachment'] = $request->file('attachment')
            ->storeAs(
                'attachment/' . $request->invoice_number,
                $request->attachment->getClientOriginalName()
            );

        InvoicesAttachment::create($attachment);
        return redirect()->route('invoices.show',$request->invoice_id);
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoicesAttachment $invoicesAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoicesAttachment $invoicesAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoicesAttachment $invoicesAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoicesAttachment $invoicesAttachment)
    {
        //
    }

    public function download($file_folder,$filename)
    {

            return Storage::disk('public')
                ->temporaryUrl("{$file_folder}/{$filename}", now()->addMinutes(5));

    }
}
