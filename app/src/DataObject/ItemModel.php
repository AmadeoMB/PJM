<?php

use SilverStripe\Admin\ModelAdmin;


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class ItemAdmin extends ModelAdmin
{
    /**
     * Managed data objects for CMS
     * @var array
     */
    private static $managed_models = [
        'Item',
        'Stock'
    ];

    /**
     * URL Path for CMS
     * @var string
     */
    private static $url_segment = 'item-admin';

    /**
     * Menu title for Left and Main CMS
     * @var string
     */
    private static $menu_title = 'Item';


}
