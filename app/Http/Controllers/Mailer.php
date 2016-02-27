<?php

namespace Pedidos\Http\Controllers;


class Mailer extends Controller
{
	protected $mailer;

	public function __construct($mailer)
	{
		$this->mailer = $mailer;
	}

	public function send($template, $callback)
	{
		
		$message = new Message($this->mailer);
		extract($data);

		require $template;

		$message->body($template);

		call_user_func($callback, $message);

		$this->mailer->send();	
	}

}