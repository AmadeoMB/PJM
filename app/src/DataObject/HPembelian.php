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
        'Supplier' => Supplier::class,
    ];

    private static $has_many = [
        'DPembelian' => DPembelian::class
    ];

    public function toArray()
    {
        $arr = array();
        $arr['ID'] = $this->ID;
        $arr['Total'] = $this->Total;
        $arr['TotalPembayaran'] = $this->TotalPembayaran;
        $arr['Supplier'] = $this->Supplier()->toArray();
        $arr['DPembelian'] = array();
        foreach ($this->DPembelian() as $key) {
            $arr['DPembelian'][] = $key->toArray();
        }

        return $arr;
    }
}
