<?php

namespace UM;

use UM\Main;

class Profile
{

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	public function isMute() : bool
	{
		return (Main::getInstance()->players->get($this->name) !== false && Main::getInstance()->players->get($this->name) >= time());
	}

	public function setMute(int $time)
	{
		Main::getInstance()->players->set($this->name, $time);
		Main::getInstance()->players->save();
	}
}