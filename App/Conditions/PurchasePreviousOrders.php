<?php

namespace WDRPro\App\Conditions;
if (!defined('ABSPATH')) {
    exit;
}
use Wdr\App\Conditions\Base;
use WDRPro\App\Helpers\CoreMethodCheck;

class PurchasePreviousOrders extends Base
{
    protected static $cache_order_count = array();
    public function __construct()
    {
        parent::__construct();
        $this->name = 'purchase_previous_orders';
        $this->label = __('Number of orders made', 'woo-discount-rules-pro');
        $this->group = __('Purchase History', 'woo-discount-rules-pro');
        $this->template = WDR_PRO_PLUGIN_PATH . 'App/Views/Admin/Conditions/PurchaseHistory/previous-order.php';
    }

    function check($cart, $options)
    {
        if (isset($options->operator) && isset($options->time) && isset($options->count) && !empty($options->count)) {
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
                    $order_count = self::$cache_order_count[$cache_key];
                } else {
                    $args = array(
                        'meta_query' => array(
                            $conditions
                        )
                    );
                    if (isset($options->status) && is_array($options->status) && !empty($options->status)) {
                        $args['post_status'] = $options->status;
                    }
                    if ($options->time != "all_time") {
                        $args['date_query'] = array('after' => $this->getDateByString($options->time, 'Y-m-d').' 00:00:00');
                    }
                    $orders = CoreMethodCheck::getOrdersThroughWPQuery($args);
                    $order_count = self::$cache_order_count[$cache_key] = count($orders);
                }

                return $this->doComparisionOperation($options->operator, $order_count, $options->count);
            }
        }
        return false;
    }
}