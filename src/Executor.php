<?php


namespace Notification;

/**
 * Define the action to execute for the notifications
 * @author Jonathan Diaz
 */
interface Executor
{
	public function send(): bool;
}