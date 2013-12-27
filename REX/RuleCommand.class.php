<?php
//Commande SQL :
class RuleCommand extends Rule
{
	private $reqSQL;

	//Constructeur :
	public function __construct($table, $column, $SQL)
	{
		//On appel le constructeur du parent :
		parent::__construct($table, $column);
		$this->reqSQL = $SQL;
	}
	public function launch($pdo)
	{
		$pdo->exec('UPDATE ' . $this->targetTable . ' SET ' . $this->targetColumn . ' = ' . $this->reqSQL);
	}
}