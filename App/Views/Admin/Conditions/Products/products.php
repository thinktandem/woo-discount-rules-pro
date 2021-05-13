<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

$operator = isset($options->operator) ? $options->operator : 'in_list';
$cartqty = isset($options->cartqty) ? $options->cartqty : 'greater_than_or_equal';
$values = isset($options->value) ? $options->value : false;
echo ($render_saved_condition == true) ? '' : '<div class="cart_item_products">';
?>
<div class="products_group wdr-condition-type-options">
    <div class="wdr-product_filter_method wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][operator]" class="awdr-left-align">
            <option value="in_list" <?php echo ($operator == "in_list") ? "selected" : ""; ?>><?php _e('In List', 'woo-discount-rules-pro'); ?></option>
            <option value="not_in_list" <?php echo ($operator == "not_in_list") ? "selected" : ""; ?>><?php _e('Not In List', 'woo-discount-rules-pro'); ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Products should be', 'woo-discount-rules-pro'); ?></span>
    </div>
    <div class="wdr-product-condition-selector wdr-select-filed-hight wdr-search-box">
        <select multiple="" name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][value][]"
                class="awdr-product-validation <?php echo ($render_saved_condition == true) ? 'edit-filters' : '' ?>"
                data-placeholder="<?php _e('Search Products', 'woo-discount-rules-pro');?>"
                data-list="products"
                data-field="autocomplete"
                style="width: 100%; max-width: 400px;  min-width: 180px;">
            <?php
            if ($values) {
                $item_name = '';
                foreach ($values as $value) {
                    $item_name = '#'.$value.' '.get_the_title($value);
                    if ($item_name != '') { ?>
                        <option value="<?php echo $value; ?>" selected><?php echo $item_name; ?></option><?php
                    }
                }
            } ?>
        </select>
        <span class="wdr_select2_desc_text"><?php _e('Select Products', 'woo-discount-rules-pro'); ?></span>
    </div>
    <div class="wdr-condition-products wdr-select-filed-hight">
        <select name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][cartqty]" class="awdr-left-align">
            <option value="less_than_or_equal" <?php echo ($cartqty == "less_than_or_equal") ? "selected" : ""; ?>><?php _e('Less than or equal ( &lt;= )', 'woo-discount-rules-pro') ?></option>
            <option value="less_than" <?php echo ($cartqty == "less_than") ? "selected" : ""; ?>><?php _e('Less than ( &lt; )', 'woo-discount-rules-pro') ?></option>
            <option value="greater_than_or_equal" <?php echo ($cartqty == "greater_than_or_equal") ? "selected" : ""; ?>><?php _e('Greater than or equal ( &gt;= )', 'woo-discount-rules-pro') ?></option>
            <option value="greater_than" <?php echo ($cartqty == "greater_than") ? "selected" : ""; ?>><?php _e('Greater than ( &gt; )', 'woo-discount-rules-pro') ?></option>
        </select>
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Products Quantity In Cart', 'woo-discount-rules-pro'); ?></span>
    </div>
    <div class="wdr-product_filter_qty wdr-input-filed-hight">
        <input type="number" placeholder="<?php _e('qty', 'woo-discount-rules-pro');?>" min="0" step="any"
               name="conditions[<?php echo (isset($i)) ? $i : '{i}' ?>][options][qty]"
               class="awdr-left-align awdr-num-validation"
               value="<?php echo isset($options->qty) ? $options->qty : '1'; ?>">
        <span class="wdr_desc_text awdr-clear-both "><?php _e('Product Quantity', 'woo-discount-rules-pro'); ?></span>
    </div>
</div>
<?php echo ($render_saved_condition == true) ? '' : '</div>'; ?>
