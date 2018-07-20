<?php
/**
 * Created by PhpStorm.
 * User: jdiazc
 * Date: 7/20/18
 * Time: 2:20 PM
 */

require_once __DIR__.'/../vendor/autoload.php';


$conditionInstance = new Notification\Firebase\Condition();
$conditionInstance->addTopic('android');
$conditionInstance->addTopic('sports');
$conditionInstance->setOperator(Notification\Firebase\Condition::OR_CONDITION);
var_dump($conditionInstance->retrieveTopicCondition());