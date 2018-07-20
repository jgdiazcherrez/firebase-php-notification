<?php

namespace Notification\Firebase\Exception;

/**
 * Class ConditionException
 * @package Notification\Exception
 * @author Jonathan Díaz <jgdiazcherrez@gmail.com>
 */
class DispatchException extends AppException {

    /**
     * Message Authorization
     */
    const NOT_TOKEN_AUTHORIZATION_INCLUDED = "There isn't any token included";

    /**
     * Type Message
     */
    const UNSUPPORTED_TYPE_MESSAGE = "The messages's type isn't recognized";


}