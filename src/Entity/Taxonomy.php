<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
	normalizationContext: ["groups" => ["taxonomy", "taxonomy_read"]],
	denormalizationContext: ["groups" => ["taxonomy", "taxonomy_write"]]
)]
#[ORM\Entity]
class Taxonomy
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	#[Groups(["taxonomy", "tag"])]
	private ?int $id = null;

	#[ORM\OneToMany(targetEntity: Tag::class, mappedBy: "taxonomy")]
	#[Groups(["taxonomy"])]
	private $tags;

	#[ORM\Column(unique: true)]
	private $slug;

	#[ORM\Column]
	#[Assert\NotBlank()]
	#[Groups(["taxonomy", "tag_read"])]
	private $name;

	#[ORM\Column]
	#[Assert\NotBlank()]
	#[Groups(["taxonomy", "tag_read", "contact_read"])]
	private $color;

	public function __construct()
	{
		$this->tags = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getTags()
	{
		return $this->tags;
	}

	public function setTags(Array $tags)
	{
		$this->tags = $tags;

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

	public function getColor()
	{
		return $this->color;
	}

	public function setColor($color)
	{
		$this->color = $color;

		return $this;
	}
}
