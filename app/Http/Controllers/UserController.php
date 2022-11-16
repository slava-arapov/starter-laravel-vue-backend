<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        /** @var null|User $currentUser */
        $currentUser = Auth::user();
        if (null !== $currentUser && $currentUser->isAdmin()) {
            $itemsPerPage = 1;

            $lastPage = User::paginate($itemsPerPage)->lastPage();

            $request->merge([
                'page' => min($request->input('page'), $lastPage)
            ]);

            return UserResource::collection(User::paginate($itemsPerPage));
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
