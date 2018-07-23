<?php


namespace Notification\Firebase;

use Notification\Firebase\Exception\AppException;
use Notification\Executor;

/**
 * Abstract Common App
 * @author Jonathan Díaz <jgdiazcherrez@gmail.com>
 */
abstract class CommonApp implements Executor
{

	/**
	 * Title
	 * @var string
	 */
	protected $_title;

	/**
	 * Body Content
	 * @var string
	 */
	protected $_body;

	/**
	 * Url
	 * @var string
	 */
	protected $_url;

	/**
	 * Image Url
	 * @var string
	 */
	protected $_imageUrl;

	/**
	 * Topics
	 * @var array
	 */
	protected $_topics;

	/**
	 * Main Topics
	 * @var array
	 */
	protected $_mainTopics;

	/**
	 * Firebase Notificator
	 * @var Dispatcher
	 */
	protected $_dispatcher;


    /**
     * Message Data
     * @var array
     */
	protected $_messageData;

    /**
     * Specific Ids
     * @var array
     */
	protected $_registrationIds;

    /**
     * Setter Registration Ids
     * @param array $ids
     * @return $this
     */
	public function setRegistrationIds(array $ids){
	    $this->_registrationIds = $ids;
	    return $this;
    }


    /**
     * Getter Registration Ids
     * @return array
     */
    public function getRegistrationIds()
    {
        return $this->_registrationIds;
    }


    /**
     * Setter Message
     * @param array $message
     * @return $this
     */
	public function setMessage(array $message)
    {
        $this->_messageData = $message;
        return $this;
    }

    /**
     * Getter Message
     * @return array
     */
    public function getMessage()
    {
        return $this->_messageData;
    }

	/**
	 * Add Main Topic
	 * @param  string $topic
	 * @return $this
	 */
	public function addMainTopic(string $topic)
	{
		array_push($this->_mainTopics, $topic);
		return $this;
	}

	/**
	 * Setter Main Topics
	 * @param array $mainTopics
	 * @return $this
	 */
	public function setMainTopics(array $mainTopics)
	{
		$this->_mainTopics = $mainTopics;
		return $this;
	}

	/**
	 * Getter Main Topics
	 * @return array
	 */
	public function getMainTopics() : array
	{
		return $this->_mainTopics;
	}

	/**
	 * Topics
	 * @return array
	 */
	public function getTopics():array
	{
		return $this->_topics;
	}

	/**
	 * Getter Image URL
	 * @return string
	 */
	public function getImageUrl():string
	{
		return $this->_imageUrl;
	}

	/**
	 * Getter URL
	 */
	public function getUrl() : string
    {
		return $this->_url;
	}

	/**
	 * Getter Body
	 * @return string
	 */
	public function getBody()
	{
		return $this->_body;
	}

	/**
	 * Getter Title
	 * @return string
	 */
	public function getTitle()
	{
		return $this->_title;
	}

	/**
	 * Setter Title
	 * @param string $title
	 * @return $this
	 */
	public function setTitle(string $title)
	{
		$this->_title = $title;
		return $this;
	}

	/**
	 * Setter Topics
	 * @param array $topics
	 * @return $this
	 */
	public function setTopics(array $topics)
	{
		$this->_topics = $topics;
		return $this;
	}

	/**
	 * Setter Body
	 * @param string $body
	 * @return $this
	 */
	public function setBody(string $body)
	{
		$this->_body = $body;
		return $this;
	}

	/**
	 * Setter URL
	 * @param string $url
	 * @return $this
	 */
	public function setUrl(string $url)
	{
		$this->_url = $url;
		return $this;
	}

	/**
	 * Setter Image
	 * @param string $imageUrl
	 * @return $this
	 */
	public function setImageUrl(string $imageUrl)
	{
		$this->_imageUrl = $imageUrl;
		return $this;
	}


    /**
     * App constructor.
     * @param Dispatcher $dispatcher
     */
	public function __construct(Dispatcher $dispatcher)
	{
		$this->_dispatcher = $dispatcher;
		$this->_mainTopics = [];
		$this->_topics = [];
	}

    /**
     * Send Ios Notification
     * @return bool
     * @throws \Notification\Firebase\Exception\AppException
     */
    public function send(): bool
    {
        try {
            $this->_assertNotification();
            $this->_sendAllNotifications($this->_retrieveMessage());
            return true;
        } catch (AppException $ex) {
            throw $ex;
        }
        catch (\Exception $ex) {
            throw new AppException(AppException::UNEXPECTED_ERROR . ': ' . $ex->getMessage());
        }
    }


    /**
     * Assert Notification
     * @throws AppException
     */
	protected function _assertNotification()
	{
		if (empty($this->_url)) {
			throw new AppException(AppException::NOT_LINK_ATTACHED);
		}
	}

	/**
	 * Get Limit FirebaseNotification
	 * @return int
	 */
	protected function _getLimit() : int
	{
		return Condition::LIMIT_TOPICS - count($this->getMainTopics());
	}


    /**
     * Chunk message for firebase limitations
     * @param $bulkMessage
     * @throws \Notification\Firebase\Exception\ConditionException
     * @return array
     */
	protected function _chunkMessage($bulkMessage) : array
	{
		$chunksTopics = array_chunk($this->getTopics(), $this->_getLimit());
		$messages = [];
		foreach ($chunksTopics as $topics) {
			$this->setTopics($topics);
            $bulkMessage['condition'] = $this->_retrieveCondition();
			array_push($messages, $bulkMessage);
		}
		return $messages;
	}

    /**
     * Send All notifications
     * @param $bulkMessage
     * @throws AppException
     * @throws \Notification\Firebase\Exception\DispatchException
     * @throws \Notification\Firebase\Exception\JSONException
     */
	protected function _sendAllNotifications($bulkMessage)
	{
		$messages = $this->_chunkMessage($bulkMessage);
		foreach ($messages as $message) {
			$this->_dispatcher->sendNotification($message);
		}
	}

    /**
     * Get the target. It can be a custom message, a topics or a list of device identifier
     */
	protected function _getTarget()
    {
       $fcmMessage = $this->_retrieveMessage();
       if($this->_messageData){
           return $this->_messageData;
       }
       if(count($this->_registrationIds)){
           unset($fcmMessage['condition']);
           $fcmMessage['registration_ids'] = $this->_registrationIds;
       }
       return $fcmMessage;
    }

	/**
	 * Retrieve topic condition with the main condition
     * @throws \Notification\Firebase\Exception\ConditionException
	 * @return string
	 */
	protected function _retrieveCondition() :string
	{
		$mainConditions = $this->_getCondition($this->_mainTopics);
		$conditions = $this->_getCondition($this->_topics, Condition::OR_CONDITION);

		if (empty($conditions)) {
			return trim((sprintf("%s", $mainConditions)));
		}

		return trim((sprintf("%s && ( %s )", $mainConditions, $conditions)));
	}

    /**
     * It uses the firebase condition class to compose the string condition
     * @param $topics
     * @param string $operator
     * @throws \Notification\Firebase\Exception\ConditionException
     * @return string
     */
	protected function _getCondition($topics, $operator = Condition::AND_CONDITION) : string
	{
		$condition = new Condition();
		$condition->setOperator($operator);
		foreach ($topics as $topic) {
			$condition->addTopic($topic);
		}
		return $condition->retrieveTopicCondition();
	}

    /**
     * Retrieve the default or custom message with all params needed
     * @return array
     */
    abstract protected function _retrieveMessage() :array;

}
