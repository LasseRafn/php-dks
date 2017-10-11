<?php

namespace LasseRafn\DKS\Models;

use LasseRafn\DKS\Utils\Model;

class Company extends Model
{
	public $VatNumber   = '';
	public $Name        = '';
	public $Address     = '';
	public $PostalCode  = '';
	public $City        = '';
	public $CountryCode = '';
	public $Attention   = '';
	public $Phone       = '';
	public $Mail        = '';
}