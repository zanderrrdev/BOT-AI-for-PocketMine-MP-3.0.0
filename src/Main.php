<?php

use command\AiCommand;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase {

	private static $instance;
	public $ainnova;

	/**
	 * Get the instance of the plugin
	 *
	 * @return self
	 */
	public static function getInstance(): self {
		return self::$instance;
	}

	public function onEnable() {
		self::$instance = $this;
		$this->getLogger()->info('BOT-AI plugin enabled');

		$this->getServer()->getCommandMap()->register('ai', new AiCommand($this));

		$settings = json_decode(file_get_contents($this->getDataFolder() . 'settings.json'), true);

		if ($this->ainnova = $this->getServer()->getPluginManager()->getPlugin('AInnova')) {
			if ($this->config->exists('token') && $this->config->exists('model')) {
				$this->ainnova->setApiUrl($this->config->get('url'));
				$this->ainnova->setToken($this->config->get('token'));
				$this->ainnova->setModel($this->config->get('model'));
			} else {
				$this->getLogger()->warning('Invalid settings in settings.json');
			}
		} else {
			$this->getLogger()->warning('AInnova plugin not found');
		}
	}

	/**
	 * Get the AInnova object
	 *
	 * @return mixed
	 */
	public function getObject() {
		return $this->ainnova;
	}
}
