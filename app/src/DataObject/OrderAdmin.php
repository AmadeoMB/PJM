<?php

use SilverStripe\Admin\ModelAdmin;


/**
 * Description
 *
 * @package silverstripe
 * @subpackage mysite
 */
class OrderAdmin extends ModelAdmin
{
    /**
     * Managed data objects for CMS
     * @var array
     */
    private static $managed_models = [
        'HPenjualan',
        'HPembelian'
    ];

    /**
     * URL Path for CMS
     * @var string
     */
    private static $url_segment = 'order-admin';

    /**
     * Menu title for Left and Main CMS
     * @var string
     */
    private static $menu_title = 'Orders';


}
