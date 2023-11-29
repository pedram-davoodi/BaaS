<?php

namespace Modules\User\app\Exceptions;

use App\Exceptions\CustomException;
use Throwable;

/**
 * Class UserNotFoundException
 *
 * Exception thrown when a user is not found.
 */
class RestPasswordTokenException extends CustomException
{
    /**
     * UserNotFoundException constructor.
     */
    public function __construct(string $message = null, int $code = 400, Throwable $previous = null)
    {
        $message = $message ?? __('user.resetPasswordToken.notExpired');
        parent::__construct($code, $message, $previous);
    }
}
