<?php


namespace Notification\Firebase;

/**
 * Notification Firebase for Android
 * @author Jonathan Díaz <jgdiazcherrez@gmail.com>
 */
class Android extends CommonApp
{

	/**
	 * Retrieve message with conditions
	 */
	protected function _retrieveMessage():array
	{
		return ($this->_messageData) ? $this->_messageData : [
			'priority' => 'high',
			"content_available" => true,
			"data" => [
				'provider' => 'firebase',
				'deepLinking' => $this->getUrl(),
				'image' => $this->getImageUrl(),
				'title' => $this->getTitle(),
				'body' => $this->getBody()
			],
			"condition" => ''
		];
	}

}
