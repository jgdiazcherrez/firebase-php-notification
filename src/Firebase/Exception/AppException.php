<?php

namespace Notification\Firebase\Exception;


/**
 * Class AppException
 * @package Notification\Exception
 * @author Jonathan Díaz <jgdiazcherrez@gmail.com>
 */
class AppException extends \Exception{


    const NOT_LINK_ATTACHED = "There isn't any link included";

    const UNEXPECTED_ERROR = 'Unexpected error';

    const PRIORITY_NOT_ALLOWED = "The priority isn't allowed";
}