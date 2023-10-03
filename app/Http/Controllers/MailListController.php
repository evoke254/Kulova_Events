<?php

namespace App\Http\Controllers;

use App\Models\MailList;
use Illuminate\Http\Request;

class MailListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('mail_list.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('mail_list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MailList $mailList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MailList $mailList)
    {
        //

        return view('mail_list.edit', compact('mailList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MailList $mailList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MailList $mailList)
    {
        //
    }
}
