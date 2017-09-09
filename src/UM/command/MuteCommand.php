<?php

namespace UM\command;

use pocketmine\command\{Command, CommandSender};
use pocketmine\event\TranslationContainer;
use UM\Main;

class MuteCommand extends Command
{
  
    public function __construct()
    {
        parent::__construct("mute", "Mutes a specified player", "§cUsage: /mute <player> <day(s)> <(hour(s)> <minute(s)>", ["silence"]);
        $this->setPermission("um.command.mute");
    }
  
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    { 
        if(!$this->testPermission($sender)) return false;

        if(count($args) !== 4)
        {
            $sender->sendMessage($this->getUsage());
            return false;
        }

        if(($player = $sender->getServer()->getPlayer($args[0])) === null)
        {
            $sender->sendMessage(new TranslationContainer("commands.generic.player.notFound"));
            return false;
        }

        $profile = Main::getInstance()->getProfile($player->getName());
        if($profile->isMute())
        {
            $sender->sendMessage("§c".$player->getName()." is already mute");
            return false;               
        }

        $h = intval($args[2]);
        $min = intval($args[3]);
        if(($d = intval($args[1])) === 0 && $h === 0 && $min === 0)
        {
            $sender->sendMessage("§cYou cannot put on mute ".$player->getName()." for 0 day, 0 hour and 0 minute");
            return false;           
        }
        $profile->setMute(($d * 86400) + ($h * 3600) + ($min * 60) + time());
        $sender->sendMessage("§7You have put on mute ".$player->getName()." for ".$d."d ".$h."h ".$min."min");
        $player->sendMessage("§cYou have been put on mute by ".$sender->getName()." for ".$d."d ".$h."h ".$min."min");
        return true;
    }
}
