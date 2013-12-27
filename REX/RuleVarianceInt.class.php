<?php
//Variance :
class RuleVarianceInt extends CommandRule
{
	public function __construct($table, $column, $removeMax, $addMax)
	{
		$interval = $addMax - $removeMax;
		parent::__construct($table, $column, $column.' + ROUND(RAND() * '.$interval.')'.$removeMax);
	}
}