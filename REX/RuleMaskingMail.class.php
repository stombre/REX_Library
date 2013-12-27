<?php
//Mask une adresse mail :
class RuleMaskingMail extends CommandRule
{
	public function __construct($table, $column, $lengthBeforeAt, $lengthAfterAt)
	{
		parent::__construct($table, $column, 'CONCAT(SUBSTRING('.$column.', 1, '.$lengthBeforeAt.'), \'...\', SUBSTRING('.$column.', INSTR('.$column.', \'@\'), '.$lengthAfterAt.'), \'...\')');
	}
}