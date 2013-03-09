<?php
	/**
	* 
	*/
	class Comment extends Safe{
		private $Mysql;
		private $articleid;
		private $page;

		function __construct()
		{
			$this->Mysql = new XYMysql();

		}

		public function dataGet(){
			$this->callback = $this->callbackChecker($_REQUEST['c']);	
			$this->articleid = $this->articleChecker($_REQUEST['i']);	
			if($_REQUEST['t']) $this->page = $this->pageChecker($_REQUEST['t']);
			else $this->page = 0;	
		}

		public function commentShow($num){
			$begin = $this->page*$num;
			$sql = "SELECT * from ".PRE."comment limit ".$begin." , ".$num;
			$data = $this->Mysql->getData($sql);
			if($data){
				$data = json_encode($data);
				echo $this->callback."(".$data.")";
			}
		}

		public function insertdataGet(){
			$this->callback = $this->callbackChecker($_REQUEST['c']);
			$this->author = authorChecker($_REQUEST['']);
		}

		public function commentQuery(){
			$sql = "INSERT into ".PRE."comment (author,contents,pubtime) values ('".$this->author."','".$this->contents."','".$this->pubtime."')";
			$result = $this->Mysql->runSql($sql);
			if($result) echo $this->callback."('success')";
		}
	}




?>