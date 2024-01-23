<?php

namespace Modules\User\app\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\PersonalAccessTokenResult;
use App\ModelInterfaces\UserModelInterface;

class LoginResource extends JsonResource
{
    public function __construct(public UserModelInterface $user, public PersonalAccessTokenResult $token)
    {
        parent::__construct($this);
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->user->email,
            'token' => $this->token->accessToken,
        ];
    }
}
