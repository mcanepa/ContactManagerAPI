<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[ORM\Entity]
class Address
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	#[Groups(["contact"])]
	private ?int $id = null;

	#[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: "addresses", cascade: ["persist"])]
	#[ORM\JoinColumn(nullable: false)]
	private $contact;

	#[ORM\Column]
	#[Assert\NotBlank()]
	#[Groups(["contact"])]
	private $street;

	#[ORM\Column]
	#[Assert\NotBlank()]
	#[Assert\Positive()]
	#[Groups(["contact"])]
	private $doorNumber;

	#[ORM\Column(type: Types::STRING, length: 5, nullable: true)]
	#[Assert\Length(min: 0, max: 5)]
	#[Groups(["contact"])]
	private $apartment;

	#[ORM\ManyToOne(targetEntity: Territory::class, inversedBy: "address")]
	#[ORM\JoinColumn(nullable:false)]
	#[Groups(["contact"])]
	private $territory;

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

	public function getStreet()
	{
		return $this->street;
	}

	public function setStreet($street)
	{
		$this->street = $street;

		return $this;
	}

	public function getDoorNumber()
	{
		return $this->doorNumber;
	}

	public function setDoorNumber($doorNumber)
	{
		$this->doorNumber = $doorNumber;

		return $this;
	}

	public function getApartment()
	{
		return $this->apartment;
	}

	public function setApartment($apartment)
	{
		$this->apartment = $apartment;

		return $this;
	}

	public function getTerritory()
	{
		return $this->territory;
	}

	public function setTerritory($territory)
	{
		$this->territory = $territory;

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
