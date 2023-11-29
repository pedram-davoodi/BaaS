<?php

namespace Modules\User\app\Exceptions;

use App\Exceptions\CustomException;
use Throwable;

/**
 * Class LoginWrongCredentialException
 *
 * Exception thrown when login credentials are incorrect.
 */
class LoginWrongCredentialException extends CustomException
{
    /**
     * LoginWrongCredentialException constructor.
     */
    public function __construct(string $message = null, int $code = 401, Throwable $previous = null)
    {
        $message = $message ?? __('user.login.wrongCredential');
        parent::__construct($code, $message, $previous);
    }
}
