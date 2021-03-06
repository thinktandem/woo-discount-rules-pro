<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;
use WDRPro\App\Helpers\CoreMethodCheck;

class PurchaseFirstOrder extends Base
{
    protected static $cache_order_count = array();

    public function __construct()
    {
        parent::__construct();
        $this->name = 'purchase_first_order';
        $this->label = __('First order', 'woo-discount-rules-pro');
        $this->group = __('Purchase History', 'woo-discount-rules-pro');
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/PurchaseHistory/first-order.php';
    }

    function check($cart, $options)
    {
        $conditions = '';
        if($user = get_current_user_id()){
            $conditions = array('key' => '_customer_user', 'value' => $user, 'compare' => '=');
        } else {
            $billing_email = self::$woocommerce_helper->getBillingEmailFromPost();
            if(!empty($billing_email)) {
                $conditions = array('key' => '_billing_email', 'value' => $billing_email, 'compare' => '=');
            }
        }
        if (!empty($conditions)) {
            $cache_key = CoreMethodCheck::generateBase64Encode($options);
            if(isset(self::$cache_order_count[$cache_key])){
                $orders = self::$cache_order_count[$cache_key];
            } else {
                $args = array(
                    'posts_per_page' => 1,
                    'meta_query' => array(
                        $conditions
                    )
                );
                $orders = self::$cache_order_count[$cache_key] = CoreMethodCheck::getOrdersThroughWPQuery($args);
            }

            $first_order = (int)isset($options->value) ? $options->value : 1;
            if ($first_order) {
                return empty($orders);
            } else {
                return !empty($orders);
            }
        }
        return false;
    }
}