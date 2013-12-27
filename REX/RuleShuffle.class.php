<?php
//RuleShuffle ; Mélanger le champ
class RuleShuffle extends Rule
{	
	public function __construct($table, $column)
	{
		parent::__construct($table, $column);
	}
	
	public function launch($pdo)
	{
		$q = $pdo->query('SELECT ' . $this->targetColumn . ' FROM ' . $this->targetTable);
		$values = array();
		$i = 0;
		while($dt = $q->fetch())
		{
			$values[$i] = $dt[$this->targetColumn];
			$i++;
		}
		shuffle($values);
		
		$i = 0;
		while($dt = $q->fetch())
		{
			$pdo->exec('UPDATE ' . $this->targetTable . ' SET ' . $this->targetColumn . ' = \''.$values[$i].'\' WHERE ' . $this->targetColumn . ' = \'' . $dt[$this->targetColumn] . '\'');
			$i++;
		}
		$q -> closeCursor();
	}
}