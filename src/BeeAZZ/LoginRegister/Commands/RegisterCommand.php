<?php

namespace BeeAZZ\LoginRegister\Commands;

use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use BeeAZZ\LoginRegister\Main;

class RegisterCommand extends Command implements PluginOwned {

    public $plugin;

    public function __construct(Main $plugin){
    parent::__construct("register", "Register Command", null, ["reg", "signup"]);
       $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args){
       if(!$sender instanceof Player){
        return true;
     }
       $player = $sender;
       $name = $player->getName();
        if(!isset($args[0])){
         $player->sendMessage($this->plugin->getConfig()->get("USAGE-REGISTER"));
           return true;
        }
       if($this->plugin->register->exists($name)){
         $player->sendMessage($this->plugin->getConfig()->get("YOU-HAVE-REGISTERED"));
          return true;
    }
       if($player->hasPermission("loginregister.command.register")){
         $this->plugin->register->set($name, $args[0]);
         $this->plugin->register->save();
         $player->sendMessage($this->plugin->getConfig()->get("REGISTERED-SUCCESS"));
     }
    }
    
    public function getOwningPlugin() : Main {
        return $this->plugin;
    }
}
