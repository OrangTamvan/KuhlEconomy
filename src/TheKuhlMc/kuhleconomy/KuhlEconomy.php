<?php

namespace TheKuhlMc\kuhleconomy;

use pocketmine\permission\DefaultPermissions;
use pocketmine\permission\Permission;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use TheKuhlMc\kuhleconomy\api\API;
use TheKuhlMc\kuhleconomy\commands\AddMoneyCommand;
use TheKuhlMc\kuhleconomy\commands\MyMoneyCommand;
use TheKuhlMc\kuhleconomy\commands\PayCommand;
use TheKuhlMc\kuhleconomy\commands\RemoveMoneyCommand;
use TheKuhlMc\kuhleconomy\commands\SetMoneyCommand;
use TheKuhlMc\kuhleconomy\events\MoneyRegisterEvent;
use TheKuhlMc\kuhleconomy\commands\SeeMoneyCommand;

class KuhlEconomy extends PluginBase{
    private static KuhlEconomy $instance;
    public static Config $money;
    public static Config $config;
    public static Config $commands;
    public static Config $messages;

    public function onEnable(): void
    {

        DefaultPermissions::registerPermission(new Permission("kuhleconomy.setmoney.use"));
        DefaultPermissions::registerPermission(new Permission("kuhleconomy.addmoney.use"));
        DefaultPermissions::registerPermission(new Permission("kuhleconomy.removemoney.use"));
        self::$instance = $this;
        self::saveResource("config.yml");
        self::saveResource("commands.yml");
        self::saveResource("messages.yml");
        self::$money = new Config($this->getDataFolder() . "money.yml", 2);
        self::$config = new Config($this->getDataFolder() . "config.yml", 2);
        self::$commands = new Config($this->getDataFolder() . "commands.yml", 2);
        self::$messages = new Config($this->getDataFolder() . "messages.yml", 2);
        self::getInstance()->getServer()->getPluginManager()->registerEvents(new MoneyRegisterEvent($this), $this);
        self::getInstance()->getServer()->getCommandMap()->register(self::$commands->getNested("setmoney.command"), new SetMoneyCommand($this));
        self::getInstance()->getServer()->getCommandMap()->register(self::$commands->getNested("mymoney.command"), new MyMoneyCommand($this));
        self::getInstance()->getServer()->getCommandMap()->register(self::$commands->getNested("seemoney.command"), new SeeMoneyCommand($this));
        self::getInstance()->getServer()->getCommandMap()->register(self::$commands->getNested("addmoney.command"), new AddMoneyCommand($this));
        self::getInstance()->getServer()->getCommandMap()->register(self::$commands->getNested("removemoney.command"), new RemoveMoneyCommand($this));
        self::getInstance()->getServer()->getCommandMap()->register(self::$commands->getNested("pay.command"), new PayCommand($this));
    }


    public static function getInstance(): self{
        return self::$instance;
    }
    public function addMoney(String $sender, int $amount){
        API::addMoney($sender, $amount);
    }
    public function removeMoney(String $sender, int $amount){
        API::removeMoney($sender, $amount);
    }
    public function setMoney(String $sender, int $amount){
        API::setMoney($sender, $amount);
    }
    public function getMoney(String $sender){
        return API::getMoney($sender);
    }
}
