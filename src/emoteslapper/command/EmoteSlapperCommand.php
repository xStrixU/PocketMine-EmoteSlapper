<?php

declare(strict_types=1);

namespace emoteslapper\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use emoteslapper\entity\EntityManager;
use emoteslapper\manager\EmoteManager;
use emoteslapper\manager\EmoteHumanManager;
use emoteslapper\Main;

class EmoteSlapperCommand extends Command {
	
	public function __construct() {
		parent::__construct("emoteslapper", "Main command of Emote Slapper", null, ["eslapper"]);
		$this->setPermission("emoteslapper.command");
	}
	
	public function execute(CommandSender $sender, string $label, array $args) : void {
		if(!isset($args[0])) {
			$sender->sendMessage(Main::PREFIX." §7Usage:");
			$sender->sendMessage("§8 - §7/emoteslapper §6emotes");
			$sender->sendMessage("§8 - §7/emoteslapper §6spawn §8(§6emote§8) (§6emoteCooldown§8) (§6customName§8)");
			$sender->sendMessage("§8 - §7/emoteslapper §6customname §8(§6customName§8)");
			$sender->sendMessage("§8 - §7/emoteslapper §6emote §8(§6emote§8)");
			$sender->sendMessage("§8 - §7/emoteslapper §6emotecooldown §8(§6emoteCooldown§8)");
			$sender->sendMessage("§8 - §7/emoteslapper §6setinventory");
			$sender->sendMessage("§8 - §7/emoteslapper §6addcommand §8(§6command§8)");
			$sender->sendMessage("§8 - §7/emoteslapper §6removecommand §8(§6command§7/§6*§8)");
			$sender->sendMessage("§8 - §7/emoteslapper §6commands");
			$sender->sendMessage("§8 - §7/emoteslapper §6remove");
			return;
		}
		
		switch($args[0]) {
		 case "emotes":
		 	$sender->sendMessage(Main::PREFIX." §7Available emotes: §6".implode("§7, §6", EmoteManager::getEmotes()));
			 return;
		 break;
		 
		 case "spawn":
		  if(!$sender instanceof Player) {
		  	$sender->sendMessage(Main::PREFIX." You can use it only in game!");
		  	return;
		  }
		  
		  if(!isset($args[3])) {
		  	$sender->sendMessage(Main::PREFIX." §7Usage: /emoteslapper §6spawn §8(§6emote§8) (§6emoteCooldown§8) (§6customName§8)");
		  	return;
		  }
		  
	  	if(EmoteManager::getEmoteId($args[1]) === null) {
			  $sender->sendMessage(Main::PREFIX." §7This emote does not exists!");
			  return;
	  	}
		
		  if(!is_numeric($args[2])) {
		  	$sender->sendMessage(Main::PREFIX." §7Emote cooldown must be numeric!");
		  	return;
	  	}
		
		  $customName = "";
		
		  for($i = 3; $i < count($args); $i++)
		   $customName .= $args[$i]." ";
		
	  	$customName = rtrim($customName);
		
	  	EmoteHumanManager::spawn($sender, $customName, $args[1], (float)$args[2]);
	  	$sender->sendMessage(Main::PREFIX." §7Spawned emote slapper successfully!");
		 break;
		 
		 case "customname":
		  if(!isset($args[1])) {
		  	$sender->sendMessage(Main::PREFIX." §7Usage: /emoteslapper §6customname §8(§6customName§8)");
		  	return;
		  }
		  
		  array_shift($args);
		  $customName = ltrim(implode(" ", $args));
		  
		  EmoteHumanManager::$customName[$sender->getName()] = $customName;
		  
		  $sender->sendMessage(Main::PREFIX." §7Hit the slapper you want to update the customname!");
		 break;
		 
		 case "emote":
		  if(!isset($args[1])) {
		  	$sender->sendMessage(Main::PREFIX." §7Usage: /emoteslapper §6emote §8(§6emote§8)");
		  	return;
		  }
		  
		  if(EmoteManager::getEmoteId($args[1]) === null) {
			  $sender->sendMessage(Main::PREFIX." §7This emote does not exists!");
			  return;
	  	}
		  
		  EmoteHumanManager::$emote[$sender->getName()] = $args[1];
		  
		  $sender->sendMessage(Main::PREFIX." §7Hit the slapper you want to update the emote!");
		 break;
		 
		 case "emotecooldown":
		  if(!isset($args[1])) {
		  	$sender->sendMessage(Main::PREFIX." §7Usage: /emoteslapper §6emotecooldown §8(§6emoteCooldown§8)");
		  	return;
		  }
		  
		  if(!is_numeric($args[1])) {
		  	$sender->sendMessage(Main::PREFIX." §7Emote cooldown must be numeric!");
		  	return;
	  	}
		  
		  EmoteHumanManager::$emoteCooldown[$sender->getName()] = (float)$args[1];
		  
		  $sender->sendMessage(Main::PREFIX." §7Hit the slapper you want to update the emote cooldown!");
		 break;
		 
		 case "setinventory":
		  EmoteHumanManager::$setInventory[$sender->getName()] = true;
		  
		  $sender->sendMessage(Main::PREFIX." §7Hit the slapper you want to set inventory!");
		 break;
		 
		 case "addcommand":
		 case "addcmd":
		 if(!isset($args[1])) {
		 	$sender->sendMessage(Main::PREFIX." §7Usage: /emoteslapper §6addcommand §8(§6command§8)");
		  return;
		 }
		 
		 array_shift($args);
		 $command = ltrim(implode(" ", $args));
		  
		 EmoteHumanManager::$addCommand[$sender->getName()] = $command;
		  
		 $sender->sendMessage(Main::PREFIX." §7Hit the slapper you want to add command!");
		 break;
		 
		 case "removecommand":
		 case "removecmd":
		 if(!isset($args[1])) {
		 	$sender->sendMessage(Main::PREFIX." §7Usage: /emoteslapper §6removecommand §8(§6command§8)");
		  return;
		 }
		 
		 array_shift($args);
		 $command = ltrim(implode(" ", $args));
		  
		 EmoteHumanManager::$removeCommand[$sender->getName()] = $command;
		  
		  if($command === "*")
		   $sender->sendMessage(Main::PREFIX." §7Hit the slapper you want to remove all commands!");
		  else
		   $sender->sendMessage(Main::PREFIX." §7Hit the slapper you want to remove command!");
		 break;
		 
		 case "commands":
		 case "cmds":
		  EmoteHumanManager::$commands[$sender->getName()] = true;
		  
		  $sender->sendMessage(Main::PREFIX." §7Hit the slapper you want to see the command list!");
		 break;
		 
		 case "remove":
		  EmoteHumanManager::$remove[$sender->getName()] = true;
		  
		  $sender->sendMessage(Main::PREFIX." §7Hit the slapper you want to remove!");
		 break;
		 
		 default:
		  $sender->sendMessage(Main::PREFIX." §7Unknown argument!");
		}
	}
}