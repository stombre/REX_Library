<?php
//Substituer une date par une autre :
class RuleSubstitutionDate extends Rule
{
	private $date_min;
	private $date_max;
	private $date_mask;

	//Constructeur($table, colonne, mask de la date, object DateTime, object DateTime)
	function __construct($table, $column, $date_mask, $date_min = null, $date_max = null)
	{
		parent::__construct($table, $column);
		$this->date_mask = $date_mask;
		if($date_min == null){
			$date_min = new DateTime('0000-01-01');//Non précisé : Date en année 0
		}
		if($date_max == null){
			$date_max = new DateTime();//Non précisé : Date d'aujourd'hui
		}
		$this->date_min = $date_min;
		$this->date_max = $date_max;
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
			//Pour générer la futur valeur, on fait des rand sur chaque intervale :
			$min = $this->date_min->getTimestamp();
			$max = $this->date_max->getTimestamp();
			$year = rand(intval($this->date_min->format('Y')), intval($this->date_max->format('Y')));
			$month = rand(intval($this->date_min->format('m')), intval($this->date_max->format('m')));
			$day = rand(intval($this->date_min->format('d')), intval($this->date_max->format('d')));
			$hour = rand(intval($this->date_min->format('H')), intval($this->date_max->format('H')));
			$min = rand(intval($this->date_min->format('i')), intval($this->date_max->format('i')));
			$sec = rand(intval($this->date_min->format('s')), intval($this->date_max->format('s')));
			$year = str_pad(strval($year), 4, '0', STR_PAD_LEFT);
			$result[$dt[$this->targetColumn]] = new DateTime($year.'-'.$month.'-'.$day. ' '.$hour.':'.$min.':'.$sec);
			$result[$dt[$this->targetColumn]] = $result[$dt[$this->targetColumn]]->format($this->date_mask);
		}
		$q->closeCursor();
		//Pour chaque paire de clé Ancienne valeur => Futur valeur, on applique les changements ;
		foreach($result as $key => $value)
		{
			$pdo->exec('UPDATE ' . $this->targetTable . ' SET ' . $this->targetColumn . ' = \'' . $value . '\' WHERE ' . $this->targetColumn . ' = \'' . $key .'\'');
		}
	}
}