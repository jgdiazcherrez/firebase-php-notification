<?php

namespace Notification;
use Notification\Firebase\Android;
use Notification\Firebase\IOS;
use Notification\Firebase\Dispatcher;

/**
 * Facade Notificator for IOS and Android. This class implements both subsystem
 * @author Jonathan Díaz <jgdiazcherrez@gmail.com>
 */
class Facade
{

	/**
	 * IOS Notificator
	 * @var IOS
	 */
	private $_iosNotificator;

	/**
	 * Android Notificator
	 * @var Android
	 */
	private $_androidNotificator;

    /**
     * Facade constructor.
     * @param Dispatcher $pushMessage
     */
	public function __construct(Dispatcher $pushMessage)
	{
		$this->_androidNotificator = new Android($pushMessage);
		$this->_iosNotificator = new IOS($pushMessage);
	}

	/**
	 * Send Notification
	 * @param string $title
	 * @param string $text
	 * @param string $url
	 * @param string $imgUrl
     * @param array $topics
     * @param array $mainTopics
     * @param array $idsDevices
     * @throws \Notification\Firebase\Exception\AppException
	 */
	public function sendNotification($title, $text, $url, $imgUrl, $topics = [], $mainTopics = [], $idsDevices = [])
	{
        $this->_sendNotificationToIOS(func_get_args());
        $this->_sendNotificationToAndroid(func_get_args());
	}


    /**
     * Send Notification for IOS
     * @param string $title
     * @param string $text
     * @param string $url
     * @param string $imgUrl
     * @param array $topics
     * @throws \Notification\Firebase\Exception\AppException
     */
	protected function _sendNotificationToIOS($title, $text, $url, $imgUrl, $topics, $mainTopics, $idsDevices)
    {
        $this->_iosNotificator
            ->setTitle($title)
            ->setBody($text)
            ->setUrl($url)
            ->setMainTopics($mainTopics)
            ->setImageUrl($imgUrl)
            ->setTopics($topics)
            ->setRegistrationIds($idsDevices)
            ->send();
    }

	/**
	 * Send Notification for Android
	 * @param string $title
	 * @param string $text
	 * @param string $url
	 * @param string $imgUrl
	 * @param array $topics
     * @param array $mainTopics
     * @throws \Notification\Firebase\Exception\AppException
	 */
	protected function _sendNotificationToAndroid($title, $text, $url, $imgUrl, $topics, $mainTopics, $idsDevices)
	{
        $this->_androidNotificator
                ->setTitle($title)
                ->setBody($text)
                ->setUrl($url)
                ->setMainTopics($mainTopics)
                ->setImageUrl($imgUrl)
                ->setTopics($topics)
                ->setRegistrationIds($idsDevices)
                ->send();
	}

}
