<?php

namespace Rendes\Modules\User\Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Administrator
 *
 * @ORM\Entity(repositoryClass="\Rendes\Modules\User\Repositories\UserRepository")
 */
class Administrator extends Teacher
{

	function __construct()
	{
		$this->setRole('administrator');
	}

}