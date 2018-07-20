<?php
/**
 * Created by PhpStorm.
 * User: jdiazc
 * Date: 7/20/18
 * Time: 2:21 PM
 */

require_once __DIR__.'/../vendor/autoload.php';


$ios =  new Notification\Firebase\IOS((new Notification\Firebase\Dispatcher())->setAuthorization('YOUR_AUTHORIZATION_CODE_HERE'));
$ios
    ->setTitle('El juez abre una pieza separada por las cintas de Corinna y llama a declarar a Villarejo')
    ->setBody('El excomisario será interrogado en la Audiencia Nacional el jueves, el mismo día que el director del CNI hablará en el Congreso sobre la amiga del rey emérito')
    ->setImageUrl('https://ep01.epimg.net/politica/imagenes/2018/07/20/actualidad/1532078588_521831_1532078733_noticia_normal_recorte1.jpg')
    ->setMainTopics(['IOS'])
    ->setUrl('https://elpais.com/politica/2018/07/20/actualidad/1532078588_521831.html')
    ->setTopics(['politic', 'spain'])
    ->send();
