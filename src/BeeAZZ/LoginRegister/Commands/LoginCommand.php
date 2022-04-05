<?php

namespace BeeAZZ\LoginRegister\Commands;

use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use BeeAZZ\LoginRegister\Main;

class LoginCommand extends Command implements PluginOwned {

    public $plugin;

    public function __construct(Main $plugin){
    parent::__construct("login", "Login Command", null, ["lg", "signin"]);
       $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args){
      if(!$sender instanceof Player){
        return true;
     }
       $player = $sender;
       $name = $player->getName();
        if(!isset($args[0])){
         $player->sendMessage($this->plugin->getConfig()->get("USAGE-LOGIN"));
           return true;
        }
        if(!$this->plugin->register->exists($name)){
         $player->sendMessage($this->plugin->getConfig()->get("UNREGISTER"));
          return true;
    }
        if($player->hasPermission("loginregister.command.login"))
        if($args[0] == $this->plugin->register->get($name)){
          $this->plugin->login->set($name, true);
          $player->sendMessage($this->plugin->getConfig()->get("LOGIN-SUCCESS"));
       }else{
        $player->kick($this->plugin->getConfig()->get("WRONG-PASSWORD"));
       }
    }
    
    public function getOwningPlugin() : Main {
        return $this->plugin;
    }
}
