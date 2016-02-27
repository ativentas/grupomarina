<?php

namespace Pedidos\Http\Controllers;


class Message extends Controller
{
	protected $mailer;

	public function __construct($mailer)
	{
		$this->mailer = $mailer;
	}
	public function to($adress)
	{
		$this->mailer->addAdress($adress);
	}

	public function subject($subject)
	{
		$this->mailer->Subject = $subject;
	}
	public function body($body)
	{
		$this->mailer->Body = $body;
	}

}