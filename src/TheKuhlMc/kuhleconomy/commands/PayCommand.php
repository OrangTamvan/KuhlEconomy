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

class PayCommand extends Command implements PluginOwned{
    public function __construct(KuhlEconomy $plugin)
    {
        $commands = KuhlEconomy::$commands;
        parent::__construct($commands->getNested("pay.command"), $commands->getNested("pay.description"), $commands->getNested("pay.usagemessage"), $commands->getNested("pay.aliases"));
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
        if(!isset($args[0])){
            $sender->sendMessage($commands->getNested("pay.usagemessage"));
            return false;
        }
        if(!isset($args[1])){
            $sender->sendMessage($commands->getNested("pay.usagemessage"));
            return false;
        }
        if(isset($args[0])){
            if(isset($args[1])){
                $player = KuhlEconomy::getInstance()->getServer()->getPlayerExact($args[0]);
                if(!$player instanceof Player){
                    $sender->sendMessage($messages->get("playerisoffline"));
                    return false;
                }
                if($args[1] > API::getMoney($sender->getName())){
                    $sender->sendMessage($messages->get("paynomoney"));
                    return false;
                }
                if($config->get("minpaylimit") > $args[1]){
                    $sender->sendMessage($messages->get("paymoremoney"));
                    return false;
                }
                API::addMoney($player->getName(), $args[1]);
                API::removeMoney($sender->getName(), $args[1]);
                $msg = str_replace(["{player}", "{money}", "{symbol}"], [$player->getName(), $args[1], $config->get("moneysymbol")], $messages->get("paysendermessage"));
                $msg1 = str_replace(["{sender}", "{money}", "{symbol}"], [$sender->getName(), $args[1], $config->get("moneysymbol")], $messages->get("payplayermessage"));
                $sender->sendMessage($msg);
                $player->sendMessage($msg1);
            }
        }
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->plugin;
    }
}
