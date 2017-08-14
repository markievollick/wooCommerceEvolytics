<?php
/*
Plugin Name: Google Analytics Scripts Vollick
Description: Place to add custom google analytic scripts
Version: 1.0
*/
function load_in_head_beginning () {
?>
<!-- Data layer -->

<!-- Script tag goes below here  THIS SECTION IS INPUTED AT THE BEGINNING OF THE HEAD -->
<script type="text/javascript">
  // Search bar
  // (function ($){
      // loads when doc has loaded
      // $(document).ready(function () {
        var url = window.location.href;
        console.log('url= ' + url);

        if (url.indexOf('?s=') >= 0) {
          var itemName = url.substring(url.lastIndexOf('?s=') + 3, url.lastIndexOf('&'));
          window.dataLayer = window.dataLayer || [];
          dataLayer.push({
            'event': 'searchedTerm',
            'eventCategory': 'searchBar',
            'eventAction': 'searchedTerm',
            'eventLabel': itemName
          });
        }
      // });
  // })(jQuery);
</script>
<!-- End script -->
<?php
}
add_action('wp_head', 'load_in_head_beginning', 1);

function load_in_head_ending () {
?>
<!-- Script tag goes below here  -->
<script type="text/javascript">
  console.log('end of head');
</script>
<!-- End script -->
<?php
}
add_action('wp_head', 'load_in_head_ending', 500);
/**
 * Proper way to enqueue scripts and styles.
 */
function custom_ga_scripts () {
    // wp_enqueue_style( 'style-name', get_stylesheet_uri() );
    wp_enqueue_script( 'main-ga-js', plugin_dir_url( __FILE__ ) . 'scripts/main.js', array('jquery'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'custom_ga_scripts' );

if ( !function_exists('load_after_body_opening')) {
  function load_after_body_opening () {
    ?>
    <!-- Script to load after <body> goes below here  -->

    <?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>

    <!-- Data Layer testing
    self contained function that loads jquery as $ param.  -->
    <script type="text/javascript">

    //To see if the user is logged in
    (function ($){
        // loads when doc has loaded
        $(document).ready(function () {
          var numberOfSessions = 0;
          <?php if ( is_user_logged_in() ) { ?>
            console.log('user is logged in');
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
              'event': 'trackUserLogin',
              'eventCategory': 'trackUserLogin',
          		'eventAction': 'true',
          	});
          <?php } else { ?>
            console.log('user is not logged in');
            window.dataLayer = window.dataLayer || [];
            dataLayer.push({
              'event': 'trackUserLogin',
              'eventCategory': 'trackUserLogin',
          		'eventAction': 'false',
          	});
          <?php } ?>
        });
    })(jQuery);

    // Add item to cart event
    (function ($){
        // loads when doc has loaded
        $(document).ready(function () {
            // could target by button class or id?
            $('.add_to_cart_button').on('click', function () {
                // custom data layer stuff?
                window.dataLayer = window.dataLayer || [];
                dataLayer.push({
                  'event': 'gtm4wp.addProductToCart',
                  'eventCategory': 'add_to_cart'
                });
                console.log($(this).innerText);
            });
        });
    })(jQuery);


    // Viewed product detail event
    // (function ($) {
    //   $(document).ready(function () {
          // bind click event to each product's remove tag.
          // $this.find('.woocommerce-LoopProduct-link').on('click', function (event) {
          //   var $products = $('.woocommerce-loop-product__title');
          //   $products.each(function (i) {
          //     var $this = $(this);
          //     var $productName = $this.find('.woocommerce-loop-product__title')[i].innerText;
          //   });
          //
          //   var $price = $this.find('.woocommerce-LoopProduct-link .price').innerText;
          //
          //
          //   dataLayer.push({
          //     'event': 'view_product_detail',
          //     'eventCategory': 'viewProductDetail',
          //     'eventAction': 'clickedProduct',
          //     //'eventLabel': $product[0].innerText //need to fix this - not returning wanted value
          //   });
          // });
    //   });
    // })(jQuery);

    // Viewed product category page
    // (function ($){
    //     // loads when doc has loaded
    //     $(document).ready(function () {
    //       var $this = $(this);
    //       <?php if ( is_product_category() ) { ?> //conditional tag from woocommerce
    //         console.log('user is viewing category');
    //         window.dataLayer = window.dataLayer || [];
    //         dataLayer.push({
    //           'event': 'productCategoryViewed',
    //           'eventCategory': 'productCategoryViewed',
    //       	});
    //       <?php } ?>
    //     });
    // })(jQuery);


    </script>
    <!-- End script -->
    <?php
  }
  add_action ('storefront_before_header', 'load_after_body_opening', 1);
}
