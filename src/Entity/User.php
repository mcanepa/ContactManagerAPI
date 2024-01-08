<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use App\State\UserPasswordHasher;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
	operations: [
		new Delete(),
		new Get(),
		new GetCollection(),
		new Patch(processor: UserPasswordHasher::class),
		new Post(processor: UserPasswordHasher::class, validationContext: ["groups" => ["Default", "user:create"]]),
		new Put(processor: UserPasswordHasher::class),
	],
	normalizationContext: ["groups" => ["user:read"]],
	denormalizationContext: ["groups" => ["user:create", "user:update"]],
)]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column]
	#[Groups(["user:read"])]
	private ?int $id = null;

	#[ORM\Column(length: 50, unique: true)]
	#[Assert\NotBlank]
	#[Groups(["user:read", "user:create", "user:update"])]
	private ?string $user = null;

	#[ORM\Column(length: 100, unique: true)]
	#[Assert\NotBlank]
	#[Assert\Email]
	#[Groups(["user:read", "user:create", "user:update"])]
	private ?string $email = null;

	#[ORM\Column]
	private ?string $password = null;

	#[Assert\NotBlank(groups: ["user:create"])]
	#[Groups(["user:create", "user:update"])]
	private ?string $plainPassword = null;

	#[ORM\Column(length: 50)]
	#[Groups(["user:read", "user:create", "user:update"])]
	private ?string $fullName = null;

	#[ORM\Column(type: "json")]
	#[Groups(["user:read", "user:create", "user:update"])]
	private array $roles = [];

	#[ORM\Column(type: Types::BOOLEAN)]
	#[Groups(["user:read", "user:create", "user:update"])]
	private ?bool $active = false;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	#[Gedmo\Timestampable(on: "create")]
	#[Groups(["user:read"])]
	private $createdAt;

	#[ORM\Column(type: Types::DATETIME_MUTABLE)]
	#[Gedmo\Timestampable(on: "update")]
	#[Groups(["user:read"])]
	private $updatedAt;

	public function getId(): ?int
	{
		return $this->id;
	}

	public function getUser(): ?string
	{
		return $this->user;
	}

	public function setUser(string $user): self
	{
		$this->user = $user;

		return $this;
	}

	public function getEmail(): ?string
	{
		return $this->email;
	}

	public function setEmail(string $email): self
	{
		$this->email = $email;

		return $this;
	}

	public function getPassword(): string
	{
		return $this->password;
	}

	public function setPassword(string $password): self
	{
		$this->password = $password;

		return $this;
	}

	public function getPlainPassword(): ?string
	{
		return $this->plainPassword;
	}

	public function setPlainPassword(?string $plainPassword): self
	{
		$this->plainPassword = $plainPassword;

		return $this;
	}

	public function getFullName(): ?string
	{
		return $this->fullName;
	}

	public function setFullName(string $fullName): self
	{
		$this->fullName = $fullName;

		return $this;
	}

	public function getRoles(): array
	{
		$roles = $this->roles;

		// guarantee every user at least has ROLE_USER
		$roles[] = "ROLE_USER";

		return array_unique($roles);
	}

	public function setRoles(array $roles): static
	{
		$this->roles = $roles;

		return $this;
	}

	public function isActive()
	{
		return $this->active;
	}

	public function setActive($active)
	{
		$this->active = $active;

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

	public function getUserIdentifier(): string
	{
		return (string) $this->user;
	}

	public function getSalt(): ?string
	{
		return null;
	}

	public function eraseCredentials(): void
	{
		// If you store any temporary, sensitive data on the user, clear it here
		// $this->plainPassword = null;
	}
}
