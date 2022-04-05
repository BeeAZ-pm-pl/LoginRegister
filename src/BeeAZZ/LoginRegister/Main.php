<?php

namespace BeeAZZ\LoginRegister;

use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\plugin\PluginBase;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\player\PlayerItemUseEvent;
use pocketmine\event\player\PlayerInteractEvent;
use BeeAZZ\LoginRegister\Task\KickTask;
use BeeAZZ\LoginRegister\Commands\LoginCommand;
use BeeAZZ\LoginRegister\Commands\RegisterCommand;
use BeeAZZ\LoginRegister\Commands\CheckPassCommand;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use pocketmine\utils\Config;
use pocketmine\event\entity\EntityItemPickupEvent;

class Main extends PluginBase implements Listener{
  
  public $login;
  
  public $register;
  
  public function onEnable(): void{
   $this->getServer()->getPluginManager()->registerEvents($this, $this);
   $this->login = new Config($this->getDataFolder()."login.yml",Config::YAML);
   $this->register = new Config($this->getDataFolder()."register.yml",Config::YAML);
   $this->saveDefaultConfig();
   $this->getServer()->getCommandMap()->register("login", new LoginCommand($this));
   $this->getServer()->getCommandMap()->register("register", new RegisterCommand($this));
   $this->getServer()->getCommandMap()->register("login", new CheckPassCommand($this));
  }
  
  public function onJoin(PlayerJoinEvent $ev){
   $player = $ev->getPlayer();
   $name = $player->getName();
   $this->getScheduler()->scheduleDelayedTask(new KickTask($this, $name), 20 * $this->getConfig()->get("TIME-KICK"));
    if(!$this->login->exists($name)){
     $this->login->set($name, false);
    }

  }
  
  public function onMove(PlayerMoveEvent $ev){
   $player = $ev->getPlayer();
   $name = $player->getName();
    if(!$this->register->exists($name)){
     $player->sendPopup($this->getConfig()->get("NO-REGISTER"));
     $ev->cancel();
      return;
  }
    if($this->login->get($name) !== true){
     $player->sendPopup($this->getConfig()->get("NO-LOGIN"));
     $ev->cancel();
  }

}

  public function onQuit(PlayerQuitEvent $ev){
   $player = $ev->getPlayer();
   $name = $player->getName();
   $this->login->set($name, false);
   $this->login->save();
  }
  
  public function onChat(PlayerChatEvent $ev){
   $player = $ev->getPlayer();
   $name = $player->getName();
     if($ev->isCancelled()){
       return;
       }
     if(!$this->register->exists($name)){
      $player->sendPopup($this->getConfig()->get("NO-REGISTER"));
      $ev->cancel();
       return;
      }
     if($this->login->get($name) !== true){
      $player->sendPopup($this->getConfig()->get("NO-LOGIN"));
      $ev->cancel(); 
    }
  }
  
  public function onPreProcess(PlayerCommandPreprocessEvent $ev){
   $player = $ev->getPlayer();
   $name = $player->getName();
   $msg = $ev->getMessage();
   $args = explode(" ", $msg, 2);
     if($ev->isCancelled()){
      return;
      }
     if($args[0] == "/register"){
      return;
     }
     if($args[0] == "/login"){
      return;
     }
     if(!$this->register->exists($name)){
      $player->sendPopup($this->getConfig()->get("NO-REGISTER"));
      $ev->cancel();
      return;
     }
     if($this->login->get($name) !== true){
      $player->sendPopup($this->getConfig()->get("NO-LOGIN"));
      $ev->cancel();
    }
  }
  
  public function onBreak(BlockBreakEvent $ev){
   $player = $ev->getPlayer();
   $name = $player->getName();
     if($ev->isCancelled()){
       return;
     }
     if(!$this->register->exists($name)){
      $player->sendPopup($this->getConfig()->get("NO-REGISTER"));
      $ev->cancel();
       return;
     }
     if($this->login->get($name) !== true){
      $player->sendPopup($this->getConfig()->get("NO-LOGIN"));
      $ev->cancel();
    }
  }
  
  public function onPlace(BlockPlaceEvent $ev){
   $player = $ev->getPlayer();
   $name = $player->getName();
    if($ev->isCancelled()){
      return;
     }
    if(!$this->register->exists($name)){
     $player->sendPopup($this->getConfig()->get("NO-REGISTER"));
     $ev->cancel();
      return;
     }
    if($this->login->get($name) !== true){
     $player->sendPopup($this->getConfig()->get("NO-LOGIN"));
     $ev->cancel();
   }
  }
  
  public function onUse(PlayerItemUseEvent $ev){
   $player = $ev->getPlayer();
   $name = $player->getName();
    if($ev->isCancelled()){
      return;
    }
    if(!$this->register->exists($name)){
     $player->sendPopup($this->getConfig()->get("NO-REGISTER"));
     $ev->cancel();
      return;
    }
    if($this->login->get($name) !== true){
     $player->sendPopup($this->getConfig()->get("NO-LOGIN"));
     $ev->cancel();
   }
  }
  
  public function onInteract(PlayerInteractEvent $ev){
   $player = $ev->getPlayer();
   $name = $player->getName();
     if($ev->isCancelled()){
       return;
     }
     if(!$this->register->exists($name)){
      $player->sendPopup($this->getConfig()->get("NO-REGISTER"));
      $ev->cancel();
       return;
      }
     if($this->login->get($name) !== true){
      $player->sendPopup($this->getConfig()->get("NO-LOGIN"));
      $ev->cancel();
   }
  }
  
  public function onItemPickup(EntityItemPickupEvent $ev){
   $player = $ev->getEntity();
     if($player instanceof Player){
      $name = $player->getName();
     if($ev->isCancelled()){
      return;
      }
     if(!$this->register->exists($name)){
      $player->sendPopup($this->getConfig()->get("NO-REGISTER"));
      $ev->cancel();
       return;
      }
     if($this->login->get($name) !== true){
      $player->sendPopup($this->getConfig()->get("NO-LOGIN"));
      $ev->cancel();
          }
       }
    }
}