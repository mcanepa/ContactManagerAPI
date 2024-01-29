<?php
namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

class AuthenticationTest extends ApiTestCase
{
	private $user;

	public function __construct(string $name)
	{
		parent::__construct($name);

		$this->user = "test_" . time();
	}

	public function testCreateUser(): void
	{
		$client = self::createClient();

		$client->request("POST", "/users", [
			"headers" => ["Content-Type" => "application/ld+json"],
			"json" => [
				"user" => $this->user,
				"plainPassword" => "12345",
				"email" => "{$this->user}@gmail.com",
				"fullName" => "Some User",
				"active" => true,
			],
		]);

		$this->assertResponseStatusCodeSame(201);
	}

	public function testLoginSuccess(): void
	{
		$client = self::createClient();

		// retrieve a token
		$response = $client->request("POST", "/login", [
			"headers" => ["Content-Type" => "application/json"],
			"json" => [
				"user" => $this->user,
				"password" => "12345",
			],
		]);

		$json = $response->toArray();

		$this->assertResponseIsSuccessful();
		$this->assertArrayHasKey("token", $json);
	}

	public function testLoginFail(): void
	{
		$client = self::createClient();

		$client->request("POST", "/login", [
			"headers" => ["Content-Type" => "application/json"],
			"json" => [
				"user" => $this->user,
				"password" => "password",
			],
		]);

		$this->assertResponseStatusCodeSame(401);
	}
}
