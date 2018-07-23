<?php

namespace Notification\Firebase;

/**
 * FirebaseNotification for IOS
 * @author Jonathan Díaz <jgdiazcherrez@gmail.com>
 */
class IOS extends CommonApp
{

	/**
	 * Retrieve message with conditions
	 */
	protected function _retrieveMessage() : array
	{
		return [
			'priority' => 'high',
			"content_available" => true,
			"data" => [
				"deepLinking" => $this->getUrl(),
				'imgUrl' => $this->getImageUrl()
			],
			"notification" => [
				"title" => $this->getTitle(),
				"body" => $this->getBody(),
				"badge" => 0
			],
			"condition" => ''
		];
	}

}
