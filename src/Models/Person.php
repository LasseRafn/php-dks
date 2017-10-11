<?php

namespace LasseRafn\DKS\Models;

use LasseRafn\DKS\Utils\Model;

class Person extends Model
{
	public $SocialSecurityNumber = '';
	public $Name                 = '';
	public $Address              = '';
	public $PostalCode           = '';
	public $City                 = '';
	public $CountryCode          = '';
	public $Attention            = '';
}
