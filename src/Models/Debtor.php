<?php

namespace LasseRafn\DKS\Models;

use LasseRafn\DKS\Utils\Model;

class Debtor extends Model
{
	/**
	 * 0 = Person
	 * 1 = Private company
	 * 2 = Company
	 *
	 * @var int
	 */
	public $Type    = 1;

	/** @var Person|null */
	public $Person;

	/** @var Company|null */
	public $Company;
}
