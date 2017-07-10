<?php
/*
Plugin Name: Google Analytics Scripts Vollick
Description: Place to add custom google analytic scripts
Version: 1.0
*/
function load_in_head_beginning () {
?>
<!-- Script tag goes below here  -->
<script type="text/javascript">
  console.log('beginning of head');
</script>
<!-- End sCript -->
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
    <script type="text/javascript">
      console.log('opening body');
    </script>
    <!-- End script -->
    <?php
  }
  add_action ('storefront_before_header', 'load_after_body_opening', 1);
}
