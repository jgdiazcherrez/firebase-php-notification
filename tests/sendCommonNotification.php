<?php
/**
 * Created by PhpStorm.
 * User: jdiazc
 * Date: 7/20/18
 * Time: 1:40 PM
 */

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Send common notification using the dispatcher class. You have to add the authorization code and a message
 */

$instanceTest = new Notification\Firebase\Dispatcher();
$instanceTest->setAuthorization('YOUR_AUTHORIZATION_CODE_HERE');
$instanceTest->sendNotification([
    "priority" => "normal",
    "data" => [
        "url" => "https://www.elconfidencial.com/amp/espana/cataluna/2017-12-11/independencia-cataluna-supremo-marta-rovira_1490702/"
    ],
    "notification" => [
        "title" => "El confidencial",
        "body" => "10 días para las elecciones en cataluña",
        "click_action" => "https://www.elconfidencial.com/amp/espana/cataluna/2017-12-11/independencia-cataluna-supremo-marta-rovira_1490702/",
        "badge" => 0
    ],
    "time_to_live" => 1,
    "condition" => "'androind' in topics"
]);


