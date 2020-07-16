<?php

declare(strict_types=1);

namespace emoteslapper\command;

use pocketmine\Server;

class CommandManager {
	
	public static function init() : void {
		Server::getInstance()->getCommandMap()->register("emoteslapper", new EmoteSlapperCommand());
	}
}