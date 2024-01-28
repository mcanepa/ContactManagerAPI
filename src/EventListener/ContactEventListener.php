<?php

namespace App\EventListener;

use App\Entity\Contact;
use App\Entity\Territory;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\preUpdateEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\EntityManagerInterface;

#[AsEntityListener(event: Events::prePersist, method: "prePersist", entity: Contact::class)]
#[AsEntityListener(event: Events::preUpdate, method: "preUpdate", entity: Contact::class)]
class ContactEventListener
{
	private EntityManagerInterface $entityManager;

	public function __construct(EntityManagerInterface $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function prePersist(Contact $contact, PrePersistEventArgs $event): void
	{
		$this->setContactTerritory($contact);
	}

	public function preUpdate(Contact $contact, preUpdateEventArgs $event): void
	{
		$this->setContactTerritory($contact);
	}

	private function setContactTerritory(Contact $contact): void
	{
		$lineage = [];

		$territoryRepository = $this->entityManager->getRepository(Territory::class);

		$territory = $territoryRepository->find(1);

		$addresses = $contact->getAddresses();

		if($addresses->count())
		{
			foreach($addresses as $address)
			{
				if($address->getIsPrimary())
				{
					$territory = $address->getTerritory();
				}
			}
		}

		$parents = $territory->getParents();

		$lineage[] = $territory->getId();

		foreach($parents as $parent)
		{
			$lineage[] = $parent->getId();
		}

		$contact->setTerritory(array_reverse($lineage));
	}
}
