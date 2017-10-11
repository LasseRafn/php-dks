<?php

namespace LasseRafn\DKS\Models;

use LasseRafn\DKS\Utils\Model;

class Invoice extends Model
{
	public $Number      = '';
	public $Regarding   = '';
	public $Date        = '';
	public $DueDate     = '';
	public $Amount      = '';

	/** @var InvoiceDocument|null */
	public $Document;

	/** @var array|InvoiceAdjustment[] */
	public $Adjustments = [];
}
