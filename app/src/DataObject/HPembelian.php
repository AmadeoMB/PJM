<?php

use SilverStripe\ORM\DataObject;


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class HPembelian extends DataObject
{
    private static $db = [
        'Total' => 'Int',
        'CreditTerm' => 'Date',
        'TotalPembayaran' => 'Int'
    ];

    private static $has_one = [
        'Item' => Item::class,
        'DPembelian' => DPembelian::class
    ];
}
