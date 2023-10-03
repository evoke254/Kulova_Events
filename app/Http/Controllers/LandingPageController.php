<?php

namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('landing-page.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('landing-page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(LandingPage $landingPage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LandingPage $landingPage)
    {
        return view('landing-page.edit', compact('landingPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LandingPage $landingPage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LandingPage $landingPage)
    {
        //
    }


    public function pageGet(LandingPage $landingPage){

        if (is_null($landingPage->grapes)){
            $body = ['pages'=>[0=>['id'=>'IaHO5SGG9cjs3okb','frames'=>[0=>['id'=>'hD8Qqo0WTmzvHLjs','component'=>['type'=>'wrapper','stylable'=>[0=>'background',1=>'background-color',2=>'background-image',3=>'background-repeat',4=>'background-attachment',5=>'background-position',6=>'background-size',],'components'=>[0=>['classes'=>[0=>'text-gray-600',1=>'body-font',],'tagName'=>'section','components'=>[0=>['classes'=>[0=>'container',1=>'mx-auto',2=>'flex',3=>'px-5',4=>'py-24',5=>'items-center',6=>'justify-center',7=>'flex-col',],'components'=>[0=>['type'=>'image','classes'=>[0=>'lg:w-2/6',1=>'md:w-3/6',2=>'w-5/6',3=>'mb-10',4=>'object-cover',5=>'object-center',6=>'rounded',],'resizable'=>['ratioDefault'=>1,],'attributes'=>['alt'=>'hero','src'=>'https://dummyimage.com/720x600',],],1=>['classes'=>[0=>'text-center',1=>'lg:w-2/3',2=>'w-full',],'components'=>[0=>['type'=>'text','classes'=>[0=>'title-font',1=>'sm:text-4xl',2=>'text-3xl',3=>'mb-4',4=>'font-medium',5=>'text-gray-900',],'tagName'=>'h1','components'=>[0=>['type'=>'textnode','content'=>'Microdosingsynthtattooedvexillologist',],],],1=>['type'=>'text','classes'=>[0=>'mb-8',1=>'leading-relaxed',],'tagName'=>'p','components'=>[0=>['type'=>'textnode','content'=>'MeggingskinfolkechoparkstumptownDIY,kalechipsbeardjianbingtousled.Chambraydreamcatchertrustfund,kitschvicegodarddisruptrampshexagonmustacheumamisnackwavetildechillwaveugh.Pour-overmeditationPBR&Bpickledennuiceliacmlkshkfreeganphotoboothaffingerstachepitchfork.',],],],2=>['classes'=>[0=>'flex',1=>'justify-center',],'components'=>[0=>['text'=>'Button','type'=>'button','classes'=>[0=>'inline-flex',1=>'text-white',2=>'bg-indigo-500',3=>'border-0',4=>'py-2',5=>'px-6',6=>'focus:outline-none',7=>'hover:bg-indigo-600',8=>'rounded',9=>'text-lg',],'attributes'=>['type'=>'button',],'components'=>[0=>['type'=>'textnode','content'=>'Button',],],],1=>['text'=>'Button','type'=>'button','classes'=>[0=>'ml-4',1=>'inline-flex',2=>'text-gray-700',3=>'bg-gray-100',4=>'border-0',5=>'py-2',6=>'px-6',7=>'focus:outline-none',8=>'hover:bg-gray-200',9=>'rounded',10=>'text-lg',],'attributes'=>['type'=>'button',],'components'=>[0=>['type'=>'textnode','content'=>'Button',],],],],],],],],],],],],],],],],],'assets'=>[],'styles'=>[],];
        } else {
            $body = json_decode($landingPage->grapes);
        }

        return response()->json( ['data' => $body]);
    }

    public function pageUpload(Request $request, LandingPage $landingPage)
    {
        $landingPage->grapes = $request->data;
        $landingPage->save();

        return response()->json(['data' => $request->data]);
    }

}
