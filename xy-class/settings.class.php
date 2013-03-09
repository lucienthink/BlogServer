<?php
/*FOR SHOW INFORMATION
*
*
*BY LUCIEN
*/
class settings extends Safe{
	private $mysql;
	private $callback;
	private $name;
	private $title;
	private $contents;
	private $nickname;
	private $oldpasswd;
	private $newpasswd;


	function __construct(){
		$this->mysql = new XYMysql();
	}

	public function websetShowDataGet(){
		$this->callback = $this->callbackChecker($_REQUEST['c']);
	}

	public function websetShow(){
		$sql = "SELECT * from ".PRE."webset where id=1";
		$data = $this->mysql->getLine($sql);
		if($data){
			$data = json_encode($data);
			echo $this->callback."(".$data.")";
		}
	}

	public function websetEditDataGet(){
		$this->sessionCheck();
		$this->name = $this->textChecker($_POST['name']);
		$this->title = $this->textChecker($_POST['title']);
		$this->contents = $this->textChecker($_POST['contents']);
	}

	public function websetEdit(){
		$sql = "UPDATE ".PRE."webset set name='".$this->name."', title='".$this->title."', contents='".$this->contents."' where id=1";
		$this->mysql->runSql($sql);
		if($this->mysql->errno() != 0){
			die("Error:".$this->mysql->errmsg());
		}
	}

	public function accountShowDataGet(){
		$this->sessionCheck();
		$this->callback = $this->callbackChecker($_REQUEST['c']);
	}

	public function accountShow(){	
		$sql = "SELECT count(id) as num from ".PRE."article";
		$data = $this->mysql->getLine($sql);
		if($data){
			$data['username'] = $_SESSION['username'];
			$data['nickname'] = $_SESSION['nickname'];
			$data['lasttime'] = $_SESSION['lasttime'];
			$data['lastip'] = $_SESSION['lastip'];
			$data['thisip'] = $_SESSION['thisip'];
			$data = json_encode($data);
			echo $this->callback."(".$data.")";
		}
	}

	public function accountEditDataGet(){
		$this->sessionCheck();
		$this->nickname = $this->nameChecker($_POST['nickname']);
	}

	public function accountEdit(){
		$sql = "UPDATE ".PRE."users set nickname='".$this->nickname."' where id=1";
		$this->mysql->runSql($sql);
		if($this->mysql->errno() != 0){
			die("Error:".$this->mysql->errmsg());
		}
		$_SESSION['nickname'] = $this->nickname;
	}

	public function passwordDataGet(){
		$this->sessionCheck();
		$this->oldpasswd = $this->passwdChecker($_POST['oldpasswd']);
		$this->newpasswd = $this->passwdChecker($_POST['newpasswd']);
	}

	public function password(){
		if($_SESSION['password'] == $this->oldpasswd){
			$sql = "UPDATE ".PRE."users set password='".$this->newpasswd."' where id=1";
			$this->mysql->runSql($sql);
			if($this->mysql->errno() != 0){
				die("Error:".$this->mysql->errmsg());
			}
			
		}
	}

	public function passwordCheckDataGet(){
		$this->sessionCheck();
		$this->callback = $this->callbackChecker($_REQUEST['c']);
	}

	public function passwordCheck(){
		$sql = "SELECT password from ".PRE."users where id=1";
		$data = $this->mysql->getLine($sql);
		if($data && $_SESSION['password'] != $data['password']){
			echo $this->callback."('true')";
			$_SESSION['password'] = $data['password'];
		}
		else{
			echo $this->callback."('false')";
		}
	}
}



?>