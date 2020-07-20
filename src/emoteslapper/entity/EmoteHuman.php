<?php

declare(strict_types=1);

namespace emoteslapper\entity;

use pocketmine\entity\Human;
use pocketmine\network\mcpe\protocol\EmotePacket;
use emoteslapper\manager\EmoteManager;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\nbt\tag\CompoundTag;

class EmoteHuman extends Human implements Slapper {
	
	private $lastEmote = 0;
	private $currentCustomName = 0;
	
	public function initEntity() : void {
		parent::initEntity();
		
		$this->setNameTagAlwaysVisible(true);
	}
	
		public function getCustomName() : string {
		return $this->namedtag->getString("CustomName");
	}
	
	public function setCustomName(string $customName) : void {
		$this->namedtag->setString("CustomName", $customName);
		$this->setNameTag($customName);
	}
	
	public function addCustomName(string $customName) : bool {
		$customNames = $this->namedtag->getCompoundTag("CustomNames") ?? new CompoundTag("CustomNames", []);
		
		if($customNames->hasTag($customName))
		 return false;
		
		$customNames->setString($customName, $customName);
		$this->namedtag->setTag($customNames);
		
		return true;
	}
	
	public function removeCustomName(string $customName) : bool {
		$customNames = $this->namedtag->getCompoundTag("CustomNames") ?? new CompoundTag("CustomNames", []);
		
		if(!$customNames->hasTag($customName))
		 return false;
		
		$customNames->removeTag($customName);
		$this->namedtag->setTag($customNames);
		
		return true;
	}
	
	public function getCustomNames() : array {
		$cnames = [];
		$customNames = $this->namedtag->getCompoundTag("CustomNames") ?? new CompoundTag("CustomNames", []);
		
		foreach($customNames as $stringTag)
		 $cnames[] = $stringTag->getValue();
		
		return $cnames;
	}
	
	public function removeCustomNames() : void {
		foreach($this->getCustomNames() as $customName)
		 $this->removeCustomName($customName);
	}
	
	public function getEmote() : string {
		return $this->namedtag->getString("Emote");
	}
	
	public function setEmote(string $emote) : void {
		$this->namedtag->setString("Emote", $emote);
	}
	
	public function getEmoteCooldown() : float {
		return $this->namedtag->getFloat("EmoteCooldown");
	}
	
	public function setEmoteCooldown(float $emoteCooldown) : void {
		$this->namedtag->setFloat("EmoteCooldown", $emoteCooldown);
	}
	
	public function addCommand(string $command) : bool {
		$commands = $this->namedtag->getCompoundTag("Commands") ?? new CompoundTag("Commands", []);
		
		if($commands->hasTag($command))
		 return false;
		
		$commands->setString($command, $command);
		$this->namedtag->setTag($commands);
		
		return true;
	}
	
	public function removeCommand(string $command) : bool {
		$commands = $this->namedtag->getCompoundTag("Commands") ?? new CompoundTag("Commands", []);
		
		if(!$commands->hasTag($command))
		 return false;
		
		$commands->removeTag($command);
		$this->namedtag->setTag($commands);
		
		return true;
	}
	
	public function removeCommands() : void {
		foreach($this->getCommands() as $command)
		 $this->removeCommand($command);
	}
	
	public function getCommands() : array {
		$cmds = [];
		$commands = $this->namedtag->getCompoundTag("Commands") ?? new CompoundTag("Commands", []);
		
		foreach($commands as $stringTag)
		 $cmds[] = $stringTag->getValue();
		
		return $cmds;
	}
	
	public function executeCommands(Player $player) : void {
		foreach($this->getCommands() as $command)
		 $player->getServer()->dispatchCommand(new ConsoleCommandSender(), str_replace("{player}", $player->getName(), $command));
	}
	
	public function entityBaseTick(int $diff = 1) : bool {
		$lastEmote = microtime(true) - $this->lastEmote;
		
		if($lastEmote >= $this->getEmoteCooldown()) {
		 $pk = EmotePacket::create($this->getId(), EmoteManager::getEmoteId($this->getEmote()), 0);
		 
		 foreach($this->getLevel()->getPlayers() as $player) {
			 $player->dataPacket($pk);
			}
			
			$this->lastEmote = microtime(true);
			
			$customNames = $this->getCustomNames();
			
			if(!isset($customNames[$this->currentCustomName])) {
				if($this->currentCustomName === 0) {
					$this->removeCustomNames();
					$this->addCustomName("Default CustomName");
				} else
				 $this->currentCustomName = 0;
			}
			
			$this->setCustomName($customNames[$this->currentCustomName++]);
		}
		
		return parent::entityBaseTick($diff);
	}
}