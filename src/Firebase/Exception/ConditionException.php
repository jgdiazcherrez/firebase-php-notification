<?php

namespace Notification\Firebase\Exception;
/**
 * Class ConditionException
 * @package Notification\Exception
 * @author Jonathan Díaz <jgdiazcherrez@gmail.com>
 */
class ConditionException extends AppException {

    const LIMIT_BY_TOPICS = 'Maximum 5 topics per request';

    const OPERATOR_NOT_ALLOWED = "This operator isn't allowed to compose the condition";

}