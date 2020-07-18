<?php

declare(strict_types=1);

namespace emoteslapper\entity;

use pocketmine\entity\Human;
use pocketmine\network\mcpe\protocol\EmotePacket;
use emoteslapper\manager\EmoteManager;
use pocketmine\Server;
class EmoteHuman extends Human implements Slapper {
	
	private $lastEmote = 0;
	
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
	
	public function entityBaseTick(int $diff = 1) : bool {
		$lastEmote = microtime(true) - $this->lastEmote;
		
		if($lastEmote >= $this->getEmoteCooldown()) {
		 $pk = EmotePacket::create($this->getId(), EmoteManager::getEmoteId($this->getEmote()), 0);
		 
		 foreach($this->getLevel()->getPlayers() as $player) {
			 $player->dataPacket($pk);
			}
			
			$this->lastEmote = microtime(true);
		}
		
		return parent::entityBaseTick($diff);
	}
}