# KuhlEconomy
A EconomySystem for Pocket-Mine with a API

# Commands And Permissions
/seemoney | See the money of a Player | everyone
/mymoney | See your money | everyone
/setmoney | Set The Money Of A Player | kuhleconomy.setmoney.use
/addmoney | Add Money To A Player | kuhleconomy.addmoney.use
/removemoney | Remove Money from a Player | kuhleconomy.removemoney.use
/pay | Pay Money to a Player | everyone

# Config
In the configs you can edit every message, every command and the descriptions/aliases/usagemessage, the start money/money symbol and the minium pay limit

# API
this is how the api works:
get the money of a player:
$api = $this->getServer()->getPluginManager()->getPlugin("KuhlEconomy);
$api->getMoney($sender->getName); |
set the money of a player
$api = $this->getServer()->getPluginManager()->getPlugin("KuhlEconomy);
$api->setMoney($sender->getName, 1);
remove money from a player
$api = $this->getServer()->getPluginManager()->getPlugin("KuhlEconomy);
$api->removeMoney($sender->getName, 1);
add money to a player
$api = $this->getServer()->getPluginManager()->getPlugin("KuhlEconomy);
$api->addMoney($sender->getName, 1);
