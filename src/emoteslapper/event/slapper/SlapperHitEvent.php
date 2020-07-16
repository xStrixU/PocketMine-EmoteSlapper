<?php

declare(strict_types=1);

namespace emoteslapper\event\slapper;

use pocketmine\event\Cancellable;
use emoteslapper\entity\Slapper;
use pocketmine\entity\Entity;

class SlapperHitEvent extends SlapperEvent implements Cancellable {
	
	private $damager;

	public function __construct(Slapper $slapper, ?Entity $damager) {
		$this->slapper = $slapper;
		$this->damager = $damager;
	}
	
	public function getDamager() : ?Entity {
		return $this->damager;
	}
}