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
	public static $setInventory = [];
	public static $remove = [];
	public static $addCommand = [];
	public static $removeCommand = [];
	public static $commands = [];
	public static $addCustomName = [];
	public static $removeCustomName = [];
	public static $customNames = [];
	
	public static function spawn(Player $player, string $customName, string $emote, float $emoteCooldown) : void {
		$nbt = Entity::createBaseNBT($player->asVector3(), null, $player->getYaw(), $player->getPitch());
		
		$nbt->setString("CustomName", $customName);
		$nbt->setString("Emote", $emote);
		$nbt->setFloat("EmoteCooldown", $emoteCooldown);
		
		$player->saveNBT();
		$skin = $player->namedtag->getCompoundTag("Skin");
		$nbt->setTag($skin);
		
		$entity = Entity::createEntity("EmoteHuman", $player->getLevel(), $nbt);
		
		$entity->getInventory()->setItemInHand($player->getInventory()->getItemInHand());
		$entity->getArmorInventory()->setContents($player->getArmorInventory()->getContents());
		$entity->addCustomName($customName);
		
		$entity->spawnToAll();
	}
}