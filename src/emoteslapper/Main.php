<?php

declare(strict_types=1);

namespace emoteslapper;

use pocketmine\plugin\PluginBase;
use emoteslapper\command\CommandManager;
use emoteslapper\entity\EntityManager;
use emoteslapper\listener\ListenerManager;

class Main extends PluginBase {
	
	public const PREFIX = "§8(§6EmoteSlapper§8)§r";
	
	public function onEnable() : void {
		CommandManager::init();
		EntityManager::init();
		ListenerManager::init($this);
		
		$this->getLogger()->info("Włączono!");
	}
	
	public function onDisable() : void {
		$this->getLogger()->info("Wyłączono!");
	}
}