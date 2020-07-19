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
			$action = false;
			
			if(isset(EmoteHumanManager::$customName[$nick])) {
				$customName = EmoteHumanManager::$customName[$nick];
				unset(EmoteHumanManager::$customName[$nick]);
				
				$slapper->setCustomName($customName);
				$damager->sendMessage(Main::PREFIX." §7Set customName successfully!");
				$action = true;
			}
			
			if(isset(EmoteHumanManager::$emote[$nick])) {
				$emote = EmoteHumanManager::$emote[$nick];
				unset(EmoteHumanManager::$emote[$nick]);
				
				$slapper->setEmote($emote);
				$damager->sendMessage(Main::PREFIX." §7Set emote successfully!");
				$action = true;
			}
			
			if(isset(EmoteHumanManager::$emoteCooldown[$nick])) {
				$emoteCooldown = EmoteHumanManager::$emoteCooldown[$nick];
				unset(EmoteHumanManager::$emoteCooldown[$nick]);
				
				$slapper->setEmoteCooldown($emoteCooldown);
				$damager->sendMessage(Main::PREFIX." §7Set emote cooldown successfully!");
				$action = true;
			}
			
			if(isset(EmoteHumanManager::$setInventory[$nick])) {
				unset(EmoteHumanManager::$setInventory[$nick]);
				
				$slapper->getInventory()->setItemInHand($damager->getInventory()->getItemInHand());
		$slapper->getArmorInventory()->setContents($damager->getArmorInventory()->getContents());
		$slapper->getInventory()->sendHeldItem($damager->getServer()->getOnlinePlayers());
		
				$damager->sendMessage(Main::PREFIX." §7Set slapper inventory successfully!");
				$action = true;
			}
			
			if(isset(EmoteHumanManager::$addCommand[$nick])) {
				$command = EmoteHumanManager::$addCommand[$nick];
				unset(EmoteHumanManager::$addCommand[$nick]);
				
				if(!$slapper->addCommand($command))
				 $damager->sendMessage(Main::PREFIX." §7This command already exists!");
				else
				$damager->sendMessage(Main::PREFIX." §7Added command successfully!");
				$action = true;
			}
			
			if(isset(EmoteHumanManager::$removeCommand[$nick])) {
				$command = EmoteHumanManager::$removeCommand[$nick];
				unset(EmoteHumanManager::$removeCommand[$nick]);
				
				if($command === "*") {
					$slapper->removeCommands();
					$damager->sendMessage(Main::PREFIX." §7Removed all commands successfully!");
				} else {
			 	if(!$slapper->removeCommand($command))
			 	 $damager->sendMessage(Main::PREFIX." §7This command does not exists!");
				 else
				  $damager->sendMessage(Main::PREFIX." §7Removed command successfully!");
				}
				$action = true;
			}
			
			if(isset(EmoteHumanManager::$commands[$nick])) {
				unset(EmoteHumanManager::$commands[$nick]);
				
				$commands = $slapper->getCommands();
				
				if(empty($commands))
				 $damager->sendMessage(Main::PREFIX." §7This slapper has no commands!");
				else
				 $damager->sendMessage(Main::PREFIX." §7Command list: §6".implode("§7, §6", $commands));
				
				$action = true;
			}
			
			if(isset(EmoteHumanManager::$remove[$nick])) {
				unset(EmoteHumanManager::$remove[$nick]);
				
				$slapper->close();
				$damager->sendMessage(Main::PREFIX." §7Removed slapper successfully!");
				$action = true;
			}
			
			if(!$action)
			 $slapper->executeCommands($damager);
		}
	}
}