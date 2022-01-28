<?php

namespace TheKuhlMc\kuhleconomy\api;

use TheKuhlMc\kuhleconomy\KuhlEconomy;

class API{

    public static function getMoney(string $player){
        $money = KuhlEconomy::$money;
        return $money->get($player);
    }
    public static function addMoney(string $player, int $amount){
        $money = KuhlEconomy::$money;
        $money->set($player, self::getMoney($player) + $amount);
        $money->save();
    }
    public static function removeMoney(string $player, int $amount){
        $money = KuhlEconomy::$money;
        $money->set($player, self::getMoney($player) - $amount);
        $money->save();
    }
    public static function setMoney(string $player, int $amount){
        $money = KuhlEconomy::$money;
        $money->set($player, $amount);
        $money->save();
    }
}
