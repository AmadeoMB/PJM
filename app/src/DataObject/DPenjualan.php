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

    /**
     * Event handler called before writing to the database.
     *
     * @uses DataExtension->onAfterWrite()
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $this->Subtotal = ($this->Item()->Price - ($this->Item()->Price * $this->Item()->Discount / 100)) * $this->Jumlah;
    }

    /**
     * Event handler called after writing to the database.
     *
     * @uses DataExtension->onAfterWrite()
     */
    public function onAfterWrite()
    {
        parent::onAfterWrite();
        $hpenjualan = $this->HPenjualan();
        $hpenjualan->Total += $this->Subtotal;
        $hpenjualan->write();
    }

    public function toArray()
    {
        $arr = array();
        $arr['ID'] = $this->ID;
        $arr['Jumlah'] = $this->Jumlah;
        $arr['Subtotal'] = $this->Subtotal;
        $arr['Item'] = $this->Item()->toArray();

        return $arr;
    }
}
