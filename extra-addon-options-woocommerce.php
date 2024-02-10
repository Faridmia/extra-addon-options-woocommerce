<?php

/**
 * Plugin Name:       Extra Addon Options WooCommerce
 * Plugin URI:        faridmia
 * Description:       Extra Addon plugin for WooCommerce. It provides a well-designed it uses product single page to your users.
 * Version:           1.0.0
 * Author:            faridmia
 * Author URI:        faridmia
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       eaw
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

# Defines CONSTANTS for Whole plugins.

define('EAW_WOO_FILE', __FILE__);
define('EAW_WOO_VERSION', '1.0.0');
define('EAW_WOO_URL', plugins_url('/', __FILE__));
define('EAW_WOO_PATH', plugin_dir_path(__FILE__));
define('EAW_WOO_DIR_URL', plugin_dir_url(__FILE__));
define('EAW_WOO_BASENAME', plugin_basename(__FILE__));
define('EAW_WOO_ASSETS', EAW_WOO_URL);
define('EAW_WOO_ASSETS_PATH', EAW_WOO_PATH);


#Admin notice when not WooCommerce plugin not acitvated

function eaw_admin_notices()
{ ?>
    <div class="error">
        <p><?php _e('<strong>Extra Addon WooCommerce requires WooCommerce to be installed and active. You can download <a href="https://woocommerce.com/" target="_blank">WooCommerce</a> here.</strong>', 'eaw'); ?></p>
    </div>
<?php
}

# WooCommerce plugin dependency

function eaw_install_woocommerce_dependency()
{
    if (!function_exists('WC')) {
        add_action('admin_notices', 'eaw_admin_notices');
    }
}

add_action('plugins_loaded',  'eaw_install_woocommerce_dependency');

# Enqueue scripts

add_action('admin_enqueue_scripts', 'eas_product_addons_scripts');
add_action('wp_enqueue_scripts', 'eas_product_addon_script', 99);
add_action('init', 'eaw_i18n');

# plugin init function 
function eaw_i18n()
{
    load_plugin_textdomain('eaw', false, dirname(plugin_basename(EAW_WOO_FILE)) . '/i18n/');
}


# admin Enqueue scripts function css js
function eas_product_addons_scripts()
{
    wp_enqueue_script('eaw-custom-product-addons-js', EAW_WOO_URL . 'assets/js/custom-product-addons.js', array('jquery'), time(), true);
    wp_enqueue_style('eaw-admin-custom-product-css', EAW_WOO_URL . 'assets/css/admin-style.css', [], time());
}

# frontend Enqueue scripts function css js
function eas_product_addon_script()
{
    wp_enqueue_style('eaw-custom-product-front-css', EAW_WOO_URL . 'assets/css/style.css', [], time());
    wp_enqueue_script('eaw-front-product-addons-js', EAW_WOO_URL . 'assets/js/front-product-addons.js', array('jquery'), time(), true);
}

# woo add extra item before single cart item
function eaw_extra_item_fees_before_add_to_cart()
{
    global $product, $post;

    $eaw_extra_item_group       = get_post_meta($post->ID, 'eaw_extra_item_group', true);
    $eaw_accessories_item_group = get_post_meta($post->ID, 'eaw_accessories_item_group', true);
    $current_currency           = get_woocommerce_currency();

    $extraitem = array();

    if (is_array($eaw_extra_item_group) || is_object($eaw_extra_item_group)) {
        foreach ($eaw_extra_item_group as $key => $value) {
            $extraitem[$value['eaw_extra_item_price']]
                = $value['eaw_extra_item'] . "(+ " . $value['eaw_extra_item_price'] . $current_currency . ")";
        }
    }

    $args = array(
        'type'    => 'radio',
        'class'   => array('form-row-wide'),
        'options' => $extraitem,
        'default' => ''
    );

    $accitem = array();

    if (is_array($eaw_accessories_item_group) || is_object($eaw_accessories_item_group)) {
        foreach ($eaw_accessories_item_group as $key => $value) {
            $accitem[$value['eaw_accessories_item_price']]
                = $value['eaw_accessories_item'] . "(+" . $value['eaw_accessories_item_price'] . $current_currency . ")";
        }
    }

    $args_acc = array(
        'type'    => 'radio',
        'class'   => array('form-row-wide'),
        'options' => $accitem,
        'default' => '',
    );

    $eaw_acc_title  = get_post_meta($post->ID, 'eaw_acc_title', true);
    $eaw_item_title = get_post_meta($post->ID, 'eaw_item_title', true);
    $extra_item_fees_value  = '';
    if (isset($_POST['extra_item_fees'])) {
        $extra_item_fees_value = sanitize_text_field($_POST['extra_item_fees']);
    }
    $eaw_accessories_fees = '';
    if (isset($_POST['eaw_accessories_fees'])) {
        $eaw_accessories_fees = sanitize_text_field($_POST['eaw_accessories_fees']);
    }

?>
    <?php if (
        isset($eaw_extra_item_group) && !empty($eaw_extra_item_group)
        || isset($eaw_accessories_item_group) && !empty($eaw_accessories_item_group)
    ) { ?>

        <div class="custom-fees-wrap">
            <label for="iconic-engraving">
                <h2 class="eaw-wrap-title"><?php _e('Extra Item', 'eaw'); ?></h2>
            </label>

            <div class="eaw-accordions">
                <?php if (isset($eaw_extra_item_group) && !empty($eaw_extra_item_group)) { ?>
                    <div class="eaw_accordion_item">
                        <div class="eaw_title_tab">
                            <h3 class="title">
                                <?php echo esc_html($eaw_item_title); ?>
                                <span class="icon"></span>
                            </h3>
                        </div>
                        <div class="inner_content">
                            <?php woocommerce_form_field('extra_item_fees', $args, $extra_item_fees_value); ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if (isset($eaw_accessories_item_group) && !empty($eaw_accessories_item_group)) { ?>
                    <div class="eaw_accordion_item">
                        <div class="eaw_title_tab">
                            <h3 class="title">
                                <?php echo esc_html($eaw_acc_title); ?>
                                <span class="icon"></span>
                            </h3>
                        </div>
                        <div class="inner_content">
                            <?php woocommerce_form_field('eaw_accessories_fees', $args_acc, $eaw_accessories_fees); ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    <?php } ?>
<?php
}

add_action('woocommerce_before_add_to_cart_button', 'eaw_extra_item_fees_before_add_to_cart', 99);


# woo add extra value cart item function
function eaw_save_value_add_cart_item_data($cart_item_data, $product_id, $variation_id)
{
    $extra_item_fees        = filter_input(INPUT_POST, 'extra_item_fees');
    $eaw_accessories_fees   = filter_input(INPUT_POST, 'eaw_accessories_fees');

    if (empty($extra_item_fees) && empty($eaw_accessories_fees)) {
        return $cart_item_data;
    }

    if (!empty($extra_item_fees)) {
        $cart_item_data['extra_item_fees'] = $extra_item_fees;
    }

    if (!empty($eaw_accessories_fees)) {
        $cart_item_data['eaw_accessories_fees'] = $eaw_accessories_fees;
    }

    return $cart_item_data;
}

add_filter('woocommerce_add_cart_item_data', 'eaw_save_value_add_cart_item_data', 99, 3);

# woo cart calculate function
function eaw_calculate_add_cart_fee()
{
    global $woocommerce;
    $cart_items = $woocommerce->cart->get_cart();

    foreach ($cart_items as $key => $item) {

        if (isset($item['extra_item_fees']) && !empty($item['extra_item_fees'])) {
            $woocommerce->cart->add_fee(__('Extra Item Fees', 'eaw'), $item['extra_item_fees']);
        }

        if (isset($item['eaw_accessories_fees']) && !empty($item['eaw_accessories_fees'])) {
            $woocommerce->cart->add_fee(__('Accessories Fees', 'eaw'), $item['eaw_accessories_fees']);
        }
    }
}

add_action('woocommerce_cart_calculate_fees', 'eaw_calculate_add_cart_fee', 99);
add_action('admin_init', 'eaw_add_meta_boxe_init', 2);

# custom meta admin init
function eaw_add_meta_boxe_init()
{
    add_meta_box('eaw_extra_item_group', 'Extra Feature Item', 'eaw_extra_item_meta_box_func', 'product', 'normal', 'default');
    add_meta_box('eaw_accessories_item_group', 'Accessories Item', 'eaw_accessories_meta_box_func', 'product', 'normal', 'default');
}

function eaw_extra_item_meta_box_func()
{
    global $post;

    wp_nonce_field('eaw_extra_item_meta_box_nonce', 'eaw_extra_item_meta_box_nonce');

    $eaw_extra_item_group   = get_post_meta($post->ID, 'eaw_extra_item_group', true);
    $eaw_item_title         = get_post_meta($post->ID, 'eaw_item_title', true);

    include_once(EAW_WOO_PATH . 'metabox/extra-item-admin.php');
}

add_action('save_post', 'eaw_extra_item_meta_box_save');

# custom meta save function
function eaw_extra_item_meta_box_save($post_id)
{
    if (
        !isset($_POST['eaw_extra_item_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['eaw_extra_item_meta_box_nonce'], 'eaw_extra_item_meta_box_nonce')
    )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old_meta          = get_post_meta($post_id, 'eaw_extra_item_group', true);
    $new_meta          = array();
    $extra_items       = isset($_POST['eaw_extra_item']) ? $_POST['eaw_extra_item'] : '';
    $extra_items       = array_map('eaw_sanitize_input', $extra_items);
    $prices            = isset($_POST['eaw_extra_item_price']) ? array_map('intval', $_POST['eaw_extra_item_price']) : array();
    $count             = count($extra_items);

    for ($i = 0; $i < $count; $i++) {
        if ($extra_items[$i] != '') :
            $new_meta[$i]['eaw_extra_item'] = stripslashes(strip_tags($extra_items[$i]));
            $new_meta[$i]['eaw_extra_item_price'] = stripslashes($prices[$i]); # and however you want to sanitize
        endif;
    }

    if (!empty($new_meta) && $new_meta != $old_meta)
        update_post_meta($post_id, 'eaw_extra_item_group', $new_meta);
    elseif (empty($new_meta) && $old_meta)
        delete_post_meta($post_id, 'eaw_extra_item_group', $old_meta);

    $meta_key       = 'eaw_item_title';
    $eaw_item_title = sanitize_text_field($_POST['eaw_item_title']);

    update_post_meta($post_id, $meta_key, $eaw_item_title); # Update the post meta
}

# accessories meta box func
function eaw_accessories_meta_box_func()
{
    global $post;

    wp_nonce_field('eaw_accessories_meta_box_nonce', 'eaw_accessories_meta_box_nonce');

    $eaw_accessories_item_group = get_post_meta($post->ID, 'eaw_accessories_item_group', true);
    $eaw_acc_title              = get_post_meta($post->ID, 'eaw_acc_title', true);

    include_once(EAW_WOO_PATH . 'metabox/extra-accessories-item.php');
}

add_action('save_post', 'eaw_accessories_item_meta_box_save');

# accessories meta box saving func
function eaw_accessories_item_meta_box_save($post_id)
{
    if (
        !isset($_POST['eaw_accessories_meta_box_nonce']) ||
        !wp_verify_nonce($_POST['eaw_accessories_meta_box_nonce'], 'eaw_accessories_meta_box_nonce')
    )
        return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    if (!current_user_can('edit_post', $post_id))
        return;

    $old_meta          = get_post_meta($post_id, 'eaw_accessories_item_group', true);
    $new_meta          = array();
    $accessories_item  = isset($_POST['eaw_accessories_item']) ? $_POST['eaw_accessories_item'] : '';
    $accessories_item  = array_map('eaw_sanitize_input', $accessories_item);
    $prices            = isset($_POST['eaw_accessories_item_price']) ? array_map('intval', $_POST['eaw_accessories_item_price']) : array();
    $count             = sizeof($accessories_item);

    for ($i = 0; $i < $count; $i++) {

        if ($accessories_item[$i] != '') :
            $new_meta[$i]['eaw_accessories_item'] = stripslashes(strip_tags($accessories_item[$i]));
            $new_meta[$i]['eaw_accessories_item_price'] = stripslashes($prices[$i]); # and however you want to sanitize
        endif;
    }

    if (!empty($new_meta) && $new_meta != $old_meta)
        update_post_meta($post_id, 'eaw_accessories_item_group', $new_meta);
    elseif (empty($new_meta) && $old_meta)
        delete_post_meta($post_id, 'eaw_accessories_item_group', $old_meta);


    $meta_key       = 'eaw_acc_title';
    $eaw_acc_title  = sanitize_text_field($_POST['eaw_acc_title']);

    update_post_meta($post_id, $meta_key, $eaw_acc_title);  # Update the post meta
}

function eaw_sanitize_input($input)
{
    return strip_tags($input); // You can customize the sanitization method as needed
}


?>