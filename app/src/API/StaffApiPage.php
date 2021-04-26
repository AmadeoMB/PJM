<?php

use SilverStripe\Security\Member;
use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Security\MemberAuthenticator\MemberAuthenticator;


class StaffApiPage extends ApiPage
{

}

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class StaffApiPageController extends PageController
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
        'Login',
        'LogOut'
    ];

    public function Login()
    {
        // if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        //     return json_encode('This request requires post submission');
        // }

        if ($this->CheckClientID()) {
            return $this->CheckClientID();
        }


        $Email = isset($_REQUEST['Email']) ? $_REQUEST['Email'] : null;
        $Password = isset($_REQUEST['Password']) ? $_REQUEST['Password'] : null;


        if (!$Email && !$Password) {
            return json_encode([
                'Status' => 417,
                'Message' => 'Mohon isi Email dan Password'
            ]);
        }

        $Staff = Staff::get()->filter(['Email' => $Email])->first();
        if (!$Staff) {
            return json_encode([
                'Status' => 404,
                'Message' => 'Email tidak ditemukan'
            ]);
        }

        $auth = new MemberAuthenticator();
        $result = $auth->checkPassword($Staff, $Password);
        if (!$result->isValid()) {
            return json_encode([
                'Status' => 404,
                'Message' => 'Password salah'
            ]);
        }

        $token = AccessToken::get()->filter(['MemberID' => $Staff->ID]);
        if ($token) {
            foreach ($token as $key) {
                $key->delete();
            }
        }

        $token = AccessToken::create();
        $token->MemberID = $Staff->ID;
        $token->write();

        return json_encode([
            'Status' => 200,
            'Message' => 'Sukses Login',
            'Data' => $Staff->toArray(),
        ]);
    }

    public function LogOut()
    {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return json_encode('This request requires post submission');
        }

        if ($this->CheckAccessToken()) {
            return $this->CheckAccessToken();
        }

        $token = $_SERVER['HTTP_ACCESSTOKEN'];
        $token = AccessToken::get()->filter('Token', $token)->first();
        $Staff = Staff::get_by_id($token->MemberID);

        $access = AccessToken::get()->filter('MemberID', $Staff->ID);
        foreach ($access as $key) {
            $key->delete();
        }

        return json_encode([
            'Status' => 201,
            'Message' => 'Sukses Log Out'
        ]);
    }
}
