<?php

namespace App\Http\Controllers;

use App\Models\CampaignTemplate;
use Illuminate\Http\Request;

class CampaignTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('campaign-template.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $campaignTemplate = null;
        return view('campaign-template.create', compact('campaignTemplate'));
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
    public function show(CampaignTemplate $campaignTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CampaignTemplate $campaignTemplate)
    {
        return view('campaign-template.create', compact('campaignTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CampaignTemplate $campaignTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CampaignTemplate $campaignTemplate)
    {
        //
    }
}
