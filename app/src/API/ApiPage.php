<?php

use SilverStripe\Security\Member;
use SilverStripe\CMS\Controllers\ContentController;




/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class ApiPage extends Page
{
    public function CheckClientID()
    {
        if (!isset($_SERVER['HTTP_CLIENTID'])) {
            return json_encode([
                'Status' => 419,
                'Message' => 'Unauthorized'
            ]);
        }

        $apps = App::get()->filter(['ClientID' => $_SERVER['HTTP_CLIENTID']])->first();

        if (!$apps) {
            return json_encode([
                'Status' => 419,
                'Message' => 'Unauthorized'
            ]);
        }
        return false;
    }

    public function CheckAccessToken()
    {
        if (!isset($_SERVER['HTTP_ACCESSTOKEN'])) {
            return json_encode([
                'Status' => 418,
                'Message' => 'Unauthorized'
            ]);
        }

        $token = AccessToken::get()->filter(['Token' => $_SERVER['HTTP_ACCESSTOKEN']])->first();

        if (!$token) {
            return json_encode([
                'Status' => 418,
                'Message' => 'Unauthorized'
            ]);
        }

        if ($token->Logout) {
            return json_encode([
                'Status' => 418,
                'Message' => 'Unauthorized'
            ]);
        }

        $member = Member::get_by_id($token->MemberID);
        if (!$member) {
            return json_encode([
                'Status' => 418,
                'Message' => 'Unauthorized'
            ]);
        }

        return false;
    }
}
