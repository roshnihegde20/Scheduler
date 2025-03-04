<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with(['gender', 'location'])
        ->when($request->filled('gender'), function ($query) use ($request) {
            $query->whereRelation('gender', 'gender', $request->gender);
        })
        ->when($request->filled('city'), function ($query) use ($request) {
            $query->whereRelation('location', 'city', $request->city);
        })
        ->when($request->filled('country'), function ($query) use ($request) {
            $query->whereRelation('location', 'country', $request->country);
        })
        ->limit($request->input('limit', 15)) // Default limit: 10
        ->get();

        $inputFields = $request->input('fields');

        if($inputFields)
        {
            $fieldsArray = explode(',', $inputFields);
            $users = $users->map(function ($user) use ($fieldsArray) {
                $userArray = $user->toArray();
                
                // Concatenate first_name and last_name as name
                $userArray['name'] = $user->first_name . ' ' . $user->last_name;
                
                // If specific fields are requested, return only those fields

                    // Ensure 'name' is included if 'first_name' or 'last_name' is selected
                    if (in_array('first_name', $fieldsArray) || in_array('last_name', $fieldsArray)) {
                        $fieldsArray = array_diff($fieldsArray, ['first_name', 'last_name']); // Remove first_name, last_name
                        $fieldsArray[] = 'name'; // Ensure name is included
                    }
                    return collect($userArray)->only($fieldsArray);
            
            });
            return collect($users);
        }

        return UserResource::collection($users);
    }
}
