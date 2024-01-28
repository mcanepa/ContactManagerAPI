<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
	normalizationContext: ["groups" => ["source", "source_read"]],
	denormalizationContext: ["groups" => ["source", "source_write"]]
)]
#[ORM\Entity]
class Source
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	#[Groups(["source", "contact"])]
	private ?int $id = null;

	#[ORM\ManyToMany(targetEntity: Contact::class, mappedBy: "sources")]
	private $contacts;

	#[ORM\Column(unique: true)]
	private $slug;

	#[ORM\Column]
	#[Assert\NotBlank()]
	#[Groups(["source", "contact"])]
	private $name;

	public function __construct()
	{
		$this->contacts = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getContacts()
	{
		return $this->contacts;
	}

	public function setContacts(Array $contacts)
	{
		$this->contacts = $contacts;

		return $this;
	}

	public function getSlug()
	{
		return $this->slug;
	}

	public function setSlug($slug)
	{
		$this->slug = $slug;

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
}
