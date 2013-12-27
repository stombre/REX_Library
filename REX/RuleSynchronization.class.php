<?php
//Synchronization de valeurs :
class RuleSynchronization extends Rule
{
	private $sourceTable;
	private $sourceColumn;
	private $joinCondition;

	//Constructeur :
	function __construct($table, $column, $sourceTable, $sourceColumn, $joinCondition)
	{
		parent::__construct($table, $column);
		$this->sourceTable = $sourceTable;
		$this->sourceColumn = $sourceColumn;
		$this->joinCondition = $joinCondition;
	}
	public function launch($pdo)
	{
		//Creation de la jointure :
		$join = $this->targetTable . '.' . $this->joinCondition[0] . ' = ' . $this->sourceTable . '.' . $this->joinCondition[1];
		//Requete SQL :
		$pdo->exec('UPDATE ' . $this->targetTable . ' SET ' . $this->targetColumn . ' = (SELECT ' . $this->sourceColumn . ' FROM ' . $this->sourceTable . ' WHERE '.$join.')');
	}
}