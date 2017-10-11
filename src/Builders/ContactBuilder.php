<?php

namespace LasseRafn\DKS\Builders;

use LasseRafn\DKS\Models\Contact;
use LasseRafn\DKS\Utils\Builder;

class ContactBuilder extends Builder
{
    protected $entity = 'contacts';
    protected $model = Contact::class;
}
