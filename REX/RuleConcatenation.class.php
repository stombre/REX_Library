<?php
//Concatenation :
class RuleConcatenation extends Rule
{
	private $sourcesColumns;
	public function __construct($table, $column, $Columns)
	{
		parent::__construct($table, $column);
		$this->sourcesColumns = $Columns;
	}

	public function launch($pdo)
	{
		//CONCATENATION(val1, val2) (la norme) ou CONCAT(val1, val2) (MySQL nottament) ou val1 || val2 (Oracle)
		$commandeSQL = 'CONCAT';//MySQL
		$str = '';
		foreach($this->sourcesColumns as $column)
		{
			if($str != ''){$str .= ', ';};
			$str .= $column;
		}
		$pdo->exec('UPDATE ' . $this->targetTable . ' SET ' . $this->targetColumn . ' = '.$commandeSQL.'('.$str.')');
	}
}