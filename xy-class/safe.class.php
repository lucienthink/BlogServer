<?php
	/**
	* 安全验证类，自动加载，过滤
	* by lucien
	*/
	class Safe
	{
		public function sessionCheck(){
			if(1 != $_SESSION['id']){
				die("Not logged!");
			}
		}
		public function callbackChecker($data){
			return $data;
		}
		public function infoIdChecker($data){
			if($data != 1) die("The infoid is not current!");
			return $data;
		}
		public function pageChecker($data){
			if(strlen($data) > 4) die("Id is too long!");
			$data = preg_replace("/([^0-9]*)/", "", $data);
			return $data;
		}
		public function nameChecker($data){
			if(strlen($data)<4||strlen($data)>20) die("The name'length is not current!");
			$data = preg_replace("/([^a-zA-Z0-9_]*)/", "", $data);
			return $data;
		}
		public function passwdChecker($data){
			if(strlen($data)!=32) die("The password'length is not current!");
			$data = preg_replace("/([^a-zA-Z0-9_\!\@\#\$\%\^\*]*)/", "", $data);
			$data = md5(md5($data));
			return $data;
		}
		public function idChecker($data){
			if(strlen($data) > 4) die("Id is too long!");
			$data = preg_replace("/([^0-9]*)/", "", $data);
			return $data;
		}
		public function titleChecker($data){
			$data = htmlspecialchars_decode($data);
			$farr = array(
				"/\\s+/",
				"/<(\\/?)(scrīpt|i?frame|style|html|body|title|link|meta|\\?|\\%)([^>]*?)>/isU",
				"/(<[^>]*)on[a-zA-Z]+\\s*=([^>]*>)/isU"
			); 
			$tarr = array(
				" ",
				" ",
				" "
			); 
			$data = preg_replace( $farr,$tarr,$data);
			$data = htmlspecialchars($data);
			$data = mysql_real_escape_string($data);
			return $data;
		}
		public function textChecker($data){
			$data = htmlspecialchars_decode($data);
			$farr = array( 
				"/\\s+/",
				"/<(\\/?)(scrīpt|i?frame|position|html|body|title|link|meta|\\?|\\%)([^>]*?)>/isU",
				"/(<[^>]*)on[a-zA-Z]+\\s*=([^>]*>)/isU",
			); 
			$tarr = array(
				" ",
				" ",
				" "
			); 
			$data = preg_replace($farr,$tarr,$data);
			$data = htmlspecialchars($data);
			$data = mysql_real_escape_string($data);
			echo $data;
			return $data;
		}
	}




?>