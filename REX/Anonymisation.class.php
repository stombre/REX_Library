<?php
/*
 Anonymisation
By A. BRANDAO & G. DAIX
Automne 2013
*/

//Main class : Anonymisation
// Contient les règles d'anonymisations :
class Anonymisation
{
	private $database;
	private $rules = array();

	//Constructeur :
	function __construct($pdo){
		$this->database = $pdo;
	}

	//Ajout d'une règle :
	public function add_rule($rule){
		array_push($this->rules, $rule);
	}

	//Application des règles :
	public function run()
	{
		foreach($this->rules as $r)
		{
			if($r != null){
				$r->launch($this->database);
			}
		}
	}
}