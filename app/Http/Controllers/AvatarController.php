<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AvatarController extends Controller
{
    /**
     * @return \App\Http\Resources\UserResource|\Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // ToDo: Delete old avatar file
            /** @var null|\App\Models\User $user */
            $user = Auth::user();

            if ($user) {
                /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
                $disk = Storage::disk('public');
                $filePath = $disk->putFile('avatars/user-'.$user->id, $request->file, 'public');
                if ($filePath) {
                    $user->avatar = Storage::url($filePath);
                    $user->save();
                }
            }
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 409);
        }

        return new UserResource($user);
    }
}
