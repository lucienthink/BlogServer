<?php
/*FOR SHOW INFORMATION
*
*
*BY LUCIEN
*/
class Info extends Safe{
	private $mysql;
	private $callback;
	private $id;
	private $info_about;
	private $info_ambition;
	private $info_work;
	private $info_contact;

	function __construct(){
		$this->mysql = new XYMysql();

	}
	public function showDataGet(){
		$this->callback = $this->callbackChecker($_REQUEST['c']);
		$this->id = $this->infoIdChecker($_REQUEST['f']);
	}
	public function show(){
		$sql = "SELECT * from ".PRE."info where id=".$this->id;
		$data = $this->mysql->getLine($sql);
		$data['about'] = htmlspecialchars_decode($data['about']);
		$data['ambition'] = htmlspecialchars_decode($data['ambition']);
		$data['work'] = htmlspecialchars_decode($data['work']);
		$data['contact'] = htmlspecialchars_decode($data['contact']);
		if($data){
			$data = json_encode($data);
			echo $this->callback."(".$data.")";
		}
	}
	public function editDataGet(){
		$this->sessionCheck();
		$this->id = $this->infoIdChecker($_REQUEST['f']);
		$this->info_about = $this->textChecker($_POST['info_about']);
		$this->info_ambition = $this->textChecker($_POST['info_ambition']);
		$this->info_work = $this->textChecker($_POST['info_work']);
		$this->info_contact = $this->textChecker($_POST['info_contact']);

	}
	public function edit(){
		$sql = "UPDATE ".PRE."info set about='".$this->info_about."', ambition='".$this->info_ambition."', work='".$this->info_work."', contact='".$this->info_contact."' where id=".$this->id;
		$this->mysql->runSql($sql);
		if($this->mysql->errno() != 0){
			die("Error:".$this->mysql->errmsg());
		}
	}

}



?>