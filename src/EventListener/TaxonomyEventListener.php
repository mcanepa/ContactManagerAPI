<?php

namespace App\EventListener;

use App\Entity\Taxonomy;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

use App\Helper\HelperFunctions;

#[AsEntityListener(event: Events::prePersist, method: "prePersist", entity: Taxonomy::class)]
#[AsEntityListener(event: Events::preUpdate, method: "preUpdate", entity: Taxonomy::class)]
class TaxonomyEventListener
{
	public function prePersist(Taxonomy $taxonomy, PrePersistEventArgs $event): void
	{
		$slug = HelperFunctions::createSlug($taxonomy->getName());

		$taxonomy->setSlug($slug);
	}

	public function preUpdate(Taxonomy $taxonomy, PreUpdateEventArgs $event): void
	{
		$slug = HelperFunctions::createSlug($taxonomy->getName());

		$taxonomy->setSlug($slug);
	}
}
