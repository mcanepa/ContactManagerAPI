<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

class JWTListener
{
	public function onJWTCreated(JWTCreatedEvent $event)
	{
		$user = $event->getUser();

		$payload = $event->getData();

		$payload["name"] = $user->getFullName();
		$payload["email"] = $user->getEmail();

		$event->setData($payload);
	}
}
