<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserApiResource;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function getUser(Request $request){
        $query = User::with(['detail', 'location']);

        if($request->gender){
            $query->whereHas('detail', function ($q) use ($request){
                $q->where('gender', $request->gender);
            });
        }

        if($request->city){
            $query->whereHas('location', function ($q) use ($request){
                $q->where('city', $request->city);
            });
        }

        if($request->country){
            $query->whereHas('location', function ($q) use ($request){
                $q->where('country', $request->country);
            });
        }

        $limit = $request->limit ?? 10;

        $allUsers = UserApiResource::collection($query->limit($limit)->get());
        //$allUsers = $query->limit($limit)->get();

        return response()->json($allUsers);
    }
}
