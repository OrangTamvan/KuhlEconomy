<?php

namespace TheKuhlMc\kuhleconomy\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginOwned;
use TheKuhlMc\kuhleconomy\api\API;
use TheKuhlMc\kuhleconomy\KuhlEconomy;

class MyMoneyCommand extends Command implements PluginOwned{
    public function __construct(KuhlEconomy $plugin)
    {
        $commands = KuhlEconomy::$commands;
        parent::__construct($commands->getNested("mymoney.command"), $commands->getNested("mymoney.description"), $commands->getNested("mymoney.usagemessage"), $commands->getNested("mymoney.aliases"));
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player){
            $sender->sendMessage(KuhlEconomy::$messages->get("noplayer"));
            return false;
        }
        $msg = str_replace(["{money}", "{symbol}"], [API::getMoney($sender->getName()), KuhlEconomy::$config->get("moneysymbol")], KuhlEconomy::$messages->get("mymoneysucces"));
        $sender->sendMessage($msg);
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->plugin;
    }
}
