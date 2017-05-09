<?php
function my_theme_enqueue_styles() {
    $parent_style = 'Integral-style'; // This is 'e-commerce-style' for the Integral theme.
    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/bootstrap.css' );
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/bootstrap.min.css' );
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/flexslider.css' );
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/font-awesome.css' );
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/font-awesome.min.css' );
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/multi-columns-row.css' );
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/prettyPhoto.css' );
	wp_enqueue_style( $parent_style, get_template_directory_uri() . '/css/widgets.css' );
	//wp_enqueue_style( 'flex', get_stylesheet_directory_uri() . '/css/flex.css' );
	wp_enqueue_style( 'flex', get_stylesheet_directory_uri() . '/css/flex_STRUCTURED.css' );
	//wp_enqueue_style( 'jQueryMobileStyle', get_stylesheet_directory_uri() . '/css/jquery.mobile-1.4.5.min.css' );
	wp_enqueue_script( 'jQueryMobile', get_stylesheet_directory_uri() . '/js/ClickTest.js');
	wp_enqueue_script("jquery");
}
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles', 10);

function wpb_add_google_fonts() {
	wp_enqueue_style( 'wpb-google-fonts', '//fonts.googleapis.com/css?family=Alef', false );
}
add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );

add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment'); /* ~~~~~~ Allows shopping cart details to update after removing items from the cart page. ~~~~~~~~ */

function woocommerce_header_add_to_cart_fragment( $fragments ) 
{
    global $woocommerce;
    ob_start(); ?> 

	<a id="cart-contents" href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>">
		<span id="cart-icon" class="non-empty"><i class="fa fa-shopping-cart" aria-hidden="true"></i></span>
		<span id="subtotal"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span>
		<span id="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'e-commerce' ), WC()->cart->get_cart_contents_count() ) );?></span>
	</a>
    <?php
    $fragments['a#cart-contents'] = ob_get_clean();
    return $fragments;
}

add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );
/**
 * woo_hide_page_title
 *
 * Removes the "shop" title on the main shop page
 *
 * @access      public
 * @since       1.0 
 * @return      void
*/
function woo_hide_page_title() {
	
	return false;
	
}

/**
 * Adds Quantity input field next to "Add to Cart" button on WooCommerce shop page ~~~~~~~~~~ Added 23/02/17.
 */
add_filter( 'woocommerce_loop_add_to_cart_link', 'quantity_inputs_for_woocommerce_loop_add_to_cart_link', 10, 2 );
function quantity_inputs_for_woocommerce_loop_add_to_cart_link( $html, $product ) {
	if ( $product && $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() && ! $product->is_sold_individually() ) {
		$html = '<form action="' . esc_url( $product->add_to_cart_url() ) . '" class="cart" method="post" enctype="multipart/form-data">';
		$html .= woocommerce_quantity_input( array(), $product, false );
		$html .= '<button type="submit" class="button alt">' . esc_html( $product->add_to_cart_text() ) . '</button>';
		$html .= '</form>';
	}
	return $html;
}

/**
 * Adds back button to single-prouct page. ~~~~~~~~~~ Added 23/02/17 AM.
 */
add_action( 'woocommerce_before_single_product', 'woocommerce_single_product_summary_button', 11);

function woocommerce_single_product_summary_button() {
	$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
	echo '<div id="shop-back">
		       <a class="back_button" href="' . $shop_page_url . '">Back to All Products</a>
		  </div>';
}

// Display 24 products per page. Goes in functions.php
add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

//add_filter( 'wp_nav_menu_items', 'add_loginout_link', 10, 2 );

function add_loginout_link( $items, $args ) {

	if (is_user_logged_in() && $args->theme_location == 'primary') {
		$items .= '<li><a href="'. wp_logout_url() .'">Log Out</a></li>';
	}

	elseif (!is_user_logged_in() && $args->theme_location == 'primary') {
		$items .= '<li><a href="'. site_url('wp-login.php') .'">Log In</a></li>';
	}

   return $items;
}

add_filter( 'lostpassword_url', 'my_lost_password_page', 10, 2 );
function my_lost_password_page( $lostpassword_url, $redirect ) {
    return home_url( '/lostpassword/?redirect_to=' . $redirect );
}

// Change the "add to cart" buttton text on Woocommerce single product pages.
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woo_custom_cart_button_text' );    // 2.1 +
 
function woo_custom_cart_button_text() {
 
        return __( 'Request Product', 'woocommerce' );
 
}

//Change the "add to cart" button text on Woocommerce product archives.
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );    // 2.1 +
 
function woo_archive_custom_cart_button_text() {
 
        return __( 'Request Product', 'woocommerce' );
 
}

//Change the "Proceed to Checkout" button text on the Woocommerce cart page.
function woocommerce_button_proceed_to_checkout() {
       $checkout_url = WC()->cart->get_checkout_url();
       ?>
       <a href="<?php echo $checkout_url; ?>" class="checkout-button button alt wc-forward"><?php _e( 'Proceed to Billing and Shipping', 'woocommerce' ); ?></a>
       <?php
}

// Change the "Place Order" button text on the Woocommerce checkout page.
add_filter( 'woocommerce_order_button_text', 'woo_custom_order_button_text' ); 

function woo_custom_order_button_text() {
    return __( 'Enquire', 'woocommerce' ); 
}

// Change the "add to cart" woocommerce message text.
add_filter('wc_add_to_cart_message', 'handler_function_name', 10, 2);
function handler_function_name($message, $product_id) {
//    return $product_id . "added to enquiry list.";
}

add_filter('add_to_cart_redirect', 'themeprefix_add_to_cart_redirect');
function themeprefix_add_to_cart_redirect() {
 global $woocommerce;
 $checkout_url = $woocommerce->cart->get_checkout_url();
 return $checkout_url;
}

?>