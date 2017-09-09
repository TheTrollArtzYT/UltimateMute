<?php

namespace UM;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use UM\Profile;
use UM\command\{MuteCommand, UnmuteCommand};
use pocketmine\utils\Config;
use UM\event\{PlayerChat, PlayerCommandPreprocess};

class Main extends PluginBase implements Listener
{
	private static $instance;

	private $profiles = [];
  
	public function onEnable()
	{
		if(!self::$instance instanceof Main) self::$instance = $this;
		$this->registerCommands();
		$this->registerConfig();
		$this->registerEvents();
	}
  
	public static function getInstance() : Main
	{
		return self::$instance;
	}

	public function getProfile(string $name)
	{
		$this->profiles[$name] = $this->profiles[$name] ?? new Profile($name);
		return $this->profiles[$name];
	}

	private function registerCommands()
	{
		$this->getServer()->getCommandMap()->register("mute", new MuteCommand);
		$this->getServer()->getCommandMap()->register("unmute", new UnmuteCommand);
	}

	private function registerConfig()
	{
		if(!file_exists($this->getDataFolder())) mkdir($this->getDataFolder());
		$this->players = new Config($this->getDataFolder()."Players.yml", Config::YAML, []);
	}

	private function registerEvents()
	{
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->getServer()->getPluginManager()->registerEvents(new PlayerChat, $this);
		$this->getServer()->getPluginManager()->registerEvents(new PlayerCommandPreprocess, $this);
	}
}