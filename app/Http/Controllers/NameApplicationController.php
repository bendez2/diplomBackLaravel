<?php

namespace App\Http\Controllers;

use App\Http\Resources\NameApplicationResource;
use Illuminate\Support\Facades\DB;
use App\Models\NameApplication;
use Illuminate\Http\Request;

class NameApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $results = NameApplicationResource::collection(NameApplication::all());
        return $results;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NameApplication $nameApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NameApplication $nameApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NameApplication $nameApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NameApplication $nameApplication)
    {
        //
    }
}
