<?php
/**
 * Template part for displaying about section
 *
 * @package Laboratory Pharmacy Store
 * @subpackage laboratory_pharmacy_store
 */

?>

<section id="abt-product" class="py-5">
  <div class="container">
    <?php if( get_theme_mod( 'laboratory_pharmacy_store_about_title' ) != '') { ?>
      <h3 class="mb-5"><?php echo esc_html( get_theme_mod('laboratory_pharmacy_store_about_title','')); ?></h3>
    <?php } ?>
    <div class="row">
      <?php
        $laboratory_pharmacy_store_product_cat = get_theme_mod('laboratory_pharmacy_store_best_product_category');
        if ( class_exists( 'WooCommerce' ) ) {
        $laboratory_pharmacy_store_args = array(
          'post_type' => 'product',
          'posts_per_page' => 20,
          'product_cat' => $laboratory_pharmacy_store_product_cat,
          'order' => 'ASC'
        );?>
        <?php $loop = new WP_Query( $laboratory_pharmacy_store_args );
        while ( $loop->have_posts() ) : $loop->the_post(); global $product; ?>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="product-details mb-4">
              <div class="product-img">
                <?php if (has_post_thumbnail( $loop->post->ID )) echo get_the_post_thumbnail($loop->post->ID, ''); else echo '<img src="'.esc_url(wc_placeholder_img_src()).'" />'; ?>
              </div>
              <div class="product-content">
                <div class="row">
                  <div class="col-lg-8 col-md-8 col-sm-8 col-8 align-self-center">
                    <h5><a href="<?php echo esc_url(get_permalink( $loop->post->ID )); ?>"><?php the_title(); ?></a></h5>
                    <?php if( $product->is_type( 'simple' ) ){ woocommerce_template_loop_rating( $loop->post, $product ); } ?>
                  </div>
                  <div class="col-md-4 col-md-4 col-sm-4 col-4 align-self-center pl-0">
                    <span><?php esc_attr( apply_filters( 'woocommerce_product_price_class', '' ) ); ?><?php echo $product->get_price_html(); ?></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endwhile; wp_reset_query(); ?>
      <?php } ?>
    </div>
  </div>
</section>
