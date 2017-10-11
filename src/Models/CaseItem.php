<?php

namespace LasseRafn\DKS\Models;

use LasseRafn\DKS\Utils\Model;

class CaseItem extends Model
{
	/** @var array|Invoice[] */
	public $Invoices  = [];

	/** @var array|Debtor[] */
	public $Debtors   = [];

	/** @var string */
	public $Reference = '';
}
