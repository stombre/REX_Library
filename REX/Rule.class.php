<?php
abstract class Rule
{
	//Table et colonne cibles.
	protected $targetTable;
	protected $targetColumn;

	//Constructeur :
	function __construct($table, $column)
	{
		$this->targetTable = $table;
		$this->targetColumn = $column;
	}

	//Methode a reecrire pour chaque rule :
	abstract public function launch($pdo);
}
