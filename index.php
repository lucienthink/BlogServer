<?php
	header('Content-type: application/x-javascript'); 
	session_start();
	include_once("config.php");
	function __autoload($classname)
	{
		include ("xy-class/".strtolower($classname).".class.php");

	}
	switch ($_REQUEST['m']) {
		case 'l':
			$m = new Login();
		     	$m->dataGet();
		       	$m->Query();
			break;
		case 'lc':
			$m = new Login();
			$m->dataGet();
			$m->check();
			break;
		case 'lo':
			$m = new Login();
			$m->dataGet();
			$m->logout();
			break;
		case 'if':
			$m = new Info();
			$m->showDataGet();
			$m->show();
			break;
		case 'ef':
			$m = new Info();
			$m->editDataGet();
			$m->edit();
			break;
		case 'al':   	
			$m = new Article();    
			$m->showListDataGet();
			$m->showList(10);
			break;
		case 'ai':
			$m = new Article();
			$m->showArticleDataGet();
			$m->showArticle();
			break;
		case 'ac':
			$m = new Article();
			$m->categoryShowDataGet();
			$m->categoryShow();
			break;
		case 'ar':
			$m = new Article();
			$m->recentDataGet();
			$m->recent();
			break;
		case 'ec':
			$m = new Article();
			echo "1";
			$m->categoryEditDataGet();
			echo "2";
			$m->categoryEdit();
			break;
		case 'dc':
			$m = new Article();
			$m->categoryDeleteDateGet();
			$m->categoryDelete();
			break;
		case 'ea':
			$m = new Article();
			$m->editArticleDataGet();
			$m->editArticle();
			break;
		case 'da':
			$m = new Article();
			$m->deleteArticleDataGet();
			$m->deleteArticle();
			break;
		case 'na':
			$m = new Article();
			$m->countArticleDataGet();
			$m->countArticle();
			break;
		case 'ia':
			$m = new Article();
			$m->newIdDataGet();
			$m->newId();
			break;
		case 'w':
			$m = new settings();
			$m->websetShowDataGet();
			$m->websetShow();
			break;
		case 'ws':
			$m = new settings();
			$m->websetEditDataGet();
			$m->websetEdit();
			break;
		case 'c':
			$m = new settings();
			$m->accountShowDataGet();
			$m->accountShow();
			break;
		case 'ce':
			$m = new settings();
			$m->accountEditDataGet();
			$m->accountEdit();
			break;
		case 'p':
			$m = new settings();
			$m->passwordDataGet();
			$m->password();
			break;
		case 'pc':
			$m = new settings();
			$m->passwordCheckDataGet();
			$m->passwordCheck();
			break;
		default:
			die('Error!');
	}
?>