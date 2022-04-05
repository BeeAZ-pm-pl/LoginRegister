<?php

namespace BeeAZZ\LoginRegister\Commands;

use pocketmine\player\Player;
use pocketmine\plugin\PluginOwned;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use BeeAZZ\LoginRegister\Main;

class CheckPassCommand extends Command implements PluginOwned {

    public $plugin;

    public function __construct(Main $plugin){
    parent::__construct("checkpass", "Check Password Command", null, ["cp"]);
      $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $label, array $args){
     if(!$sender instanceof Player){
         return true;
     }
      $player = $sender;
      $name = $player->getName();
        if(!isset($args[0])){
         $player->sendMessage($this->plugin->getConfig()->get("USAGE-CHECK"));
          return true;
        }
        if(!$this->plugin->register->exists($args[0])){
         $player->sendMessage($this->plugin->getConfig()->get("NAME-IS-NOT-REGISTERED"));
          return true;
    }
        if($player->hasPermission("loginregister.command.checkpass")){
          $player->sendMessage(str_replace(["{NAME}","{PASSWORD}"], [$args[0], $this->plugin->register->get($args[0])], $this->plugin->getConfig()->get("CHECKPASS")));
      }
    }
    
    public function getOwningPlugin() : Main {
        return $this->plugin;
    }
}
