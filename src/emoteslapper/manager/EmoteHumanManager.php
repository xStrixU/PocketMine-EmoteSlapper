<?php

declare(strict_types=1);

namespace emoteslapper\manager;

use pocketmine\Player;
use pocketmine\entity\Entity;
use emoteslapper\entity\EmoteHuman;

class EmoteHumanManager {
	
	public static $customName = [];
	public static $emote = [];
	public static $emoteCooldown = [];
	public static $remove = [];
	
	public static function spawn(Player $player, string $customName, string $emote, int $emoteCooldown) : void {
		$nbt = Entity::createBaseNBT($player->asVector3(), null);
		
		$nbt->setString("CustomName", $customName);
		$nbt->setString("Emote", $emote);
		$nbt->setInt("EmoteCooldown", $emoteCooldown);
		
		$player->saveNBT();
		$skin = $player->namedtag->getCompoundTag("Skin");
		$nbt->setTag($skin);
		
		$entity = Entity::createEntity("EmoteHuman", $player->getLevel(), $nbt);
		
		$entity->getInventory()->setItemInHand($player->getInventory()->getItemInHand());
		
		$entity->spawnToAll();
	}
}