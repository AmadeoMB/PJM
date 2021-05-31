<?php

use SilverStripe\ORM\DataObject;

class Customer extends DataObject
{
    private static $db = [
        'Name' => 'Varchar(255)',
        'Address' => 'Text',
        'Phone' => 'Varchar(15)',
        'LimitKredit' => 'Int',
        'Status' => 'Int'
    ];

    /**
     * Event handler called before writing to the database.
     *
     * @uses DataExtension->onAfterWrite()
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if ($this->ID < 1) {
            $this->Status = 1;
        }
    }

    public function toArray()
    {
        $arr = array();
        $arr['ID'] = $this->ID;
        $arr['Name'] = $this->Name;
        $arr['Address'] = $this->Address;
        $arr['Phone'] = $this->Phone;
        $arr['LimitKredit'] = $this->LimitKredit;
        $arr['Status'] = $this->Status;
        return $arr;
    }
}
