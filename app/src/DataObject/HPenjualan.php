<?php

use SilverStripe\ORM\DataObject;


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class HPenjualan extends DataObject
{
    private static $db = [
        'Total' => 'Int',
        'CreditTerm' => 'Date',
        'TotalPembayaran' => 'Int'
    ];

    private static $has_one = [
        'Customer' => Customer::class,
        'Sales' => Sales::class
    ];

    private static $Has_many = [
        'DPenjualan' => DPenjualan::class
    ];
}
