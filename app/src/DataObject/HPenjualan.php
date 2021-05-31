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

    private static $has_many = [
        'DPenjualan' => DPenjualan::class
    ];

    public function toArray()
    {
        $arr = array();
        $arr['ID'] = $this->ID;
        $arr['Total'] = $this->Total;
        $arr['TotalPembayaran'] = $this->TotalPembayaran;
        // $arr['Customer'] = $this->Customer()->toArray();
        // $arr['Sales'] = $this->Sales()->toArray();
        // $arr['DPenjualan'] = array();
        // foreach ($this->DPenjualan() as $key) {
        //     $arr['DPenjualan'][] = $key->toArray();
        //     // var_dump($key);
        // }
        // die();
        $arr['CreditTerm'] = $this->CreditTerm;
        $arr['CustomerName'] = $this->Customer()->Name;
        $arr['SalesName'] = $this->Sales()->Name;

        return $arr;
    }
}
