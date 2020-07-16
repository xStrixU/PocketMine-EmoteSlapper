<?php

declare(strict_types=1);

namespace emoteslapper\entity;

use pocketmine\entity\Human;
use pocketmine\network\mcpe\protocol\EmotePacket;
use emoteslapper\manager\EmoteManager;

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
	
	public function getEmoteCooldown() : int {
		return $this->namedtag->getInt("EmoteCooldown");
	}
	
	public function setEmoteCooldown(int $emoteCooldown) : void {
		$this->namedtag->setInt("EmoteCooldown", $emoteCooldown);
	}
	
	public function entityBaseTick(int $diff = 1) : bool {
		$lastEmote = time() - $this->lastEmote;
		
		if($lastEmote >= $this->getEmoteCooldown()) {
		 $pk = EmotePacket::create($this->getId(), EmoteManager::getEmoteId($this->getEmote()), 0);
		 
		 foreach($this->getLevel()->getPlayers() as $player) {
			 $player->dataPacket($pk);
			}
			
			$this->lastEmote = time();
		}
		
		return parent::entityBaseTick($diff);
	}
}