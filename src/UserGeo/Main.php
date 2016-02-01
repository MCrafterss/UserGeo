<?php

  namespace UserGeo;

  use pocketmine\plugin\PluginBase; 
  use pocketmine\event\Listener;
  use pocketmine\utils\TextFormat as TF;
  use pocketmine\Player;
  use pocketmine\command\Command;
  use pocketmine\command\CommandSender;

  class Main extends PluginBase implements Listener {

    public function onEnable() {

      $this->getServer()->getPluginManager()->registerEvents($this, $this);

    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {

      if(strtolower($cmd->getName()) === "usergeo") {

        if(!(isset($args[0]) and isset($args[1]))) {

          $sender->sendMessage(TF::RED . "Error: not enough args. Usage: /usergeo <player> < city | hostname | region | country >");

          return true;

        } else {

          $geo_selection = $args[1];

          $name = $args[0];

          $player = $this->getServer()->getPlayer($name);

          if($player === null) {

            $sender->sendMessage(TF::RED . "Player " . $name . " could not be found.");

            return true;

          } else {

            $player_display_name = $player->getDisplayName();

            $player_ip = $player->getAddress();

            $data = file_get_contents("http://ipinfo.io/" . $player_ip);

            $player_geo = json_decode($data);

            $player_city = $player_geo->city;

            $player_hostname = $player_geo->hostname;

            $player_region = $player_geo->region;

            $player_country = $player_geo->country;

            if(strtolower($geo_selection) === "city") {

              $sender->sendMessage(TF::YELLOW . "<---- [ Gathering Info... ] ---->");

              $sender->sendMessage(TF::GREEN . $name . "'s City: " . $player_city . "!");

              return true;

            } else if(strtolower($geo_selection) === "hostname") {

              $sender->sendMessage(TF::YELLOW . "<---- [ Gathering Info... ] ---->");

              $sender->sendMessage(TF::GREEN . $name . "'s Hostname: " . $player_hostname . "!");

              return true;

            } else if(strtolower($geo_selection) === "region") {

              $sender->sendMessage(TF::YELLOW . "<---- [ Gathering Info... ] ---->");

              $sender->sendMessage(TF::GREEN . $name . "'s Region: " . $player_region . "!");

              return true;

            } else if(strtolower($geo_selection) === "country") {

              $sender->sendMessage(TF::YELLOW . "<---- [ Gathering Info... ] ---->");

              $sender->sendMessage(TF::GREEN . $name . "'s Country: " . $player_country . "!");

              return true;

            } else {

              $sender->sendMessage(TF::RED . "Error: " . $geo_selection . " was not recognised.");

              return true;

            }

          }

        }

      }

    }

  }

?>
