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
class AdminApiPageController extends PageController
{
    public function doInit()
    {
        parent::doInit();
    }

    public function index()
    {
        return json_encode("Sukses");
    }

    /**
     * Defines methods that can be called directly
     * @var array
     */
    private static $allowed_actions = [
        'CreateCustomer',
        'UpdateCustomer',
        'GetCustomer',
        'CreateSales',
        'GetSales',
        'CreateBarang',
        'UpdateBarang',
        'GetBarang',
        'CreateSupplier',
        'GetSupplier',
        'GetPenjualan',
        'CreateHPenjualan',
        'CreateDPenjualan',
        'GetPembelian',
        'CreateHPembelian',
        'CreateDPembelian',
    ];

    public function CreateCustomer()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $name = isset($_REQUEST['Name']) ? $_REQUEST['Name'] : null;
        $address = isset($_REQUEST['Address']) ? $_REQUEST['Address'] : '';
        $phone = isset($_REQUEST['Phone']) ? $_REQUEST['Phone'] : '';
        $limitkredit = isset($_REQUEST['LimitKredit']) ? $_REQUEST['LimitKredit'] : 0;

        if (!$name) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Mohon isi nama Customer'
            ]);
        }

        $customer = Customer::create();
        $customer->Name = $name;
        $customer->Address = $address;
        $customer->Phone = $phone;
        $customer->LimitKredit = $limitkredit;
        $customer->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Sukses create customer',
            'Data' => $customer->toArray()
        ]);
    }

    public function UpdateCustomer()
    {
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

        $name = isset($_REQUEST['Name']) ? $_REQUEST['Name'] : $customer->Name;
        $address = isset($_REQUEST['Address']) ? $_REQUEST['Address'] : $customer->Address;
        $phone = isset($_REQUEST['Phone']) ? $_REQUEST['Phone'] : $customer->Phone;
        $limitkredit = isset($_REQUEST['LimitKredit']) ? $_REQUEST['LimitKredit'] : $customer->LimitKredit;

        $customer->Name = $name;
        $customer->Address = $address;
        $customer->Phone = $phone;
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

        $id = $this->getRequest()->param('ID');

        $arr_customer = array();

        if ($id) {
            $arr_customer = Customer::get_by_id($id)->toArray();
        }
        else {
            $keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

            $customer = Customer::get()->filterAny(['Name:PartialMatch' => $keyword, 'ID:PartialMatch' => $keyword]);
            foreach ($customer as $key) {
                $arr_customer[] = $key->toArray();
            }
        }

        // var_dump($arr_customer);die();

        return json_encode([
            'Status' => 200,
            'Message' => 'Sukses Get Customer',
            'Data' => $arr_customer
        ]);
    }

    public function CreateSales()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $name = isset($_REQUEST['Name']) ? $_REQUEST['Name'] : null;
        $address = isset($_REQUEST['Address']) ? $_REQUEST['Address'] : '';
        $phone = isset($_REQUEST['Phone']) ? $_REQUEST['Phone'] : '';

        if (!$name) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Mohon isi nama Sales'
            ]);
        }

        $sales = Sales::create();
        $sales->Name = $name;
        $sales->Address = $address;
        $sales->Phone = $phone;
        $sales->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Sukses create sales',
            'Data' => $sales->toArray()
        ]);
    }

    public function GetSales()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $id = $this->getRequest()->param('ID');
        $arr_sales = array();

        if ($id) {
            $arr_sales = Customer::get_by_id($id)->toArray();
        }
        else {
            $keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

            $sales = Sales::get()->filterAny(['Name:PartialMatch' => $keyword, 'ID:PartialMatch' => $keyword]);
            foreach ($sales as $key) {
                $arr_sales[] = $key->toArray();
            }
        }
        // var_dump($arr_customer);die();

        return json_encode([
            'Status' => 200,
            'Message' => 'Sukses Get Sales',
            'Data' => $arr_sales
        ]);
    }

    public function CreateBarang()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $Title = isset($_REQUEST['Title']) ? $_REQUEST['Title'] : null;
        $Kemasan = isset($_REQUEST['Kemasan']) ? $_REQUEST['Kemasan'] : 1;
        $Discount = isset($_REQUEST['Discount']) ? $_REQUEST['Discount'] : 0;
        $Price = isset($_REQUEST['Price']) ? $_REQUEST['Price'] : null;

        if (!$Title && !$Price) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Mohon isi Nama dan Harga Barang'
            ]);
        }

        $item = Item::create();
        $item->Title = $Title;
        $item->Kemasan = $Kemasan;
        $item->Discount = $Discount;
        $item->Price = $Price;
        $item->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Sukses create barang',
            'Data' => $item->toArray()
        ]);
    }

    public function UpdateBarang()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $ID = $this->getRequest()->param('ID');
        if (!$ID || $ID == '') {
            return json_encode([
                'Status' => 417,
                'Message' => 'Mohon memasukkan ID Barang'
            ]);
        }

        $item = Item::get_by_id($ID);

        // var_dump($_REQUEST);die();

        $Title = isset($_REQUEST['Title']) ? $_REQUEST['Title'] : $item->Title;
        $Kemasan = isset($_REQUEST['Kemasan']) ? $_REQUEST['Kemasan'] : $item->Kemasan;
        $Discount = isset($_REQUEST['Discount']) ? $_REQUEST['Discount'] : $item->Discount;
        $Price = isset($_REQUEST['Price']) ? $_REQUEST['Price'] : $item->Price;

        if ($Title == '') {
            return json_encode([
                'Status' => 417,
                'Message' => 'Mohon isi Nama Barang'
            ]);
        }
        $item->Title = $Title;
        $item->Kemasan = $Kemasan;
        $item->Discount = $Discount;
        $item->Price = $Price;
        $item->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Sukses Update barang',
            'Data' => $item->toArray()
        ]);
    }

    public function GetBarang()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $ID = $this->getRequest()->param('ID');
        if ($ID) {
            $item = Item::get_by_id($ID);

            if ($item) {
                return json_encode([
                    'Status' => 200,
                    'Message' => 'Sukses Get Barang',
                    'Data' => $item->toArray()
                ]);
            }

            return json_encode([
                'Status' => 404,
                'Message' => 'Barang not found'
            ]);
        }

        $keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

        $item = Item::get()->filterAny(['Title:PartialMatch' => $keyword, 'ID:PartialMatch' => $keyword]);

        $arr_item = array();
        foreach ($item as $key) {
            $arr_item[] = $key->toArray();
        }
        // var_dump($arr_customer);die();

        return json_encode([
            'Status' => 200,
            'Message' => 'Sukses Get Barang',
            'Data' => $arr_item
        ]);
    }

    public function CreateSupplier()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $name = isset($_REQUEST['Name']) ? $_REQUEST['Name'] : null;
        $address = isset($_REQUEST['Address']) ? $_REQUEST['Address'] : '';
        $phone = isset($_REQUEST['Phone']) ? $_REQUEST['Phone'] : '';

        if (!$name) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Mohon isi nama Supllier'
            ]);
        }

        $supplier = Supplier::create();
        $supplier->Name = $name;
        $supplier->Address = $address;
        $supplier->Phone = $phone;
        $supplier->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Sukses create supplier',
            'Data' => $supplier->toArray()
        ]);
    }

    public function GetSupplier()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $id = $this->getRequest()->param('ID');
        if ($id) {
            $arr_supplier = Supplier::get_by_id($id)->toArray();

            return json_encode([
                'Status' => 200,
                'Message' => 'Sukses Get Suplier',
                'Data' => $arr_supplier
            ]);
        }

        $keyword = isset($_GET['Keyword']) ? $_GET['Keyword'] : '';

        $supplier = Supplier::get()->filterAny(['Name:PartialMatch' => $keyword, 'ID:PartialMatch' => $keyword]);

        $arr_supplier = array();
        foreach ($supplier as $key) {
            $arr_supplier[] = $key->toArray();
        }
        // var_dump($arr_customer);die();

        return json_encode([
            'Status' => 200,
            'Message' => 'Sukses Get Suplier',
            'Data' => $arr_supplier
        ]);
    }

    public function GetPenjualan()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $penjualan = HPenjualan::get();
        $arr_penjualan = array();
        foreach ($penjualan as $key) {
            $arr_penjualan[] = $key->toArray();
        }

        return json_encode([
            'Status' => 200,
            'Message' => 'Sukses Get Penjualan',
            'Data' => $arr_penjualan
        ]);
    }

    public function CreateHPenjualan()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $customerid = isset($_REQUEST['CustomerID']) ? $_REQUEST['CustomerID'] : null;
        $salesid = isset($_REQUEST['SalesID']) ? $_REQUEST['SalesID'] : null;

        if (!$customerid || !$salesid) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Missing CustomerID Or SalesID'
            ]);
        }

        $customer = Customer::get_by_id($customerid);
        $sales = Sales::get_by_id($salesid);
        if (!$customer || !$sales) {
            return json_encode([
                'Status' => 404,
                'Message' => 'Customer or Sales Not Found'
            ]);
        }

        $penjualan = HPenjualan::create();
        $penjualan->CustomerID = $customer->ID;
        $penjualan->SalesID = $sales->ID;
        $penjualan->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Success Create Penjualan',
            'Data' => $penjualan->ID
        ]);
    }

    public function CreateDPenjualan()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $id = $this->getRequest()->param('ID');
        if (!$id) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Missing Header Penjualan ID'
            ]);
        }

        $penjualan = HPenjualan::get_by_id($id);
        if (!$penjualan) {
            return json_encode([
                'Status' => 404,
                'Message' => 'Header Penjualan Not Found'
            ]);
        }

        $itemid = isset($_REQUEST['ItemID']) ? $_REQUEST['ItemID'] : null;
        $jumlah = isset($_REQUEST['Jumlah']) ? $_REQUEST['Jumlah'] : null;

        if (!$itemid || !$jumlah) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Missing ItemID Or Jumlah'
            ]);
        }

        $item = Item::get_by_id($itemid);
        if (!$item) {
            return json_encode([
                'Status' => 404,
                'Message' => 'Item Not Found'
            ]);
        }

        $dpenjualan = DPenjualan::create();
        $dpenjualan->HPenjualanID = $id;
        $dpenjualan->ItemID = $itemid;
        $dpenjualan->Jumlah = $jumlah;
        $dpenjualan->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Success Create Detail Penjualan'
        ]);
    }

    public function GetPembelian()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $pembelian = HPembelian::get();
        $arr_pembelian = array();
        foreach ($pembelian as $key) {
            $arr_pembelian[] = $key->toArray();
        }

        return json_encode([
            'Status' => 200,
            'Message' => 'Sukses Get Pembelian',
            'Data' => $arr_pembelian
        ]);
    }

    public function CreateHPembelian()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $supplierid = isset($_REQUEST['SupplierID']) ? $_REQUEST['SupplierID'] : null;

        if (!$supplierid) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Missing Supplier ID'
            ]);
        }

        $supplier = Supplier::get_by_id($supplierid);
        if (!$supplier) {
            return json_encode([
                'Status' => 404,
                'Message' => 'Customer or Sales Not Found'
            ]);
        }

        $pembelian = HPembelian::create();
        $pembelian->SupplierID = $supplier->ID;
        $pembelian->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Success Create Header Pembelian'
        ]);
    }

    public function CreateDPembelian()
    {
        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $id = $this->getRequest()->param('ID');
        if (!$id) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Missing Header Pembelian ID'
            ]);
        }

        $pembelian = HPembelian::get_by_id($id);
        if (!$pembelian) {
            return json_encode([
                'Status' => 404,
                'Message' => 'Header Pembelian Not Found'
            ]);
        }

        $itemid = isset($_REQUEST['ItemID']) ? $_REQUEST['ItemID'] : null;
        $jumlah = isset($_REQUEST['Jumlah']) ? $_REQUEST['Jumlah'] : null;

        if (!$itemid || !$jumlah) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Missing ItemID Or Jumlah'
            ]);
        }

        $item = Item::get_by_id($itemid);
        if (!$item) {
            return json_encode([
                'Status' => 404,
                'Message' => 'Item Not Found'
            ]);
        }

        $dpembelian = DPembelian::create();
        $dpembelian->ItemID = $itemid;
        $dpembelian->Jumlah = $jumlah;
        $dpembelian->write();

        return json_encode([
            'Status' => 201,
            'Message' => 'Success Create Detail Pembelian'
        ]);
    }
}
