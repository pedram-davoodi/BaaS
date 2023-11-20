<?php

namespace Modules\User\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\User\app\Models\User;
use Laravel\Passport\PersonalAccessTokenResult;

class LoginResource extends JsonResource
{
    public function __construct(public User $user ,public PersonalAccessTokenResult $token)
    {
        parent::__construct($this);
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->user->name,
            'token' => $this->token->accessToken,
        ];
    }
}
