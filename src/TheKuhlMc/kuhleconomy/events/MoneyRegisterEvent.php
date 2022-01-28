<?php

namespace TheKuhlMc\kuhleconomy\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use TheKuhlMc\kuhleconomy\api\API;
use TheKuhlMc\kuhleconomy\KuhlEconomy;

class MoneyRegisterEvent implements Listener{
    public function __construct(KuhlEconomy $plugin){
        $this->plugin = $plugin;
    }

    public function onJoin(PlayerJoinEvent $e){
        $player = $e->getPlayer();
        $name = $player->getName();
        $money = KuhlEconomy::$money;
        if(!$money->exists($name)){
            API::setMoney($name, KuhlEconomy::$config->get("startmoney"));
        }
    }
}
