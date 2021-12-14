<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        /** @var null|User $currentUser */
        $currentUser = Auth::user();
        if (null !== $currentUser && $currentUser->isAdmin()) {
            return UserResource::collection(User::paginate(10));
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }

    /**
     * Display the specified resource.
     *
     * @return \App\Http\Resources\UserResource|\Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        /** @var null|User $currentUser */
        $currentUser = Auth::user();
        if (null !== $currentUser && $currentUser->isAdmin()) {
            return new UserResource($user);
        }

        return response()->json(['message' => 'Forbidden'], 403);
    }
}
