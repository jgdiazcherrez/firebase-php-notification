<?php

namespace Notification\Firebase;

use Notification\Firebase\Exception\ConditionException;

/**
 * It compose the string condition depending the operator, topics and considering its limitations
 * @author Jonathan Díaz <jgdiazcherrez@gmail.com>
 */
class Condition
{

	/**
	 * OR Operator
	 */
	const OR_CONDITION = '||';

	/**
	 * AND Operator
	 */
	const AND_CONDITION = '&&';

	/**
	 * Limit Topics
	 */
	const LIMIT_TOPICS = 5;

	/**
	 * Topics
	 * @var array
	 */
	private $_topics;

	/**
	 * Operator
	 * @var string
	 */
	private $_operator;

	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->_operator = self::OR_CONDITION;
		$this->_topics = [];
	}

    /**
     * Setter Operator
     * @param $operator
     * @return $this
     * @throws ConditionException
     */
	public function setOperator(string $operator)
	{
		if ($operator != self::OR_CONDITION && $operator != self::AND_CONDITION) {
			throw new ConditionException(ConditionException::OPERATOR_NOT_ALLOWED);
		}
		$this->_operator = $operator;
		return $this;
	}

	/**
	 * Tiene un operador
	 * @return bool
	 */
	public function hasOperator() :bool
	{
		return ((bool) $this->_operator);
	}

	/**
	 * Contiene topics
	 * @return bool
	 */
	public function hasTopics():bool
	{
		return (count($this->_topics) > 0 && count($this->_topics) <= self::LIMIT_TOPICS);
	}

	/**
	 * Add topic, the current limit is 5
	 * @param string $topic
	 * @throws ConditionException
	 */
	public function addTopic($topic)
	{
		if (count($this->_topics) >= self::LIMIT_TOPICS) {
			throw new ConditionException(ConditionException::LIMIT_BY_TOPICS);
		}
		array_push($this->_topics, $topic);
	}

	/**
	 * Return the string condition
	 * @return string
	 */
	public function retrieveTopicCondition()
	{
		$countTopic = count($this->_topics);
		$topics = $this->_topics;
		$condition = '';
		if ($countTopic == 1) {
			return "'$topics[0]' in topics";
		}
		foreach ($this->_topics as $key => $topic) {
			if ($key == 0) {
				$condition = "'$topic' in topics";
			} else {
				$condition .= " $this->_operator '$topic' in topics";
			}
		}
		return $condition;
	}

}
