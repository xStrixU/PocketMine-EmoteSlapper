<?php

declare(strict_types=1);

namespace emoteslapper\event\slapper;

use pocketmine\event\Event;
use emoteslapper\entity\Slapper;

abstract class SlapperEvent extends Event {
	
	protected $slapper;

	public function getSlapper() : Slapper {
		return $this->slapper;
	}
}