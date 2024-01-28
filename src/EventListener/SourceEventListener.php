<?php

namespace App\EventListener;

use App\Entity\Source;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

use App\Helper\HelperFunctions;

#[AsEntityListener(event: Events::prePersist, method: "prePersist", entity: Source::class)]
#[AsEntityListener(event: Events::preUpdate, method: "preUpdate", entity: Source::class)]
class SourceEventListener
{
	public function prePersist(Source $source, PrePersistEventArgs $event): void
	{
		$slug = HelperFunctions::createSlug($source->getName());

		$source->setSlug($slug);
	}

	public function preUpdate(Source $source, PreUpdateEventArgs $event): void
	{
		$slug = HelperFunctions::createSlug($source->getName());

		$source->setSlug($slug);
	}
}
