<?php

namespace TheKuhlMc\kuhleconomy\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\lang\Translatable;
use pocketmine\player\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginOwned;
use pocketmine\Server;
use TheKuhlMc\kuhleconomy\api\API;
use TheKuhlMc\kuhleconomy\KuhlEconomy;

class SeeMoneyCommand extends Command implements PluginOwned{
    public function __construct(KuhlEconomy $plugin)
    {
        $cmds = KuhlEconomy::$commands;
        parent::__construct($cmds->getNested("seemoney.command"), $cmds->getNested("seemoney.description"), $cmds->getNested("seemoney.usagemessage"), $cmds->getNested("seemoney.aliases"));
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $msgs = KuhlEconomy::$messages;
        $cmds = KuhlEconomy::$commands;
        $api = new API();
        $config = KuhlEconomy::$config;
        if(!$sender instanceof Player){
            $sender->sendMessage($msgs->get("noplayer"));
            return false;
        }
        if(!isset($args[0])){
            $sender->sendMessage($cmds->getNested("seemoney.usagemessage"));
            return false;
        }
        if(isset($args[0])){
            $player = Server::getInstance()->getPlayerExact($args[0]);
            if(!$player instanceof Player){
                $sender->sendMessage($msgs->get("playerisoffline"));
                return false;
            }
            $msg = str_replace(["{player}", "{money}", "{symbol}"], [$player->getName(), $api->getMoney($player->getName()), $config->get("moneysymbol")], $msgs->get("seemoneysucces"));
            $sender->sendMessage($msg);
        }
    }

    public function getOwningPlugin(): Plugin
    {
        return $this->plugin;
    }
}
