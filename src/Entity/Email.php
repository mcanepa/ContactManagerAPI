<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[ORM\Entity]
#[UniqueEntity(fields: ["address"])]
#[ORM\UniqueConstraint(columns: ["address"])]
class Email
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	#[Groups(["contact"])]
	private ?int $id = null;

	#[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: "emails", cascade: ["persist"])]
	#[ORM\JoinColumn(nullable:false)]
	public $contact;

	#[ORM\Column]
	#[Assert\NotBlank()]
	#[Assert\Email()]
	#[Groups(["contact"])]
	private $address;

	#[ORM\Column(type: Types::BOOLEAN)]
	#[Assert\Type(type: "bool")]
	#[Groups(["contact"])]
	private $optIn = false;

	#[ORM\Column(type: Types::BOOLEAN)]
	#[Assert\Type(type: "bool")]
	#[Groups(["contact"])]
	private $subscribed = false;

	#[ORM\Column(type: Types::BOOLEAN)]
	#[Assert\Type(type: "bool")]
	#[Groups(["contact"])]
	private $isPrimary = false;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getContact()
	{
		return $this->contact;
	}

	public function setContact(?Contact $contact)
	{
		$this->contact = $contact;

		return $this;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function setAddress($address)
	{
		$this->address = $address;

		return $this;
	}

	public function isOptIn()
	{
		return $this->optIn;
	}

	public function setOptIn($optIn)
	{
		$this->optIn = $optIn;

		return $this;
	}

	public function isSubscribed()
	{
		return $this->subscribed;
	}

	public function setSubscribed($subscribed)
	{
		$this->subscribed = $subscribed;

		return $this;
	}

	public function getIsPrimary()
	{
		return $this->isPrimary;
	}

	public function setIsPrimary($isPrimary)
	{
		$this->isPrimary = $isPrimary;

		return $this;
	}
}
