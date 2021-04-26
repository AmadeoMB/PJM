<?php

use SilverStripe\ORM\DataObject;

class Supplier extends DataObject
{
    private static $db = [
        'Name' => 'Varchar(255)',
        'Address' => 'Text',
        'Phone' => 'Varchar(15)',
        'Email' => 'Varchar(255)',
    ];
}
