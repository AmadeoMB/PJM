<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class AccessToken extends DataObject
{
    private static $db = [
        'Token' => 'Varchar(100)',
    ];

    private static $has_one = [
        'Member' => Member::class,
    ];

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        $this->Token = AccessToken::GenerateToken();
        return;
    }

    static function isTokenExist($token)
    {
        $token = AccessToken::get()->filter(['Token' => $token])->first();
        if(!$token){
            return false;
        }
        else {
            return true;
        }
    }

    static function GenerateToken()
    {
        $token = md5(uniqid(mt_rand(), true));
        while(AccessToken::isTokenExist($token)){
            $token = md5(uniqid(mt_rand(), true));
        }
        return $token;
    }
}
