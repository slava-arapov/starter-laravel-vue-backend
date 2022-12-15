<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        if ($request->user()->cannot('viewAny', User::class)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $itemsPerPage = 10;

        $lastPage = User::paginate($itemsPerPage)->lastPage();

        $request->merge([
            'page' => min($request->input('page'), $lastPage)
        ]);

        return UserResource::collection(User::paginate($itemsPerPage));
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \App\Http\Resources\UserResource|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request, User $user): UserResource|\Illuminate\Http\JsonResponse
    {
        if ($request->user()->cannot('view', $user)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return new UserResource($user);
    }

    /**
     * Creates user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('create', User::class)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'isAdmin' => 'boolean'
        ]);

        $user = User::create($request->all());

        if ($request['password']) {
            $user->password = \Hash::make($request['password']);
            $user->save();
        }

        return response()->json($user, 201);
    }

    /**
     * Updates user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        if ($request->user()->cannot('update', $user)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $request->validate([
            'name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'isAdmin' => 'boolean'
        ]);

        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'is_admin' => $request['isAdmin'],
        ]);

        if ($request['password']) {
            $user->password = \Hash::make($request['password']);
            $user->save();
        }

        if (isset($request['isAdmin'])) {
            $user->is_admin = $request['isAdmin'];
            $user->save();
        }

        return response()->json($user, 201);
    }

    /**
     * Deletes the specified resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request, User $user)
    {
        if ($request->user()->cannot('delete', $user)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $user->delete();
        return response()->json(null, 204);
    }
}
