<?php

namespace Notification\Firebase;

use Notification\Firebase\Exception\AppException;
use Notification\Firebase\Exception\DispatchException;
use Notification\Firebase\Assert\JSON;

/**
 * Dispatcher Notificator for firebase
 * @author Jonathan Díaz <jgdiazcherrez@gmail.com>
 */
class Dispatcher
{

	/**
	 * URL FIREBASE
	 */
	const FIRE_BASE_URL = 'https://fcm.googleapis.com/fcm/send';

	/**
	 * Content Header
	 */
	const HEADER_CONTENT = 'Content-type:application/json';

	/**
	 * Authorization header
	 */
	const HEADER_AUTHORIZATION = 'Authorization: key= ';

	/**
	 * Authorization Key
	 * @var string
	 */
	private $_authorization;

	/**
	 * Setter Authorization
	 * @param string $authorization
	 * @return $this
	 */
	public function setAuthorization($authorization)
	{
		$this->_authorization = $authorization;
		return $this;
	}

    /**
     * Send Notification throught the firebase system
     * @param $message
     * @return string
     * @throws AppException
     * @throws DispatchException
     * @throws DispatchException|\Notification\Firebase\Exception\JSONException
     */
	public function sendNotification($message)
    {
		if (!$this->_authorization) {
			throw new DispatchException(DispatchException::NOT_TOKEN_AUTHORIZATION_INCLUDED);
		}
		$response = $this->_doRequest($this->_retrieveFireBaseMessage($message));
		return $response;
	}

	/**
	 * It does the request to the firebase service
	 * @param string $message
     * @throws AppException|\Exception
	 * @return string
	 */
	protected function _doRequest(string $message)
	{
		try {
			$ch = curl_init(self::FIRE_BASE_URL);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(self::HEADER_CONTENT, self::HEADER_AUTHORIZATION . $this->_authorization));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $message);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 400);
			$result = curl_exec($ch);
			curl_close($ch);
			return $result;
		} catch (AppException $ex) {
			throw $ex;
		}
		catch(\Exception $ex){
            throw new AppException(AppException::UNEXPECTED_ERROR . ': ' . $ex->getMessage());
        }
	}

	/**
	 * Retrieve the firebase message
	 * @param $message
     * @throws DispatchException|\Notification\Firebase\Exception\JSONException
	 * @return array
	 */
	private function _retrieveFireBaseMessage($message)
	{
		$messageDecoded = [];
		$this->_commonType($message, $messageDecoded);
		if (empty($messageDecoded)) {
			throw new DispatchException(DispatchException::UNSUPPORTED_TYPE_MESSAGE);
		}
		return $messageDecoded;
	}


    /**
     * Assert the message
     * @param $message
     * @param $messageDecoded
     * @throws \Notification\Firebase\Exception\JSONException
     */
	private function _commonType($message, &$messageDecoded)
	{
		if (is_string($message)) {
			$messageDecoded = JSON::retrieveAndValidData($message);
		}
		if (is_array($message)) {
			$messageDecoded = json_encode($message);
		}
	}

}
