<?php

use SilverStripe\Admin\ModelAdmin;
use SilverStripe\ORM\DataObject;


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class App extends DataObject
{
    private static $db = [
        'Name' => 'Varchar(255)',
        'ClientID' => 'Varchar(100)',
    ];

    /**
     * Defines summary fields commonly used in table columns
     * as a quick overview of the data for this dataobject
     * @var array
     */
    private static $summary_fields = [
        'Name',
        'ClientID',
    ];
}

/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class AppsAdmin extends ModelAdmin
{
    /**
     * Managed data objects for CMS
     * @var array
     */
    private static $managed_models = [
        'App'
    ];

    /**
     * URL Path for CMS
     * @var string
     */
    private static $url_segment = 'app-admin';

    /**
     * Menu title for Left and Main CMS
     * @var string
     */
    private static $menu_title = 'App';


}
