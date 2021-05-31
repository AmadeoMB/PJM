<?php

use SilverStripe\ORM\DataObject;


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class DPembelian extends DataObject
{
    private static $db = [
        'Jumlah' => 'Int',
        'Subtotal' => 'Int'
    ];

    private static $has_one = [
        'Item' => Item::class,
        'HPembelian' => HPembelian::class
    ];

    /**
     * Event handler called before writing to the database.
     *
     * @uses DataExtension->onAfterWrite()
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $this->Subtotal = $this->Item()->BuyPrice * $this->Jumlah;
    }

    /**
     * Event handler called after writing to the database.
     *
     * @uses DataExtension->onAfterWrite()
     */
    public function onAfterWrite()
    {
        parent::onAfterWrite();
        $hpembelian = $this->HPembelian();
        $hpembelian->Total += $this->Subtotal;
        $hpembelian->write();
    }

    public function toArray()
    {
        $arr = array();
        $arr['ID'] = $this->ID;
        $arr['Jumlah'] = $this->Jumlah;
        $arr['Subtotal'] = $this->Subtotal;
        $arr['Item'] = $this->Item()->toArray();
    }
}
