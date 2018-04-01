<?php
declare(strict_types=1);

namespace Zade;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat as TE;
use Zade\BuildMain;
use Zade\ResetMap;
use Zade\GameSender;
use pocketmine\utils\Config;
use pocketmine\tile\Sign;
use pocketmine\plugin\Plugin;
use pocketmine\Server;

class RefreshSigns extends PluginTask {
	
	public $plugin;
    
	public function __construct(BuildMain $plugin){
		$this->plugin = $plugin;
                $this->prefix = $this->plugin->prefix;
		parent::__construct($plugin);
	}
  
	public function onRun($currentTick)
	{
		$allplayers = $this->plugin->getServer()->getOnlinePlayers();
		$level = $this->plugin->getServer()->getDefaultLevel();
		$tiles = $level->getTiles();
		foreach($tiles as $t) {
			if($t instanceof Sign) {	
				$text = $t->getText();
				if($text[3]==$this->prefix)
				{
					$aop = 0;
                                        $namemap = str_replace("§f", "", $text[2]);
					foreach($allplayers as $player){if($player->getLevel()->getFolderName()==$namemap){$aop=$aop+1;}}
					$ingame = TE::AQUA . "§a可加入";
					$config = new Config($this->plugin->getDataFolder() . "/config.yml", Config::YAML);
					if($config->get($namemap . "PlayTime")!=470)
					{
						$ingame = TE::DARK_PURPLE . "§c游戏中";
					}
					elseif($aop>=16)
					{
						$ingame = TE::GOLD . "§d满员了";
					}
                                        $t->setText($ingame,TE::YELLOW  . $aop . " / 16",$text[2],$this->prefix);
				}
			}
		}
	}
}
