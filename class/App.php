<?php
class App{
		
	static $db = null;

	static function getDatabase(){

		if(!self::$db){

			self::$db = new Database('root', '', 'furid'); /*Identifient MDP Nom_De_La_Base BD LOCAL*/

		}

		return self::$db;

	}


	static function getAuth(){

		return new Auth(Session::getInstance(), ['restriction_msg' => "Tu ne peut pas aller sur cette page tu n'est pas connecter !"]);

	}


	static function redirect($page){
		header("Location: $page");
		exit();
	}

}