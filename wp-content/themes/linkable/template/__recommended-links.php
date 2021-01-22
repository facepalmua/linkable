<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access!' );
} ?>
<div class="payment-row">
    <div class="col project-header text-uppercase">Domain</div>
    <div class="col project-header text-uppercase cur-pointer laSortBy <?= @$order_da; ?>" data-sort="da">Domain Authority <span class="fa fa-sort"></span></div>
    <div class="col project-header text-uppercase">Average Cost</div>
    <div class="col project-header text-uppercase cur-pointer laSortBy  <?= @$order_ind; ?>" data-sort="industry">Industry <span class="fa fa-sort"></span></div>
    <div class="col project-header text-uppercase">Connect with the author</div>
</div>
<?php
if( ! isset($project_id) ) {
	global $project_id;
}
if( !isset( $links ) ) {
	$links = la_get_client_recommended_links($project_id, '');
}

if ( count( $links ) > 0 ) {
    foreach ( $links as $link ) {
        $url    = $link->post_title;
        $domain = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );
        $da = $link->da;
        if ( empty( $da ) ) {
            $da = '--';
        }
        // $price = get_post_meta( $link->ID, 'la_price_range', true );
	    $price = get_pricing_from_da ( $da, $url, 'DoFollow' );
        $range = '--';
        if ( ! empty( $price['owner_price'] ) ) {
            $differ     = ( $price['owner_price'] * 10 ) / 100;
            $high_price = number_format( $price['owner_price'] + $differ, 0 );
            $low_price  = number_format( $price['owner_price'] - $differ, 0 );
            $range      = '$' . $low_price . ' - $' . $high_price;
        }
        $cats     = wp_get_post_terms( $link->ID, 'industry' );
        $cat_name = @$cats[0]->name;
        if ( empty( $cat_name ) ) {
            $cat_name = '--';
        }
        $new_label = ' <span class="label label-success">NEW!</span>';
        $current_user = get_current_user_id();
        $seen_list = get_post_meta( $link->ID, 'la_link_seen_by', true );
        if( is_array( $seen_list ) && in_array( $current_user, $seen_list ) ) {
            $new_label = '';
        } else {
            if( ! is_array( $seen_list ) ) {
                $seen_list = [ $current_user ];
            } else {
                array_push( $seen_list, $current_user );
            }
            update_post_meta( $link->ID, 'la_link_seen_by', $seen_list);
        }
        ?>
        <div class="payment-row"
             data-site="<?= $link->ID; ?>">
            <div class="col">
                <p class="green text-uppercase margin-bottom-0 laSiteName click-to-copy-wrapper"
                   data-value="<?= $url; ?>">
                    <span class="click-to-copy"><?= $domain; ?></span><?= $new_label; ?>
                </p>
            </div>
            <div class="col"><?= $da ?></div>
            <div class="col"><?= $range ?></div>
            <div class="col text-uppercase laIndustryId"
                 data-value="<?= @$cats[0]->term_id; ?>"><?= $cat_name; ?></div>
            <div class="col">
                <a href="javascript:void(0);" data-project="<?= $project_id; ?>" data-domain="<?= $domain; ?>"
                   class="text-uppercase laMessageAuthor"><i
                            class="fa fa-edit green"></i>
                    <strong><span class="green">Message Author</span></strong></a>
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <div class="payment-row">
        <div class="col">
            <p class="text-center"
               style="margin-top: 20px;">We have not added any recommended links to your project yet. Make sure you have an active project posted.</p>
        </div>
    </div>
    <?php
}