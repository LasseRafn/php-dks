<?php

namespace LasseRafn\DKS\Models;

use LasseRafn\DKS\Utils\Model;

class DKSCase extends Model
{
    protected $entity = 'products';
    protected $primaryKey = 'ProductGuid';

    public $CreatedAt;
    public $UpdatedAt;
    public $DeletedAt;
    public $ProductGuid;
    public $ProductNumber;
    public $Name;
    public $BaseAmountValue;
    public $Quantity;
    public $AccountNumber;
    public $Unit;
}
