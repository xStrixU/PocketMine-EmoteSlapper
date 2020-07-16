<?php

declare(strict_types=1);

namespace emoteslapper\listener\entity;

use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use emoteslapper\entity\Slapper;
use emoteslapper\event\slapper\SlapperHitEvent;

class EntityDamageListener implements Listener {
	
	public function callSlapperHit(EntityDamageEvent $event) : void {
		$entity = $event->getEntity();
		$damager = null;
		
		if($event instanceof EntityDamageByEntityEvent)
	 	$damager = $event->getDamager();
			
		if($entity instanceof Slapper) {
			$ev = new SlapperHitEvent($entity, $damager);
			$ev->call();
				
			$event->setCancelled($ev->isCancelled());
		}
	}
}