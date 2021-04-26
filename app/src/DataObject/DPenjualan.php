<?php

use SilverStripe\ORM\DataObject;


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class DPenjualan extends DataObject
{
    private static $db = [
        'Jumlah' => 'Int',
        'Subtotal' => 'Int',
    ];

    private static $has_one = [
        'Item' => Item::class,
        'HPenjualan' => HPenjualan::class
    ];
}
