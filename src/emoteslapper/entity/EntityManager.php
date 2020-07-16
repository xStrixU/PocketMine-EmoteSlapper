<?php

declare(strict_types=1);

namespace emoteslapper\entity;

use pocketmine\entity\Entity;

class EntityManager {
	
	public static function init() : void {
		Entity::registerEntity(EmoteHuman::class, true, ["EmoteHuman"]);
	}
}