<?php
/**
 * Displays footer site info
 *
 * @package Laboratory Pharmacy Store
 * @subpackage laboratory_pharmacy_store
 */

?>
<div class="site-info">
    <div class="container">
        <p><?php laboratory_pharmacy_store_credit();?> <?php echo esc_html(get_theme_mod('online_pharmacy_footer_text',__('By Themespride','laboratory-pharmacy-store'))); ?></p>
    </div>
</div>
