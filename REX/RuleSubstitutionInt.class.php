<?php
//Substituer un entier par un autre :
class RuleSubstitutionInt extends Rule
{
	private $value_max;
	private $value_min;
	function __construct($table, $column, $interval_start, $interval_end)
	{
		parent::__construct($table, $column);
		$this->value_min = $interval_start;
		$this->value_max = $interval_end;
	}
	//On applique la regle
	public function launch($pdo)
	{
		//On recupere toutes les valeurs possibles du champ :
		$q = $pdo->query('SELECT DISTINCT ' . $this->targetColumn . ' FROM ' . $this->targetTable);
		//On mélange le dataset :
		$result = array();
		while($dt = $q->fetch())
		{
			//On applique $result[Ancienne valeur] = Futur valeur
			$result[$dt[$this->targetColumn]] = rand( $this->value_min, $this->value_max);
		}
		$q->closeCursor();
		//Pour chaque paire de clé Ancienne valeur => Futur valeur, on applique les changements ;
		foreach($result as $key => $value)
		{
			$pdo->exec('UPDATE ' . $this->targetTable . ' SET ' . $this->targetColumn . ' = ' . $value . ' WHERE ' . $this->targetColumn . ' = ' . $key);
		}
	}
}