<?php

declare(strict_types=1);

namespace emoteslapper\manager;

class EmoteManager {
	
	private static $emoteIds = [
	 "wave" => "4c8ae710-df2e-47cd-814d-cc7bf21a3d67",
	 "simple_clap" => "9a469a61-c83b-4ba9-b507-bdbe64430582",
	 "over_there" => "ce5c0300-7f03-455d-aaf1-352e4927b54d",
	 "diamonds_to_you" => "86b34976-8f41-475b-a386-385080dc6e83",
	 "the_pickaxe" => "d7519b5a-45ec-4d27-997c-89d402c6b57f",
	 "over_here" => "71721c51-b7d1-46b1-b7ea-eb4c4126c3db",
	 "breakdance" => "1dbaa006-0ec6-42c3-9440-a3bfa0c6fdbe",
	 "chatting" => "59d9e78c-f0bb-4f14-9e9b-7ab4f58ffbf5",
	 "the_hammer" => "7cec98d8-55cc-44fe-b0ae-2672b0b2bd37",
	 "golf_clap" => "434489fd-ed42-4814-961a-df14161d67e0",
	 "disappointed" => "a98ea25e-4e6a-477f-8fc2-9e8a18ab7004",
	 "victory_cheer" => "d0c60245-538e-4ea2-bdd4-33477db5aa89",
	 "foot_stomp" => "13334afa-bd66-4285-b3d9-d974046db479",
	 "the_woodpunch" => "42fde774-37d4-4422-b374-89ff13a6535a",
	 "sad_sigh" => "98a68056-e025-4c0f-a959-d6e330ccb5f5",
	 "the_elytra" => "7393aa53-9145-4e66-b23b-ec86def6c6f2",
	 "giddy" => "738497ce-539f-4e06-9a03-dc528506a468",
	 "hooray" => "c4b5b251-24d3-43eb-9c05-46be246aeefb"
	];
	
	public static function getEmoteId(string $emote) : ?string {
		return self::$emoteIds[$emote] ?? null;
	}
	
	public static function getEmotes() : array {
		$emotes = [];
		
		foreach(self::$emoteIds as $name => $id) {
			$emotes[] = $name;
		}
		
		return $emotes;
	}
}