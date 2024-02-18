<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[ORM\Entity]
class Segment
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	#[Groups(["communication_read"])]
	private ?int $id = null;

	#[ORM\OneToMany(targetEntity: Communication::class, mappedBy: "segment")]
	private $communications;

	#[ORM\Column]
	#[Assert\NotBlank]
	#[Groups(["communication_read"])]
	private string $name = "";

	#[ORM\Column(type: Types::JSON)]
	#[Assert\NotBlank]
	private string $filter = "";

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	public function getFilter()
	{
		return $this->filter;
	}

	public function setFilter($filter)
	{
		$this->filter = $filter;

		return $this;
	}
}
