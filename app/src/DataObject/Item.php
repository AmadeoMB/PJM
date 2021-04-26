<?php

use SilverStripe\ORM\DataObject;


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class Item extends DataObject
{
    private static $db = [
        'Title' => 'Varchar(255)',
        'Description' => 'Text',
        'Weight' => 'Int',
        'Volume' => 'Int',
        'Discount' => 'Int',
        'Price' => 'Int',
        'InitialBalance' => 'Int',
    ];
}
