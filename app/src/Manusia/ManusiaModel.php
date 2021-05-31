<?php

use SilverStripe\Admin\ModelAdmin;


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class ManusiaAdmin extends ModelAdmin
{
    /**
     * Managed data objects for CMS
     * @var array
     */
    private static $managed_models = [
        'Customer',
        'Sales',
        'Supplier',
    ];

    /**
     * URL Path for CMS
     * @var string
     */
    private static $url_segment = 'manusia-admin';

    /**
     * Menu title for Left and Main CMS
     * @var string
     */
    private static $menu_title = 'Manusia';


}
