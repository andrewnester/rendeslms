<?php
/**
 * User: nester_a
 * Date: 23.01.14
 */

namespace Rendes\Services;

class HashService
{
	public function hash($value)
	{
		return md5(sha1($value));
	}
}