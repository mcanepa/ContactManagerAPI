<?php

namespace App\EventListener;

use App\Entity\Tag;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Events;

use App\Helper\HelperFunctions;

#[AsEntityListener(event: Events::prePersist, method: "prePersist", entity: Tag::class)]
#[AsEntityListener(event: Events::preUpdate, method: "preUpdate", entity: Tag::class)]
class TagEventListener
{
	public function prePersist(Tag $tag, PrePersistEventArgs $event): void
	{
		$slug = HelperFunctions::createSlug($tag->getName());

		$tag->setSlug($slug);
	}

	public function preUpdate(Tag $tag, PreUpdateEventArgs $event): void
	{
		$slug = HelperFunctions::createSlug($tag->getName());

		$tag->setSlug($slug);
	}
}
