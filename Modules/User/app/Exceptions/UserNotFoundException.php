<?php

namespace Modules\User\app\Exceptions;

use App\Exceptions\CustomException;
use Throwable;

/**
 * Class UserNotFoundException
 *
 * Exception thrown when a user is not found.
 *
 * @package Modules\User\app\Exceptions
 */
class UserNotFoundException extends CustomException
{
    /**
     * UserNotFoundException constructor.
     *
     * @param string|null $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = null, int $code = 404, ?Throwable $previous = null)
    {
        $message = $message ?? __("user.login.wrongCredential");
        parent::__construct($code, $message, $previous);
    }
}
