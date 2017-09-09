<?php

namespace UM\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use UM\Main;

class PlayerChat implements Listener
{
    
    public function onPlayerChat(PlayerChatEvent $event)
    {
        $player = $event->getPlayer();
        if(Main::getInstance()->getProfile($player->getName())->isMute())
        {
            $player->sendMessage("§cYou are mute");
            $event->setCancelled(true);
        }
    }
}