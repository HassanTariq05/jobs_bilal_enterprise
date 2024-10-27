<?php

namespace App\Http\Controllers;

use App\Models\JobPerformanceSheetData;
use App\Http\Requests\StoreJobPerformanceSheetDataRequest;
use App\Http\Requests\UpdateJobPerformanceSheetDataRequest;

use Illuminate\Support\Facades\DB;

class JobPerformanceSheetDataController extends Controller
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
    public function store(StoreJobPerformanceSheetDataRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(JobPerformanceSheetData $jobPerformanceSheetData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobPerformanceSheetData $jobPerformanceSheetData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateJobPerformanceSheetDataRequest $request, JobPerformanceSheetData $jobPerformanceSheetData)
    {
        //
    }

    /**
     * Trash the specified resource from storage.
     */
    public function trash(JobPerformanceSheetData $jobPerformanceSheetData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobPerformanceSheetData $jobPerformanceSheetData)
    {
        //
    }
}
