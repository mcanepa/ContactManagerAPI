<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
	normalizationContext: ["groups" => ["territory", "territory_read"], "enable_max_depth" => true],
	denormalizationContext: ["groups" => ["territory", "territory_write"]],
)]
#[Get(normalizationContext: ["groups" => ["territory", "territory_item"], "enable_max_depth" => true])]
#[GetCollection]
#[ORM\Entity]
class Territory
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	#[Groups(["territory", "contact"])]
	private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Territory::class, inversedBy: "children", fetch: "EXTRA_LAZY")]
	#[Groups(["contact"])]
	private $parent;

	#[ORM\OneToMany(targetEntity: Territory::class, mappedBy: "parent", fetch: "EXTRA_LAZY")]
	#[MaxDepth(1)]
	#[Groups(["territory_item"])]
	private $children;

	#[ORM\OneToMany(targetEntity: Address::class, mappedBy: "territory")]
	private $address;

	#[ORM\Column]
	#[Assert\NotBlank()]
	#[Groups(["territory", "contact"])]
	private $name;

	#[ORM\Column(columnDefinition: "enum('country', 'state', 'department', 'city')")]
	#[Assert\Choice(["country", "state", "department", "city"])]
	#[Groups(["territory"])]
	private $type;

	#[ORM\Column(type: Types::BIGINT)]
	#[Assert\GreaterThan(0)]
	private $externalReference;

	public function __construct()
	{
		$this->children = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getParent()
	{
		return $this->parent;
	}

	public function getParents($parents = []): array
	{
		if(!is_null($this->getParent()))
		{
			$parent = $this->getParent();

			$parents[] = $parent;

			return $parent->getParents($parents);
		}

		return $parents;
	}

	public function setParent(Territory $parent = null)
	{
		$this->parent = $parent;

		return $this;
	}

	public function getChildren()
	{
		return $this->children;
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

	public function getType()
	{
		return $this->type;
	}

	public function setType($type)
	{
		$this->type = $type;

		return $this;
	}
}
