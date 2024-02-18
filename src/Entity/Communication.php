<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
	normalizationContext: ["groups" => ["communication", "communication_read"]],
	denormalizationContext: ["groups" => ["communication", "communication_write"]]
)]
#[ORM\Entity]
class Communication
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	#[Groups(["communication"])]
	private ?int $id = null;

	#[ORM\ManyToOne(targetEntity: Campaign::class, inversedBy: "communications")]
	#[Groups(["communication"])]
	private $campaign;

	#[ORM\ManyToOne(targetEntity: Segment::class, inversedBy: "communications")]
	#[Groups(["communication"])]
	private $segment;

	#[ORM\Column]
	#[Assert\NotBlank]
	#[Groups(["communication"])]
	private string $name = "";

	#[ORM\Column]
	#[Assert\NotBlank]
	#[Groups(["communication"])]
	private string $sender = "";

	#[ORM\Column]
	#[Assert\NotBlank]
	#[Groups(["communication"])]
	private string $subject = "";

	#[ORM\Column(type: Types::TEXT)]
	#[Assert\NotBlank]
	#[Groups(["communication"])]
	private string $message = "";

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getCampaign()
	{
		return $this->campaign;
	}

	public function setCampaign($campaign)
	{
		$this->campaign = $campaign;

		return $this;
	}

	public function getSegment()
	{
		return $this->segment;
	}

	public function setSegment($segment)
	{
		$this->segment = $segment;

		return $this;
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

	public function getSender()
	{
		return $this->sender;
	}

	public function setSender($sender)
	{
		$this->sender = $sender;

		return $this;
	}

	public function getSubject()
	{
		return $this->subject;
	}

	public function setSubject($subject)
	{
		$this->subject = $subject;

		return $this;
	}

	public function getMessage()
	{
		return $this->message;
	}

	public function setMessage($message)
	{
		$this->message = $message;

		return $this;
	}
}
