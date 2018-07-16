<?php


namespace Notification;

/**
 * Define la acción del ejecutador de notificaciones.
 * @author Jonathan Diaz
 */
interface ExecutorApp
{
	public function send(): bool;
}