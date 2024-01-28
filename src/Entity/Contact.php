<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
	normalizationContext: ["groups" => ["contact", "contact_read"]],
	denormalizationContext: ["groups" => ["contact", "contact_write"]]
)]
#[ORM\Entity]
#[ORM\UniqueConstraint(columns: ["id_number"])]
class Contact
{
	#[ORM\Id]
	#[ORM\Column]
	#[ORM\GeneratedValue]
	#[Groups(["contact"])]
	private ?int $id = null;

	#[ORM\Column(type: Types::INTEGER)]
	#[Assert\NotBlank]
	#[Assert\GreaterThan(0)]
	#[Groups(["contact"])]
	private $idNumber;

	#[ORM\Column]
	#[Assert\NotBlank]
	#[Groups(["contact"])]
	private string $firstName = "";

	#[ORM\Column]
	#[Assert\NotBlank]
	#[Groups(["contact"])]
	private string $lastName = "";

	#[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
	#[Assert\Type("DateTimeInterface")]
	#[Groups(["contact"])]
	private $birthDate = null;

	#[ORM\Column(type: Types::JSON, nullable: true)]
	private $territory;

	#[ORM\OneToMany(targetEntity: Address::class, mappedBy: "contact", cascade: ["all"], orphanRemoval: true)]
	#[Assert\Valid]
	#[Groups(["contact"])]
	private $addresses;

	#[ORM\OneToMany(targetEntity: Email::class, mappedBy: "contact", cascade: ["all"], orphanRemoval: true)]
	#[Assert\Valid]
	#[Groups(["contact"])]
	private $emails;

	#[ORM\OneToMany(targetEntity: Phone::class, mappedBy: "contact", cascade: ["all"], orphanRemoval: true)]
	#[Assert\Valid]
	#[Groups(["contact"])]
	private $phones;

	#[ORM\ManyToMany(targetEntity: Source::class, inversedBy: "contacts")]
	#[Groups(["contact"])]
	private $sources;

	#[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: "contacts")]
	#[Groups(["contact"])]
	private $tags;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	#[Gedmo\Timestampable(on: "create")]
	#[Groups(["contact"])]
	private $createdAt;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	#[Gedmo\Timestampable(on: "update")]
	#[Groups(["contact"])]
	private $updatedAt;

	public function __construct()
	{
		$this->addresses = new ArrayCollection();
		$this->emails = new ArrayCollection();
		$this->phones = new ArrayCollection();
		$this->sources = new ArrayCollection();
		$this->tags = new ArrayCollection();
	}

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getIdNumber()
	{
		return $this->idNumber;
	}

	public function setIdNumber($idNumber)
	{
		$this->idNumber = $idNumber;

		return $this;
	}

	public function getFirstName()
	{
		return $this->firstName;
	}

	public function setFirstName($firstName)
	{
		$this->firstName = $firstName;

		return $this;
	}

	public function getLastName()
	{
		return $this->lastName;
	}

	public function setLastName($lastName)
	{
		$this->lastName = $lastName;

		return $this;
	}

	public function getBirthDate()
	{
		return $this->birthDate;
	}

	public function setBirthDate($birthDate)
	{
		$this->birthDate = $birthDate;

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

	public function getAddresses()
	{
		return $this->addresses;
	}

	public function addAddress(Address $address): void
	{
		$address->setContact($this);

		$this->addresses->add($address);
	}

	public function removeAddress(Address $address): void
	{
		$address->setContact(null);

		$this->addresses->removeElement($address);
	}

	public function getEmails()
	{
		return $this->emails;
	}

	public function addEmail(Email $email): void
	{
		$email->setContact($this);

		$this->emails->add($email);
	}

	public function removeEmail(Email $email): void
	{
		$email->setContact(null);

		$this->emails->removeElement($email);
	}

	public function getPhones()
	{
		return $this->phones;
	}

	public function addPhone(Phone $phone): void
	{
		$phone->setContact($this);

		$this->phones->add($phone);
	}

	public function removePhone(Phone $phone): void
	{
		$phone->setContact(null);

		$this->phones->removeElement($phone);
	}

	public function getSources()
	{
		return $this->sources;
	}

	public function setSources($sources)
	{
		$this->sources = $sources;

		return $this;
	}

	public function getTags()
	{
		return $this->tags;
	}

	public function setTags($tags)
	{
		$this->tags = $tags;

		return $this;
	}

	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	public function getUpdatedAt()
	{
		return $this->updatedAt;
	}
}
