<?php

declare(strict_types=1);

namespace emoteslapper\listener\slapper;

use pocketmine\event\Listener;
use emoteslapper\event\slapper\SlapperHitEvent;
use pocketmine\Player;
use emoteslapper\manager\EmoteHumanManager;
use emoteslapper\entity\EmoteHuman;
use emoteslapper\Main;

class SlapperHitListener implements Listener {
	
	public function onSlapperHit(SlapperHitEvent $event) : void {
		$event->setCancelled(true);
		
		$slapper = $event->getSlapper();
		$damager = $event->getDamager();
		
		if($damager instanceof Player && $slapper instanceof EmoteHuman) {
			$nick = $damager->getName();
			
			if(isset(EmoteHumanManager::$customName[$nick])) {
				$customName = EmoteHumanManager::$customName[$nick];
				unset(EmoteHumanManager::$customName[$nick]);
				
				$slapper->setCustomName($customName);
				$damager->sendMessage(Main::PREFIX." §7Setted customName successfully!");
			}
			
			if(isset(EmoteHumanManager::$emote[$nick])) {
				$emote = EmoteHumanManager::$emote[$nick];
				unset(EmoteHumanManager::$emote[$nick]);
				
				$slapper->setEmote($emote);
				$damager->sendMessage(Main::PREFIX." §7Setted emote successfully!");
			}
			
			if(isset(EmoteHumanManager::$emoteCooldown[$nick])) {
				$emoteCooldown = EmoteHumanManager::$emoteCooldown[$nick];
				unset(EmoteHumanManager::$emoteCooldown[$nick]);
				
				$slapper->setEmoteCooldown($emoteCooldown);
				$damager->sendMessage(Main::PREFIX." §7Setted emote cooldown successfully!");
			}
			
			if(isset(EmoteHumanManager::$remove[$nick])) {
				unset(EmoteHumanManager::$remove[$nick]);
				
				$slapper->close();
				$damager->sendMessage(Main::PREFIX." §7Removed slapper successfully!");
			}
		}
	}
}