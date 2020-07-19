<?php

declare(strict_types=1);

namespace emoteslapper\manager;

use pocketmine\Player;
use pocketmine\entity\Entity;
use emoteslapper\entity\EmoteHuman;
use pocketmine\nbt\tag\CompoundTag;

class EmoteHumanManager {
	
	public static $customName = [];
	public static $emote = [];
	public static $emoteCooldown = [];
	public static $setInventory = [];
	public static $remove = [];
	public static $addCommand = [];
	public static $removeCommand = [];
	public static $commands = [];
	
	public static function spawn(Player $player, string $customName, string $emote, float $emoteCooldown) : void {
		$nbt = Entity::createBaseNBT($player->asVector3(), null, $player->getYaw(), $player->getPitch());
		
		$nbt->setString("CustomName", $customName);
		$nbt->setString("Emote", $emote);
		$nbt->setFloat("EmoteCooldown", $emoteCooldown);
		$nbt->setTag(new CompoundTag("Commands", []));
		
		$player->saveNBT();
		$skin = $player->namedtag->getCompoundTag("Skin");
		$nbt->setTag($skin);
		
		$entity = Entity::createEntity("EmoteHuman", $player->getLevel(), $nbt);
		
		$entity->getInventory()->setItemInHand($player->getInventory()->getItemInHand());
		$entity->getArmorInventory()->setContents($player->getArmorInventory()->getContents());
		
		$entity->spawnToAll();
	}
}