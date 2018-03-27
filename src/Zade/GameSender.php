<?php
declare(strict_types=1);

namespace Zade;

use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat as TE;
use Zade\BuildMain;
use Zade\ResetMap;
use Zade\RefreshSigns;
use pocketmine\level\sound\PopSound;
use pocketmine\item\Item;
use pocketmine\level\sound\AnvilUseSound;
use pocketmine\level\Level;
use pocketmine\plugin\Plugin;
use pocketmine\Player;
use pocketmine\level\Position;
use pocketmine\utils\Config;
use pocketmine\tile\Sign;
use pocketmine\Server;

class GameSender extends PluginTask {
	
	public $plugin;
	public $prefix = "";
	
	public function __construct(BuildMain $plugin){
		$this->plugin = $plugin;
                $this->prefix = $this->plugin->prefix;
		parent::__construct($plugin);
	}
        
        public function getResetmap() {
        Return new ResetMap($this);
        }
  
	public function onRun($currentTick)
	{
		$config = new config($this->plugin->getDataFolder() . "/config.yml", Config::YAML);
                $slots = new config($this->plugin->getDataFolder() . "/slots.yml", Config::YAML);
		$arenas = $config->get("arenas");
		if(!empty($arenas))
		{
			foreach($arenas as $arena)
			{
				$time = $config->get($arena . "PlayTime");
				$timeToStart = $config->get($arena . "StartTime");
				$levelArena = $this->plugin->getServer()->getLevelByName($arena);
				if($levelArena instanceof Level)
				{
					$playersArena = $levelArena->getPlayers();
					if(count($playersArena)==0)
					{
						$config->set($arena . "PlayTime", 470);
						$config->set($arena . "StartTime", 30);
                                                $config->set($arena . "start", 0);
					}
					else
					{
                                                if(count($playersArena)>=3)
                                                {
                                                    $config->set($arena . "start", 1);
                                                    $config->save();
                                                }
						if($config->get($arena . "start")==1)
						{
							if($timeToStart>0)
							{
								$timeToStart--;
								foreach($playersArena as $pl)
								{
									$pl->sendTip(TE::WHITE."Game starts in ".TE::GREEN . $timeToStart . TE::RESET ."");
                                                                        if($timeToStart<=5)
                                                                        {
                                                                        $levelArena->addSound(new PopSound($pl));
                                                                        }
                                                                        if($timeToStart<=0)
                                                                        {
                                                                        $levelArena->addSound(new AnvilUseSound($pl));
                                                                        $temas = array_rand($config->get("temas"));
                                                                        $tema = $config->get("temas")[$temas];
                                                                        $config->set($arena . "tema", $tema);
                                                                        }
								}
                                                                if($timeToStart==29)
                                                                {
                                                                    $levelArena->setTime(7000);
                                                                    $levelArena->stopTime();
                                                                }
								if($timeToStart<=0)
								{
                                                                    foreach($playersArena as $pla)
                                                                    {
                                                                        if($slots->get("slot1".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn1");
                                                                        }
                                                                        elseif($slots->get("slot2".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn2");
                                                                        }
                                                                        elseif($slots->get("slot3".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn3");
                                                                        }
                                                                        elseif($slots->get("slot4".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn4");
                                                                        }
                                                                        elseif($slots->get("slot5".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn5");
                                                                        }
                                                                        elseif($slots->get("slot6".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn6");
                                                                        }
                                                                        elseif($slots->get("slot7".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn7");
                                                                        }
                                                                        elseif($slots->get("slot8".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn8");
                                                                        }
                                                                        elseif($slots->get("slot9".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn9");
                                                                        }
                                                                        elseif($slots->get("slot10".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn10");
                                                                        }
                                                                        elseif($slots->get("slot11".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn11");
                                                                        }
                                                                        elseif($slots->get("slot12".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn12");
                                                                        }
                                                                        elseif($slots->get("slot13".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn13");
                                                                        }
                                                                        elseif($slots->get("slot14".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn14");
                                                                        }
                                                                        elseif($slots->get("slot15".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn15");
                                                                        }
                                                                        elseif($slots->get("slot16".$arena)==$pla->getName())
                                                                        {
                                                                                $thespawn = $config->get($arena . "Spawn16");
                                                                        }
                                                                        $spawn = new Position($thespawn[0]+0.5,$thespawn[1],$thespawn[2]+0.5,$levelArena);
                                                                        $pla->teleport($spawn,0,0);
                                                                    }
								}
								$config->set($arena . "StartTime", $timeToStart);
							}
							else
							{
                                                                $tema = $config->get($arena . "tema");
                                                                $second = ($time - 170) % 60;
                                                                $timer = ($time - 170 - $second) / 60;
                                                                $minutes = $timer % 60;
                                                                $seconds = str_pad((string) $second, 2, "0", 1);
                                                                if($time>170)
                                                                {
                                                                    foreach($playersArena as $pla)
                                                                    {
                                                                        $pla->sendTip(TE::BOLD.TE::AQUA."Theme: " .TE::GREEN. $tema .TE::AQUA. "  Time".TE::YELLOW.$minutes.TE::DARK_PURPLE.": ".TE::YELLOW.$seconds. TE::RESET);
                                                                    }
                                                                }
								$time--;
								if($time == 469)
								{
                                                                    $laimit = new config($this->plugin->getDataFolder() . "/limit.yml", Config::YAML);
									foreach($playersArena as $pl)
									{
                                                                            $pl->sendMessage(TE::YELLOW.">>--------------------------------<<");
                                                                            $pl->sendMessage(TE::YELLOW."> ".TE::BOLD.TE::GREEN."§4Battle".TE::LIGHT_PURPLE." §eBuilders");
                                                                            $pl->sendMessage(TE::YELLOW."> ".TE::WHITE."Theme: ".TE::BOLD.TE::AQUA. $tema);
                                                                            $pl->sendMessage(TE::YELLOW."> ".TE::WHITE."You have a limited-time to build this related theme!");
                                                                            $pl->sendMessage(TE::YELLOW."> ".TE::GREEN."Time".TE::YELLOW." :".TE::AQUA." 5".TE::GREEN." minutes!");
                                                                            $pl->sendMessage(TE::YELLOW.">>--------------------------------<<");
                                                                            if($slots->get("slot1".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn1");
                                                                            }
                                                                            elseif($slots->get("slot2".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn2");
                                                                            }
                                                                            elseif($slots->get("slot3".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn3");
                                                                            }
                                                                            elseif($slots->get("slot4".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn4");
                                                                            }
                                                                            elseif($slots->get("slot5".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn5");
                                                                            }
                                                                            elseif($slots->get("slot6".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn6");
                                                                            }
                                                                            elseif($slots->get("slot7".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn7");
                                                                            }
                                                                            elseif($slots->get("slot8".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn8");
                                                                            }
                                                                            elseif($slots->get("slot9".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn9");
                                                                            }
                                                                            elseif($slots->get("slot10".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn10");
                                                                            }
                                                                            elseif($slots->get("slot11".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn11");
                                                                            }
                                                                            elseif($slots->get("slot12".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn12");
                                                                            }
                                                                            elseif($slots->get("slot13".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn13");
                                                                            }
                                                                            elseif($slots->get("slot14".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn14");
                                                                            }
                                                                            elseif($slots->get("slot15".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn15");
                                                                            }
                                                                            elseif($slots->get("slot16".$arena)==$pl->getName())
                                                                            {
                                                                                    $limite = $config->get($arena . "Spawn16");
                                                                            }
                                                                            $laimit->set($pl->getName(), $limite);
                                                                            $laimit->save();
									}
								}
								if($time>170)
                                                                {
                                                                    $time2 = $time-170;
									$minutes = $time2 / 60;
									if(is_int($minutes) && $minutes>0)
									{
										foreach($playersArena as $pl)
										{
											$pl->sendMessage($this->prefix .TE::YELLOW. $minutes . " " .TE::GREEN."minutes left...");
										}
									}
									elseif($time2 == 30 || $time2 == 15 || $time2 == 10 || $time2 ==5 || $time2 ==4 || $time2 ==3 || $time2 ==2 || $time2 ==1)
									{
										foreach($playersArena as $pl)
										{
											$pl->sendMessage($this->prefix .TE::YELLOW. $time2 . " " .TE::GREEN. "seconds left...");
                                                                                        $levelArena->addSound(new PopSound($pl));
										}
									}
								}
                                                                else
                                                                {
                                                                    if($time == 166 || $time == 156 || $time == 146 || $time ==136 || $time ==126 || $time ==116 || $time ==106 || $time ==96 || $time ==86 || $time ==76 || $time ==66 || $time ==56 || $time ==46 || $time ==36 || $time ==26)
                                                                    {
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                    $pl->sendMessage($this->prefix .TE::GREEN. "The game ends in " .TE::YELLOW. "5" .TE::GREEN. " seconds...");
                                                                                    $levelArena->addSound(new PopSound($pl));
                                                                            }
                                                                    }
                                                                    elseif($time == 165 || $time == 155 || $time == 145 || $time ==135 || $time ==125 || $time ==115 || $time ==105 || $time ==95 || $time ==85 || $time ==75 || $time ==65 || $time ==55 || $time ==45 || $time ==35 || $time ==25)
                                                                    {
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                    $pl->sendMessage($this->prefix .TE::GREEN. "The game ends in " .TE::YELLOW. "4" .TE::GREEN. " seconds...");
                                                                                    $levelArena->addSound(new PopSound($pl));
                                                                            }
                                                                    }
                                                                    elseif($time == 164 || $time == 154 || $time == 144 || $time ==134 || $time ==124 || $time ==114 || $time ==104 || $time ==94 || $time ==84 || $time ==74 || $time ==64 || $time ==54 || $time ==44 || $time ==34 || $time ==24)
                                                                    {
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                    $pl->sendMessage($this->prefix .TE::GREEN. "The game ends in " .TE::YELLOW. "3" .TE::GREEN. " seconds...");
                                                                                    $levelArena->addSound(new PopSound($pl));
                                                                            }
                                                                    }
                                                                    elseif($time == 163 || $time == 153 || $time == 143 || $time ==133 || $time ==123 || $time ==113 || $time ==103 || $time ==93 || $time ==83 || $time ==73 || $time ==63 || $time ==53 || $time ==43 || $time ==33 || $time ==23)
                                                                    {
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                    $pl->sendMessage($this->prefix .TE::GREEN. "The game ends in " .TE::YELLOW. "2" .TE::GREEN. " seconds...");
                                                                                    $levelArena->addSound(new PopSound($pl));
                                                                            }
                                                                    }
                                                                    elseif($time == 162 || $time == 152 || $time == 142 || $time ==132 || $time ==122 || $time ==112 || $time ==102 || $time ==92 || $time ==82 || $time ==72 || $time ==62 || $time ==52 || $time ==42 || $time ==32 || $time ==22)
                                                                    {
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                    $pl->sendMessage($this->prefix .TE::GREEN. "The game ends in " .TE::YELLOW. "1" .TE::GREEN. " second...");
                                                                                    $levelArena->addSound(new PopSound($pl));
                                                                            }
                                                                    }
                                                                    elseif($time == 161 || $time == 151 || $time == 141 || $time ==131 || $time ==121 || $time ==111 || $time ==101 || $time ==91 || $time ==81 || $time ==71 || $time ==61 || $time ==51 || $time ==41 || $time ==31 || $time ==21)
                                                                    {
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                    $pl->sendMessage($this->prefix .TE::GREEN. "The game ends in " .TE::YELLOW. "0" .TE::GREEN. " second...");
                                                                                    $levelArena->addSound(new PopSound($pl));
                                                                            }
                                                                    }
                                                                    if($time==11 || $time==21 || $time==31 || $time==41 || $time==51 || $time==61 || $time==71 || $time==81 || $time==91 || $time==101 || $time==111 || $time==121 || $time==131 || $time==141 || $time==151 || $time==161)
                                                                    {
                                                                        $points = new config($this->plugin->getDataFolder() . "/config".$arena.".yml", Config::YAML);
                                                                        foreach ($playersArena as $pl)
                                                                        {
                                                                            $yo = $config->get("actual".$arena);
                                                                            if($yo!=$pl->getName())
                                                                            {
                                                                                $pts = $points->get($yo);
                                                                                $dam = $pl->getInventory()->getItemInHand()->getDamage();
                                                                                $config = $this->plugin->getPoints($dam);
                                                                                $voto = $this->plugin->getConfirm($dam);
                                                                                $tot = $pts + $config;
                                                                                $points->set($config->get("actual".$arena), $tot);
                                                                                $points->save();
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Your vote".TE::GREEN.": ".TE::BOLD.$voto);
                                                                            }
                                                                        }
                                                                    }
                                                                    if($time==170)
                                                                    {
                                                                        $points = new config($this->plugin->getDataFolder() . "/config".$arena.".yml", Config::YAML);
                                                                        foreach($playersArena as $pl)
                                                                        {
                                                                            $pl->getInventory()->clearAll();
                                                                            $pl->getInventory()->setItem(1,Item::get(159,14,1));
                                                                            $pl->getInventory()->setItem(2,Item::get(159,6,1));
                                                                            $pl->getInventory()->setItem(3,Item::get(159,5,1));
                                                                            $pl->getInventory()->setItem(4,Item::get(159,13,1));
                                                                            $pl->getInventory()->setItem(5,Item::get(159,11,1));
                                                                            $pl->getInventory()->setItem(6,Item::get(159,4,1));
                                                                            $pl->getInventory()->setHotbarSlotIndex(1, 159);
                                                                            $pl->getInventory()->setHotbarSlotIndex(2, 159);
                                                                            $pl->getInventory()->setHotbarSlotIndex(3, 159);
                                                                            $pl->getInventory()->setHotbarSlotIndex(4, 159);
                                                                            $pl->getInventory()->setHotbarSlotIndex(5, 159);
                                                                            $pl->getInventory()->setHotbarSlotIndex(6, 159);
                                                                            $points->set($pl->getName(), 0);
                                                                            $points->save();
                                                                        }
                                                                        if($slots->get("slot1".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot1".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn1");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 160;
                                                                        }
                                                                    }
                                                                    if($time==160)
                                                                    {
                                                                        if($slots->get("slot2".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot2".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn2");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 150;
                                                                        }
                                                                    }
                                                                    if($time==150)
                                                                    {
                                                                        if($slots->get("slot3".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot3".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn3");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 140;
                                                                        }
                                                                    }
                                                                    if($time==140)
                                                                    {
                                                                        if($slots->get("slot4".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot4".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn4");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 130;
                                                                        }
                                                                    }
                                                                    if($time==130)
                                                                    {
                                                                        if($slots->get("slot5".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot5".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn5");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 120;
                                                                        }
                                                                    }
                                                                    if($time==120)
                                                                    {
                                                                        if($slots->get("slot6".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot6".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn6");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 110;
                                                                        }
                                                                    }
                                                                    if($time==110)
                                                                    {
                                                                        if($slots->get("slot7".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot7".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn7");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 100;
                                                                        }
                                                                    }
                                                                    if($time==100)
                                                                    {
                                                                        if($slots->get("slot8".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot8".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn8");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 90;
                                                                        }
                                                                    }
                                                                    if($time==90)
                                                                    {
                                                                        if($slots->get("slot9".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot9".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn9");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 80;
                                                                        }
                                                                    }
                                                                    if($time==80)
                                                                    {
                                                                        if($slots->get("slot10".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot10".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn10");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 70;
                                                                        }
                                                                    }
                                                                    if($time==70)
                                                                    {
                                                                        if($slots->get("slot11".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot11".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn11");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 60;
                                                                        }
                                                                    }
                                                                    if($time==60)
                                                                    {
                                                                        if($slots->get("slot12".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot12".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn12");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 50;
                                                                        }
                                                                    }
                                                                    if($time==50)
                                                                    {
                                                                        if($slots->get("slot13".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot13".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn13");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 40;
                                                                        }
                                                                    }
                                                                    if($time==40)
                                                                    {
                                                                        if($slots->get("slot14".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot14".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn14");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 30;
                                                                        }
                                                                    }
                                                                    if($time==30)
                                                                    {
                                                                        if($slots->get("slot15".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot15".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn15");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 20;
                                                                        }
                                                                    }
                                                                    if($time==20)
                                                                    {
                                                                        if($slots->get("slot16".$arena)!=null)
                                                                        {
                                                                            $actual = $slots->get("slot16".$arena);
                                                                            $config->set("actual".$arena, $actual);
                                                                            $thespawn = $config->get($arena . "Spawn16");
                                                                            foreach($playersArena as $pl)
                                                                            {
                                                                                $rand = mt_rand(1, 2);
                                                                                $ra = mt_rand(1, 6);
                                                                                if($rand==1)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]+$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                elseif($rand==2)
                                                                                {
                                                                                $spawn = new Position($thespawn[0]-$ra,$thespawn[1]+21,$thespawn[2]+0.5,$levelArena);
                                                                                }
                                                                                $pl->teleport($spawn,0,0);
                                                                                $pl->getInventory()->setHeldItemIndex(6);
                                                                                $pl->sendMessage($this->prefix .TE::AQUA.$tema);
                                                                                $pl->sendMessage($this->prefix .TE::YELLOW. "Plot Owner: " .TE::WHITE. TE::AQUA. $actual);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            $time = 10;
                                                                        }
                                                                    }
                                                                    if($time==10)
                                                                    {
                                                                        $points = new config($this->plugin->getDataFolder() . "/config".$arena.".yml", Config::YAML);
                                                                        $limit = new config($this->plugin->getDataFolder() . "/limit.yml", Config::YAML);
                                                                        $paints = $points->getAll();
                                                                        $values = array();
                                                                        foreach($paints as $key => $w){
                                                                            array_push($values, $w);
                                                                        }
                                                                        natsort($values);
                                                                        $val = array_reverse($values);
                                                                        $max = max($values);
                                                                        $quien = array_search($max, $paints);
                                                                        $thesp = $limit->get($quien);
                                                                        $this->plugin->getServer()->broadcastMessage($this->prefix .TE::YELLOW. ">> ".TE::AQUA."Winner of the BattleBuilders on $arena! ".TE::GREEN."With a ($tema) theme!");
                                                                        $this->plugin->getServer()->broadcastMessage($this->prefix .TE::YELLOW. "1: ".TE::AQUA.$quien." ".TE::GREEN.$max);
                                                                        unset($paints[$quien]);
                                                                        $quien2 = array_search($val[1], $paints);
                                                                        $this->plugin->getServer()->broadcastMessage($this->prefix .TE::YELLOW. "2: ".TE::AQUA.$quien2." ".TE::GREEN.$val[1]);
                                                                        unset($paints[$quien2]);
                                                                        $quien3 = array_search($val[2], $paints);
                                                                        $this->plugin->getServer()->broadcastMessage($this->prefix .TE::YELLOW. "3: ".TE::AQUA.$quien3." ".TE::GREEN.$val[2]);
                                                                        foreach($playersArena as $pl) {
                                                                            $puntaje = $points->get($pl->getName());
                                                                            $tupos = 1 + array_search($puntaje, $val);
                                                                            $rand = mt_rand(1, 2);
                                                                            $ra = mt_rand(1, 6);
                                                                            if($rand==1)
                                                                            {
                                                                            $spawn = new Position($thesp[0]+$ra,$thesp[1]+21,$thesp[2]+0.5,$levelArena);
                                                                            }
                                                                            elseif($rand==2)
                                                                            {
                                                                            $spawn = new Position($thesp[0]-$ra,$thesp[1]+21,$thesp[2]+0.5,$levelArena);
                                                                            }
                                                                            $pl->sendMessage($this->prefix .TE::GREEN. "Your Score: ".TE::YELLOW.$tupos." : ".TE::GREEN.$puntaje);
                                                                            $pl->teleport($spawn,0,0);
                                                                        }
                                                                    }
                                                                    if($time<=0)
                                                                    {
                                                                        $limit = new config($this->plugin->getDataFolder() . "/limit.yml", Config::YAML);
                                                                        foreach($playersArena as $pl)
                                                                        {
                                                                            $limit->set($pl->getName(), 0);
                                                                            $limit->save();
                                                                            $pl->teleport($this->plugin->getServer()->getDefaultLevel()->getSafeSpawn(),0,0);
                                                                            $pl->setGamemode(0);
                                                                            $pl->getInventory()->clearAll();
                                                                            $pl->removeAllEffects();
                                                                            $pl->setFood(20);
                                                                            $pl->setHealth(20);
                                                                        }
                                                                        $this->getResetmap()->reload($levelArena);
                                                                        $config->set($arena . "start", 0);
                                                                        $config->save();
                                                                        $points = new config($this->plugin->getDataFolder() . "/config".$arena.".yml", Config::YAML);
                                                                        foreach($points->getAll() as $key => $w){
                                                                            $points->set($key, 0);
                                                                        }
                                                                        $points->save();
                                                                        $time = 470;
                                                                    }
                                                                }
								$config->set($arena . "PlayTime", $time);
							}
						}
						else
						{
                                                    foreach($playersArena as $pl)
                                                    {
                                                            $pl->sendTip(TE::YELLOW . "Waiting For Players".TE::GREEN."... " .TE::RESET);
                                                    }
                                                    $config->set($arena . "PlayTime", 470);
                                                    $config->set($arena . "StartTime", 30);
						}
					}
				}
			}
		}
		$config->save();
	}
}
