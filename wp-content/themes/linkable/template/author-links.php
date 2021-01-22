<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct access!' );
}
$links = get_posts(array(
	'post_type'     => 'build-links',
	'post_status'   => 'publish',
	'posts_per_page'=> -1,
	'author'   => get_current_user_id()
));
?>
<div class="payment-row">
	<div class="col project-header text-uppercase">Site</div>
	<div class="col project-header text-uppercase">Domain Authority</div>
	<div class="col project-header text-uppercase">Average Cost</div>
	<div class="col project-header text-uppercase">Industry</div>
	<div class="col project-header text-uppercase">Manage</div>
</div>
<?php
if( count( $links ) > 0 ) {
	foreach ( $links as $link ) {
		$url = $link->post_title;
		$domain = str_ireplace('www.', '', parse_url($url, PHP_URL_HOST));
		$da = get_post_meta( $link->ID, 'la_domain_authority', true );
		if(empty( $da ) ) $da = '--';
		// $price = get_post_meta( $link->ID, 'la_price_range', true );
		$price = get_pricing_from_da ( $da, $url, 'DoFollow' );
		$range = '--';
		if( ! empty( $price['owner_price'] ) ) {
		    $differ = ( $price['owner_price'] * 10 ) / 100;
		    $high_price = number_format( $price['owner_price'] + $differ, 0 );
		    $low_price = number_format( $price['owner_price'] - $differ, 0 );
		    $range = '$'. $low_price . ' - $' . $high_price;
        }
		$cats = wp_get_post_terms( $link->ID, 'industry' );
		$cat_name = @$cats[0]->name;
		if( empty( $cat_name) ) $cat_name = '--';
		?>
		<div class="payment-row" data-site="<?= $link->ID; ?>">
			<div class="col">
				<p class="green text-uppercase margin-bottom-0 laSiteName click-to-copy-wrapper" data-value="<?= $url; ?>">
                    <span class="click-to-copy"><?= $domain; ?></span>
                </p>
			</div>
			<div class="col"><?= $da ?></div>
			<div class="col"><?= $range ?></div>
			<div class="col text-uppercase laIndustryId" data-value="<?= @$cats[0]->term_id; ?>"><span><?= $cat_name; ?></span></div>
			<div class="col">
				<a href="javascript:void(0);" class="btn laEditSite"><i class="fa fa-pencil green"></i></a>
				<a href="javascript:void(0);" class="btn red-text laDeleteSite"><i class="fa fa-trash"></i></a>
			</div>
		</div>
		<?php
	}
} else {
	?>
	<div class="payment-row">
		<div class="col">
			<p class="text-center" style="margin-top: 20px;">You have not added any sites yet! Please list all the sites you can build a backlink on.</p>
		</div>
	</div>
	<?php
}