<?php

use SilverStripe\CMS\Controllers\ContentController;


class HighAdminApiPage extends ApiPage
{

}

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class HighAdminApiPageController extends PageController
{
    public function doInit()
    {
        parent::doInit();
    }

    /**
     * Defines methods that can be called directly
     * @var array
     */
    private static $allowed_actions = [
        'CreateAdmin',
        'GetAdmin',
        'UpdateAdmin'
    ];

    public function CreateAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_encode('This request requires post submission');
        }

        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $FirstName = isset($_POST['FirstName']) ? $_POST['FirstName'] : null;
        $Surname = isset($_POST['Surname']) ? $_POST['Surname'] : null;
        $Email = isset($_POST['Email']) ? $_POST['Email'] : null;
        $Address = isset($_POST['Address']) ? $_POST['Address'] : null;
        $Phone = isset($_POST['Phone']) ? $_POST['Phone'] : null;

        if (!$FirstName || !$Surname || !$Email ||!$Address || !$Phone) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Mohon isi FirstName, Surname, Email, Address, dan Phone'
            ]);
        }

        $Staff = Staff::get()->filter('Email', $Email)->first();
        if ($Staff) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Email sudah terdaftar'
            ]);
        }

        $Staff = Staff::create();
        $Staff->FirstName = $FirstName;
        $Staff->Surname = $Surname;
        $Staff->Email = $Email;
        $Staff->Address = $Address;
        $Staff->Phone = $Phone;
        $Staff->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Sukses Create Admin',
            'Admin' => $Staff->toArray()
        ]);
    }

    public function GetAdmin()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $Keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

        $Staff = Staff::get()
        ->filter(['Position:LessThan' => 4])
        ->filterAny([
            'ID:PartialMatch' => $Keyword,
            'FirstName:PartialMatch' => $Keyword,
            'Surname:PartialMatch' => $Keyword,
            'Email:PartialMatch' => $Keyword,
        ]);
        $arr_Staff = array();
        foreach ($Staff as $key) {
            $arr_Staff[] = $key->toArray();
        }

        return json_encode([
            'Status' => 200,
            'Message' => 'Sukses Get Admin',
            'Admin' => $arr_Staff
        ]);
    }

    public function UpdateAdmin()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_encode('This request requires post submission');
        }

        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $id = $this->getRequest()->param('ID');

        if (!$id) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Mohon isi ID Staff'
            ]);
        }

        $staff = Staff::get_by_id($id);
        if (!$staff) {
            return json_encode([
                'Status' => 404,
                'Message' => 'Staff tidak ditemukan'
            ]);
        }

        $firstname = isset($_POST['FirstName']) ? $_POST['FirstName'] : $staff->FirstName;
        $surname = isset($_POST['Surname']) ? $_POST['Surname'] : $staff->Surname;
        $address = isset($_POST['Address']) ? $_POST['Address'] : $staff->Address;
        $phone = isset($_POST['Phone']) ? $_POST['Phone'] : $staff->Phone;
        $position = isset($_POST['Position']) ? $_POST['Position'] : $staff->Position;
        $status = isset($_POST['Status']) ? $_POST['Status'] : $staff->Status;

        $staff->FirstName = $firstname;
        $staff->Surname = $surname;
        $staff->Address = $address;
        $staff->Phone = $phone;
        $staff->Position = $position;
        $staff->Status = $status;
        $staff->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Sukses Update Staff',
            'Staff' => $staff->toArray()
        ]);
    }
}
