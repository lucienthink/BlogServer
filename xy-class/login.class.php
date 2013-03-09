<?php
/*
*FOR LOGIN
*BY lucien_think
*/
	class Login extends Safe{
		private $Mysql;
		private $form;
		private $username;
		private $password;
		private $callback;

		function __construct(){
			$this->Mysql = new XYMysql();
                        
		}

//GET JSON DATA		
		public function dataGet(){
			$this->callback = $this->callbackChecker($_REQUEST['c']);
			$this->username = $_REQUEST['un']?$this->nameChecker($_REQUEST['un']):null;
			$this->password = $_REQUEST['pw']?$this->passwdChecker($_REQUEST['pw']):null;
		}

//Query the user
		public function Query(){
			$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
			$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
			$sql = "SELECT * from ".PRE."users where username = '".$this->username."' and password = '".$this->password."'";
			$data = $this->Mysql->getLine($sql);
			if($data) {
				$_SESSION['id'] = $data['id'];
				$_SESSION['username'] = $data['username'];
				$_SESSION['password'] = $data['password'];
				$_SESSION['nickname'] = $data['nickname'];
				$_SESSION['lasttime'] = $data['lasttime'];
				$_SESSION['lastip'] = $data['lastip'];
				$_SESSION['thisip'] = $user_IP;
				echo $this->callback."('".$_SESSION['nickname']."')";
			}		
			$sql = "UPDATE ".PRE."users set lasttime='".date("Y-m-d H:i:s",time())."', lastip='".$user_IP."' where id=1";
			$this->Mysql->runSql($sql);
			if($this->mysql->errno() != 0){
				die("Error:".$this->mysql->errmsg());
			}
		}
//Check the user login or not
		public function Check(){
			if($_SESSION['id']){
				echo $this->callback."('".$_SESSION['nickname']."')";
			}
			else{
				echo $this->callback."('Not Logged')";
			}
		}
//logout
		public function logout(){
			unset($_SESSION['id']);
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			unset($_SESSION['nickname']);
			unset($_SESSION['lasttime']);
			unset($_SESSION['lastip']);
			session_destroy();
			echo $this->callback."('logout')";
		}

	}
?>