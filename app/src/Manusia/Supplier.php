<?php

use SilverStripe\ORM\DataObject;

class Supplier extends DataObject
{
    private static $db = [
        'Name' => 'Varchar(255)',
        'Address' => 'Text',
        'Phone' => 'Varchar(15)',
    ];

    public function toArray()
    {
        $arr = array();
        $arr['ID'] = $this->ID;
        $arr['Name'] = $this->Name;
        $arr['Address'] = $this->Address;
        $arr['Phone'] = $this->Phone;

        return $arr;
    }
}
