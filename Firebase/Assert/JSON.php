<?php
/**
 * Created by PhpStorm.
 * User: jdiazc
 * Date: 7/13/18
 * Time: 2:02 PM
 */


namespace Notification\Firebase\Assert;
use Notification\Exception\JSONException;

/**
 * Class JSON
 * @package Notification\Firebase\Assert
 * @author Jonathan Díaz <jgdiazcherrez@gmail.com>
 */
class JSON {

    /**
     * Retrieve and Valid JSON String
     * @param string $jsonValue
     * @return string
     * @throws JSONException
     */
    public static function retrieveAndValidData($jsonValue)
    {
        $decodedValue = json_decode($jsonValue);

        if (json_last_error() != JSON_ERROR_NONE) {
            throw new JSONException(json_last_error_msg());
        }
        return $decodedValue;

    }
}