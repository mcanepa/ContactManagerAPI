<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class ContactsTest extends ApiTestCase
{
	public function testCreateContact()
	{
		static::createClient()->request("POST", "/contacts", [
			"json" => [
				"firstName" => "John",
				"lastName" => "Doe",
				"idNumber" => time(),
			],
			"headers" => [
				"Content-Type" => "application/ld+json",
			],
		]);

		$this->assertResponseStatusCodeSame(201);
		$this->assertJsonContains([
			"@context" => "/contexts/Contact",
			"@type" => "Contact",
			"firstName" => "John",
		]);
	}

	public function testUpdateContact()
	{
		static::createClient()->request("PUT", "/contacts/1", [
			"json" => [
				"@id" => "/contacts/1",
				"idNumber" => 123456789,
			],
			"headers" => [
				"Content-Type" => "application/ld+json",
			],
		]);

		$this->assertResponseStatusCodeSame(200);
	}

	public function testgetContacts()
	{
		static::createClient()->request("GET", "/contacts");

		$this->assertResponseStatusCodeSame(200);
	}
}
