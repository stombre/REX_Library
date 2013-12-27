<?php
//RuleHash ; pour le moment fonction SHA1 simple :
class RuleHash extends Rule
{
	public function launch($pdo)
	{
		// J'ai considéré que les SGBD ont tous une fonction SHA1, mais c'est à vérifier... Peut être passer par la fonction sha1 de php, mais beaucoup plus lent.
		$pdo->exec('UPDATE ' . $this->targetTable . ' SET ' . $this->targetColumn . ' = SHA1(' . $this->targetColumn . ')');
	}
}