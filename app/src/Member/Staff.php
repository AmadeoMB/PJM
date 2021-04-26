<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Security\Member;


class Staff extends Member
{
    private static $db = [
        'Address' => 'Text',
        'Phone' => 'Varchar(15)',
        'Position' => 'Int',
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
        if ($this->ID == 0) {
            $this->Password = 'abcd1234';
            $this->Position = 1;
            $this->Status = 1;
        }
    }

    public function toArray()
    {
        $arr = array();
        $arr['ID'] = $this->ID;
        $arr['FirstName'] = $this->FirstName;
        $arr['Surname'] = $this->Surname;
        $arr['Email'] = $this->Email;
        $arr['Address'] = $this->Address;
        $arr['Phone'] = $this->Phone;
        $arr['Position'] = $this->Position;

        $token = AccessToken::get()->filter('MemberID', $this->ID)->first();
        if ($token) {
            $arr['AccessToken'] = $token->Token;
        }

        return $arr;
    }
}

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class StaffAdmin extends ModelAdmin
{
    /**
     * Managed data objects for CMS
     * @var array
     */
    private static $managed_models = [
        'Staff'
    ];

    /**
     * URL Path for CMS
     * @var string
     */
    private static $url_segment = 'staff-admin';

    /**
     * Menu title for Left and Main CMS
     * @var string
     */
    private static $menu_title = 'Staff';


}
