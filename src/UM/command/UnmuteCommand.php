<?php

namespace UM\command;

use pocketmine\command\{Command, CommandSender};
use pocketmine\event\TranslationContainer;
use UM\Main;

class UnmuteCommand extends Command
{
  
    public function __construct()
    {
        parent::__construct("unmute", "Un-mutes a specified player", "§cUsage: /unmute <player>");
        $this->setPermission("um.command.unmute");
    }
  
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$this->testPermission($sender)) return false;

        if(count($args) !== 1)
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
        if(!$profile->isMute())
        {
            $sender->sendMessage("§c".$player->getName()." has not been put on mute");
            return false;              
        }

        $profile->setMute(0);
        $sender->sendMessage("§7".$player->getName()." is no longer mute");
        $player->sendMessage("§aYou are no longer mute");
        return true;
    }
}