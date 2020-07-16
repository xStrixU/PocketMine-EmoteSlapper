<?php

declare(strict_types=1);

namespace emoteslapper\listener;

use emoteslapper\Main;
use emoteslapper\listener\entity\EntityDamageListener;
use emoteslapper\listener\slapper\SlapperHitListener;

class ListenerManager {
	
	public static function init(Main $main) : void {
		$listeners = [
		 new EntityDamageListener(),
		 new SlapperHitListener()
		];
		
		foreach($listeners as $listener)
		 $main->getServer()->getPluginManager()->registerEvents($listener, $main);
	}
}