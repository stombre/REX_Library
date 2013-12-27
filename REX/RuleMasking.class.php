<?php
//Mask une valeur :
class RuleMasking extends CommandRule
{
	public function __construct($table, $column, $lengthNoCover, $CoveredBy)
	{
		parent::__construct($table, $column, 'CONCAT(SUBSTRING('.$column.', 1, '.$lengthNoCover.'), \''.$CoveredBy.'\')');
	}
}