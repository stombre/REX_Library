<?php
//Subsituer une valeur par une autre
class RuleSubstitutionString extends Rule
{
	//Dataset des valeurs à utiliser pour remplacer :
	private $dataset = array();

	//Des jeux de valeurs préutilisable ;
	static public $FRENCH_CITIES = array('Paris', 'Marseille', 'Lyon', 'Toulouse', 'Nice', 'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux', 'Lille', 'Rennes', 'Reims', 'Le Havre', 'Saint-Etienne', 'Toulon', 'Grenoble');
	static public $FRENCH_NAME = array('Martin', 'Bernard', 'Dubois', 'Thomas', 'Robert', 'Richard', 'Petit', 'Durand', 'Leroy', 'Moreau', 'Simon', 'Laurent', 'Lefebvre', 'Michel', 'Garcia', 'David', 'Bertrand', 'Roux', 'Vincent',
			'Fournier', 'Morel', 'Girard', 'Andre', 'Mercier', 'Dupont', 'Lambert', 'Bonnet', 'Francois', 'Martinez', 'Legrand', 'Garnier', 'Faure', 'Rousseau', 'Blanc', 'Guerin', 'Muller', 'Henry', 'Roussel', 'Nicolas', 'Daix', 'Brandao');
	static public $FRENCH_GIRLFIRSTNAME = array('Marie', 'Nathalie', 'Isabelle', 'Catherine', 'Sylvie', 'Monique', 'Francoise', 'Martine',
			'Jacqueline', 'Anne', 'Christine', 'Nicole', 'Valerie', 'Sandrine', 'Stephanie', 'Sophie', 'Celine', 'Veronique', 'Jeanne', 'Chantal');
	static public $FRENCH_BOYFIRSTNAME = array('Jean', 'Michel', 'Pierre', 'Philippe', 'Alain', 'Nicolas', 'Christophe', 'Patrick', 'Frederic',
			'Laurent', 'Stephane', 'David', 'Christian', 'Sebastien', 'Eric', 'Bernard','Andre','Daniel', 'Julien', 'Pascal');
	//Erreur chez moi, je ne comprends pas pourquoi :
	//static public $FRENCH_FIRSTNAME = array_merge(self::$FRENCH_GIRLFIRSTNAME, self::$FRENCH_BOYFIRSTNAME);

	//Constructeur :
	function __construct($table, $column, $set)
	{
		//On appel le constructeur du parent :
		parent::__construct($table, $column);
		$this->dataset = $set;
	}

	//On applique la regle
	public function launch($pdo)
	{
		//On recupere toutes les valeurs possibles du champ :
		$q = $pdo->query('SELECT DISTINCT ' . $this->targetColumn . ' FROM ' . $this->targetTable);
		//On mélange le dataset :
		$dataset = $this->dataset;
		shuffle($dataset);
		$result = array();
		while($dt = $q->fetch())
		{
			//On depile une valeur du dataset :
			$cur = array_pop($dataset);
			if($cur == null){//Si le dataset est VIDE, on reutilise une valeur qu'on a déjà associer :
				$cur = $result[array_rand($result, 1)];
			}
			//On applique $result[Ancienne valeur] = Futur valeur
			$result[$dt[$this->targetColumn]] = $cur;
		}
		$q->closeCursor();
		//Pour chaque paire de clé Ancienne valeur => Futur valeur, on applique les changements ;
		foreach($result as $key => $value)
		{
			$pdo->exec('UPDATE ' . $this->targetTable . ' SET ' . $this->targetColumn . ' = \'' . $value . '\' WHERE ' . $this->targetColumn . ' = \'' . $key . '\'');
		}
	}
}