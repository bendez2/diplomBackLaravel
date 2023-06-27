<?php

namespace App\Http\Controllers;

use App\Http\Resources\TypeApplicationResource;
use Illuminate\Support\Facades\DB;
use App\Models\TypeApplication;
use Illuminate\Http\Request;

class TypeApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  TypeApplicationResource::collection(TypeApplication::all());

//        $results = DB::select('select * from type_applications');
//        return $results;
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
    public function show(TypeApplication $typeApplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeApplication $typeApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeApplication $typeApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeApplication $typeApplication)
    {
        //
    }
}
