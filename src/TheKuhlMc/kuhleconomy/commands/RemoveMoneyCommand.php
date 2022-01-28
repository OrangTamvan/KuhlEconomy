<?php

namespace TheKuhlMc\kuhleconomy\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use TheKuhlMc\kuhleconomy\api\API;
use TheKuhlMc\kuhleconomy\KuhlEconomy;

class RemoveMoneyCommand extends Command implements PluginOwned{
    public function __construct(KuhlEconomy $plugin)
    {
        $commands = KuhlEconomy::$commands;
        parent::__construct($commands->getNested("removemoney.command"), $commands->getNested("removemoney.description"), $commands->getNested("removemoney.usagemessage"), $commands->getNested("removemoney.aliases"));
        $this->setPermission("kuhleconomy.removemoney.use");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $commands = KuhlEconomy::$commands;
        $messages = KuhlEconomy::$messages;
        $config = KuhlEconomy::$config;
        if(!$sender instanceof Player){
            $sender->sendMessage(KuhlEconomy::$messages->get("noplayer"));
            return false;
        }
        if(!$sender->hasPermission("kuhleconomy.removemoney.use")){
            $sender->sendMessage($messages->get("noperm"));
            return false;
        }
        if(!isset($args[0])){
            $sender->sendMessage($commands->getNested("removemoney.usagemessage"));
            return false;
        }
        if(!isset($args[1])){
            $sender->sendMessage($commands->getNested("removemoney.usagemessage"));
            return false;
        }
        if(isset($args[0])){
            if(isset($args[1])){
                $player = KuhlEconomy::getInstance()->getServer()->getPlayerExact($args[0]);
                if(!$player instanceof Player){
                    $sender->sendMessage($messages->get("playerisoffline"));
                    return false;
                }
                API::removeMoney($player->getName(), $args[1]);
                $msg = str_replace(["{player}", "{money}", "{symbol}"], [$player->getName(), $args[1], $config->get("moneysymbol")], $messages->get("removemoneysucces"));
                $sender->sendMessage($msg);
            }
        }
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->plugin;
    }
}
