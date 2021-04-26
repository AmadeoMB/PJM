<?php

use SilverStripe\CMS\Controllers\ContentController;


class AdminApiPage extends ApiPage
{

}

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class AdminApiController extends PageController
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
        'CreateCustomer',
        'UpdateCustomer',
        'GetCustomer',
    ];

    public function CreateCustomer()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_encode('This request requires post submission');
        }

        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $name = isset($_POST['Name']) ? $_POST['Name'] : null;
        $address = isset($_POST['Address']) ? $_POST['Address'] : null;
        $phone = isset($_POST['Phone']) ? $_POST['Phone'] : null;
        $email = isset($_POST['Email']) ? $_POST['Email'] : null;
        $limitkredit = isset($_POST['LimitKredit']) ? $_POST['LimitKredit'] : null;

        if (!$name || !$address || !$phone || !$email || !$limitkredit) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Mohon isi data Customer dengan lengkap'
            ]);
        }

        $customer = Customer::create();
        $customer->Name = $name;
        $customer->Address = $address;
        $customer->Phone = $phone;
        $customer->Email = $email;
        $customer->LimitKredit = $limitkredit;
        $customer->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Sukses create customer',
            'Customer' => $customer->toArray()
        ]);
    }

    public function UpdateCustomer()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_encode('This request requires post submission');
        }

        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $id = $this->getRequest()->param('ID');

        $customer = Customer::get_by_id($id);
        if (!$customer) {
            return json_encode([
                'Status' => 404,
                'Message' => 'Data Customer tidak ditemukan'
            ]);
        }

        $name = isset($_POST['Name']) ? $_POST['Name'] : $customer->Name;
        $address = isset($_POST['Address']) ? $_POST['Address'] : $customer->Address;
        $phone = isset($_POST['Phone']) ? $_POST['Phone'] : $customer->Phone;
        $email = isset($_POST['Email']) ? $_POST['Email'] : $customer->Email;
        $limitkredit = isset($_POST['LimitKredit']) ? $_POST['LimitKredit'] : $customer->LimitKredit;

        $customer->Name = $name;
        $customer->Address = $address;
        $customer->Phone = $phone;
        $customer->Email = $email;
        $customer->LimitKredit = $limitkredit;
        $customer->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Sukses update customer',
            'Customer' => $customer->toArray()
        ]);
    }

    public function GetCustomer()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

        $customer = Customer::get()->filterAny(['Name:PartialMatch' => $keyword, 'ID:PartialMatch' => $keyword]);

        $arr_customer = array();
        foreach ($customer as $key) {
            $arr_customer[] = $key->toArray();
        }

        return json_encode([
            'Status' => 200,
            'Message' => 'Sukses Get Customer',
            'Customer' => $arr_customer
        ]);
    }
}
