<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

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
                $image = $request->file;

                $resizedImage = \Image::make($image)
                    ->resize(1920, 1080, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->encode('jpg');

                // Generate unique filename
                $uuid = Uuid::uuid4()->toString();
                $base64 = base64_encode(hex2bin(str_replace('-', '', $uuid)));
                $uniqueFilename = str_replace(['=', '+', '/'], ['', '-', '_'], $base64);

                $disk->delete($user->avatar);

                $filePath = "avatars/{$user->id}-{$uniqueFilename}.jpg";

                if ($disk->put($filePath, $resizedImage, 'public')) {
                    $user->avatar = $filePath;
                    $user->save();
                }
            }
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 409);
        }

        return new UserResource($user);
    }
}
