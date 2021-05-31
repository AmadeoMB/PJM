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
        'Kemasan' => 'Int',
        'Discount' => 'Int',
        'Price' => 'Int',
        'BuyPrice' => 'Int'
    ];

    public function toArray()
    {
        $arr = array();
        $arr['ID'] = $this->ID;
        $arr['Title'] = $this->Title;
        if ($this->Kemasan != '' && $this->Kemasan != 0 && $this->Kemasan != 1) {
            $arr['Title'] .= ' @' . $this->Kemasan;
        }
        $arr['Price'] = $this->Price;
        $arr['Discount'] = $this->Discount;

        return $arr;
    }
}
