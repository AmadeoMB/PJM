<?php

use SilverStripe\ORM\DataObject;


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class Stock extends DataObject
{
    private static $db = [
        'DokumenID' => 'Int',
        'DokumenType' => 'Varchar(50)',
        'BalanceBefore' => 'Int',
        'Changes' => 'Int',
        'BalanceAfter' => 'Int'
    ];

    private static $has_one = [
        'Item' => Item::class
    ];
}
