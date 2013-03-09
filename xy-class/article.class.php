<?php
/*
*FOR ARTICLE SHOW
*BY lucien_think
*/
class Article extends Safe{
	private $mysql;
	private $page;
	private $callback;
	private $articleid;
	private $title;
	private $contents;
	private $categoryid;
	private $categoryname;

	function __construct(){
		$this->Mysql = new XYMysql();
	}

	public function showListDataGet(){        	
		$this->callback = $this->callbackChecker($_REQUEST['c']);		
		if($_REQUEST['p']) $this->page = $this->pageChecker($_REQUEST['p']);
		else $this->page = 0;
		$this->categoryid = $this->idChecker($_REQUEST['cg']); 
	}

	public function showList($num){
		$begin = $this->page*$num;
		$sql = "SELECT id , title , left(contents,300) as content , pubtime from ".PRE."article";
		if($this->categoryid){
			$sql .= " where category='".$this->categoryid."'";
		}
		$sql .= " order by id desc limit ".$begin." , ".$num;
		$data = $this->Mysql->getData($sql);
		if($data){
			for ($i=0; $i < count($data); $i++) { 
				$data[$i]['content'] = htmlspecialchars_decode($data[$i]['content']);
			}
			$data = json_encode($data);
			echo $this->callback."(".$data.")";
		}
		else{
			echo $this->callback."(0)";
		}
	}

	public function showArticleDataGet(){
		$this->callback = $this->callbackChecker($_REQUEST['c']);
		$this->articleid = $this->idChecker($_REQUEST['i']);
	}

	public function showArticle(){
		$sql = "SELECT * from ".PRE."article where id=".$this->articleid;
		$data = $this->Mysql->getLine($sql);
		if($data){
			$data['m'] = 'old';
			$data['contents'] = htmlspecialchars_decode($data['contents']);
			$data = json_encode($data);
			echo $this->callback."(".$data.")";
		}
		else{
			$data['m'] = 'new';
			$data = json_encode($data);
			echo $this->callback."(".$data.")";
		}
	}

	public function editArticleDataGet(){
		$this->sessionCheck();
		$this->articleid = $this->idChecker($_REQUEST['i']);
		$this->title = $this->titleChecker($_REQUEST['title']);
		$this->contents = $this->textChecker($_REQUEST['contents']);
		$this->category = $this->idChecker($_REQUEST['category']);
	}

	public function editArticle(){
		$sql = "SELECT id from ".PRE."article where id=".$this->articleid;
		$data = $this->Mysql->getLine($sql);
		if(!$data){
			$sql = "INSERT into ".PRE."article (id,title,contents,pubtime,edittime,category) value('".$this->articleid."','".$this->title."', '".$this->contents."','".date("Y-m-d H:i:s",time())."','".date("Y-m-d H:i:s",time())."','".$this->category."')";
		}
		else{
			$sql = "UPDATE ".PRE."article set title='".$this->title."', contents='".$this->contents."', edittime='".date("Y-m-d H:i:s",time())."', category='".$this->category."' where id=".$this->articleid;
		}
		$this->Mysql->runSql($sql);
		if($this->Mysql->errno() != 0){
			die("Error:".$this->Mysql->errmsg());
		}
	}

	public function deleteArticleDataGet(){
		$this->sessionCheck();
		$this->articleid = $this->idChecker($_REQUEST['i']);
		$this->callback = $this->callbackChecker($_REQUEST['c']);
	}

	public function deleteArticle(){
		$sql = "DELETE from ".PRE."article where id=".$this->articleid;
		$this->Mysql->runSql($sql);
		if($this->Mysql->errno() != 0){
			die("Error:".$this->Mysql->errmsg());
		}
		echo $this->callback."('success')";
	}

	public function countArticleDataGet(){
		$this->callback = $this->callbackChecker($_REQUEST['c']);
		$this->categoryid = $this->idChecker($_REQUEST['cg']); 
	}

	public function countArticle(){
		$sql = "SELECT count(id) as num from ".PRE."article";
		if($this->categoryid){
			$sql .= " where category='".$this->categoryid."'";
		}
		$data = $this->Mysql->getLine($sql);
		if($data){
			$data = json_encode($data);
			echo $this->callback."(".$data.")";
		}
	}

	public function newIdDataGet(){
		$this->sessionCheck();
		$this->callback = $this->callbackChecker($_REQUEST['c']);
	}

	public function newId(){
		$sql = "SELECT max(id) as id from ".PRE."article";
		$data = $this->Mysql->getLine($sql);
		if($data){
			$data['id']++;
			$data = json_encode($data);
			echo $this->callback."(".$data.")";
		}
	}

	public  function categoryShowDataGet(){
		$this->callback = $this->callbackChecker($_REQUEST['c']);
	}

	public function categoryShow(){
		$sql = "SELECT * from ".PRE."category order by id desc";
		$data = $this->Mysql->getData($sql);
		if($data){
			for ($i=0; $i < count($data) ; $i++) { 
				$sql = "SELECT count(id) as num from ".PRE."article where category=".$data[$i]["id"];
				$da = $this->Mysql->getLine($sql);
				$data[$i]['num'] = $da['num'];
			}
			$data = json_encode($data);
			echo $this->callback."(".$data.")";
		}
	}

	public function categoryEditDataGet(){
		$this->sessionCheck();
		$this->categoryid = $this->idChecker($_REQUEST['id']);
		$this->categoryname = $this->titleChecker($_REQUEST['name']);
	}

	public function categoryEdit(){
		$sql = "SELECT * from ".PRE."category where id=".$this->categoryid;
		$data = $this->Mysql->getLine($sql);
		if($data){
			$sql = "UPDATE ".PRE."category set name = '".$this->categoryname."' where id=".$this->categoryid;
			$this->Mysql->runSql($sql);
			if($this->Mysql->errno() != 0){
				die("Error:".$this->Mysql->errmsg());
			}
		}
		else{
			$sql = "INSERT INTO ".PRE."category ( id , name ) values ('".$this->categoryid."' , '".$this->categoryname."')";
			$this->Mysql->runSql($sql);
			if($this->Mysql->errno() != 0){
				die("Error:".$this->Mysql->errmsg());
			}
		}
	}

	public function categoryDeleteDateGet(){
		$this->sessionCheck();
		$this->callback = $this->callbackChecker($_REQUEST['c']);
		$this->categoryid = $this->idChecker($_REQUEST['id']);
	}

	public function categoryDelete(){
		$sql = "DELETE from ".PRE."category where id=".$this->categoryid;
		$this->Mysql->runSql($sql);
		if($this->Mysql->errno() != 0){
			die("Error:".$this->Mysql->errmsg());
		}
		else{
			echo $this->callback."('success')";
		}
	}

	public function recentDataGet(){
		$this->callback = $this->callbackChecker($_REQUEST['c']);
	}

	public function recent(){
		$sql = "SELECT id,title from ".PRE."article order by id desc limit 0 , 5";
		$data = $this->Mysql->getData($sql);
		if($data){
			$data = json_encode($data);
			echo $this->callback."(".$data.")";
		}
	}
} 



?>