<?php

namespace Modules\User\app\Resources;

use App\ModelInterfaces\AdminModelInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Laravel\Passport\PersonalAccessTokenResult;

class AdminLoginResource extends JsonResource
{
    public function __construct(public AdminModelInterface $admin, public PersonalAccessTokenResult $token)
    {
        parent::__construct($this);
    }

    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->admin->name,
            'token' => $this->token->accessToken,
        ];
    }
}
