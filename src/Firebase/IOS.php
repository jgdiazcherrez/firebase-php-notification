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
			'priority' => $this->getPriority(),
			"content_available" => $this->getContentAvailable(),
			"data" => [
				"deepLinking" => $this->getUrl(),
				'imgUrl' => $this->getImageUrl()
			],
			"notification" => [
				"title" => $this->getTitle(),
				"body" => $this->getBody(),
				"badge" => $this->getBadge()
			],
			"condition" => ''
		];
	}

}
