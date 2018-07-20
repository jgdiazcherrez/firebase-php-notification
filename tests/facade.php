<?php
/**
 * Created by PhpStorm.
 * User: jdiazc
 * Date: 7/20/18
 * Time: 2:46 PM
 */


$facade = new Notification\Facade((new Notification\Firebase\Dispatcher())->setAuthorization('YOUR_AUTHORIZATION_CODE_HERE'));
//TODO: Notification
$facade->sendNotification('titulo test', 'text test');
//TODO: Test