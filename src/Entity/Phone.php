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
#[UniqueEntity(fields: ["type", "countryCode", "areaCode", "number"])]
#[ORM\UniqueConstraint(columns: ["type", "country_code", "area_code", "number"])]
class Phone
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	private ?int $id = null;

	#[ORM\ManyToOne(targetEntity: Contact::class, inversedBy: "phones", cascade: ["persist"])]
	#[ORM\JoinColumn(nullable:false)]
	private $contact;

	#[ORM\Column(columnDefinition: "enum('landline', 'mobile')")]
	#[Assert\NotBlank]
	#[Assert\Choice(["landline", "mobile"])]
	#[Groups(["contact"])]
	private $type;

	#[ORM\Column(type: Types::INTEGER)]
	#[Assert\NotBlank]
	#[Assert\GreaterThan(0)]
	#[Groups(["contact"])]
	private $countryCode = 54;

	#[ORM\Column(type: Types::INTEGER)]
	#[Assert\NotBlank]
	#[Assert\GreaterThan(0)]
	#[Assert\Range(min: 1, max: 9999)]
	#[Groups(["contact"])]
	private $areaCode;

	#[ORM\Column(type: Types::INTEGER)]
	#[Assert\GreaterThan(0)]
	#[Assert\NotBlank]
	#[Groups(["contact"])]
	private $number;

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

	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;

		return $this;
	}

	public function getCountryCode()
	{
		return $this->countryCode;
	}

	public function setCountryCode($countryCode)
	{
		$this->countryCode = $countryCode;

		return $this;
	}

	public function getAreaCode()
	{
		return $this->areaCode;
	}

	public function setAreaCode($areaCode)
	{
		$this->areaCode = $areaCode;

		return $this;
	}

	public function getNumber()
	{
		return $this->number;
	}

	public function setNumber($number)
	{
		$this->number = $number;

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
