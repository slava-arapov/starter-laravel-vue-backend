<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property integer $email_verified_at
 * @property string $avatar
 * @property string $password
 * @property string $two_factor_secret
 * @property string $two_factor_recovery_codes
 * @property bool $is_admin
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @method boolean isAdmin()
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     * @noinspection PhpReturnDocTypeMismatchInspection
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'isAdmin' => $this->isAdmin(),
            'email_verified_at' => $this->email_verified_at,
        ];
    }
}
