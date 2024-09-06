<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PublicGrievance;
use Illuminate\Http\Request;
use App\Jobs\SendUserGrievanceMail;
use App\Jobs\SendAdminGrievanceMail;
use Illuminate\Support\Facades\Auth;

class PublicGrievanceController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|regex:/^[a-zA-Z\s]+$/',
                'mobile_number' => 'required|digits:10',
                'email' => ['required', 'email', 'max:255', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
                'address' => 'required|string|max:255|regex:/^[a-zA-Z0-9\/\-,&\s]+$/',
                'description' => 'required|string|max:500',
            ]);

            $validatedData['updated_by'] = Auth::id();

            $publicGrievance = PublicGrievance::create($validatedData);

            // Dispatch email jobs
            SendUserGrievanceMail::dispatch($publicGrievance);
            SendAdminGrievanceMail::dispatch($publicGrievance);

            return response()->json([
                'message' => 'Grievance submitted successfully',
                'data' => $publicGrievance
            ], 201);
        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json([
                'message' => 'Error submitting grievance',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}

