<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
	normalizationContext: ["groups" => ["campaign", "campaign_read"]],
	denormalizationContext: ["groups" => ["campaign", "campaign_write"]]
)]
#[ORM\Entity]
class Campaign
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	#[Groups(["campaign", "communication_read"])]
	private ?int $id = null;

	#[ORM\OneToMany(targetEntity: Communication::class, mappedBy: "campaign")]
	private $communications;

	#[ORM\Column]
	#[Assert\NotBlank]
	#[Groups(["campaign", "communication_read"])]
	private string $name = "";

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getCommunications()
	{
		return $this->communications;
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
}
