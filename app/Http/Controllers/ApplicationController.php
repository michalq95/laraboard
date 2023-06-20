<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Http\Resources\ApplicationResource;
use App\Models\Offer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ApplicationResource::collection(Application::orderBy('created_at', 'desc')->paginate(25));
    }

    public function companyApplications()
    {
        $applications = Auth::user()->company->applications->where('status', 0);
        return ApplicationResource::collection($applications);
    }

    public function myApplications()
    {
        $twoWeeksAgo = Carbon::now()->subWeeks(2);
        $applications = Auth::user()->applications->where('updated_at', '>=', $twoWeeksAgo);
        return ApplicationResource::collection($applications);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreApplicationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApplicationRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $fileName = Str::random(40) . '.pdf';
            $path = $file->storeAs('resumes', $fileName, 'public');
            $data['resume'] = $path;
        }

        $data["user_id"] = Auth::user()->id;
        $result = Application::create($data);
        return new ApplicationResource($result);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        return new ApplicationResource($application);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateApplicationRequest  $request
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApplicationRequest $request, Application $application)
    {
        $data = $request->validated();
        $application->update($data);

        return new ApplicationResource($application);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }

    public function getPdf(Application $application)
    {

        if ($application->user_id !== auth()->user()->id and $application->offer->company->user_id !== auth()->user()->id) {
            abort(403, 'Unauthorized');
        }
        $filePath = $application->resume;

        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download($filePath);
    }
}