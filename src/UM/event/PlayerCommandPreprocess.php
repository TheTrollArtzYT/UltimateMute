<?php

namespace UM\event;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use UM\Main;

class PlayerCommandPreprocess implements Listener
{
    
    public function onPlayerCommandPreprocess(PlayerCommandPreprocessEvent $event)
    {
        $player = $event->getPlayer();
        $message = strtolower($event->getMessage());
        if(Main::getInstance()->getProfile($player->getName())->isMute())
        {
            if($message{0} === "/")
            {
                $command = explode(" ", $message);
    		    if($command[0] !== "/register" || $command[0] !== "/login") 
                {
                    $player->sendMessage("§cYou are mute");
                    $event->setCancelled(true);
                }
    	    }
        }
    }
}