<?php
    $video = ae_get_option('header_video');
    $fall_back = ae_get_option('header_video_fallback');
?>
<!-- SLIDER -->

<div id="video-background-wrapper" class="covervid-wrapper" style="width:100%;height:800px;position:relative;background: url(<?php echo $fall_back; ?>) no-repeat center center; background-size :cover;" >
    <div class="bg-sub-wrapper">
        <div class="bg-color-wrapper">
            <?php
                if(!is_user_logged_in()){
                    get_template_part('head/nologin', 'demonstration');
                }else{
                    if( ae_user_role() == FREELANCER ) {
                        get_template_part('head/freelancer', 'demonstration');
                    }else {
                        get_template_part('head/employer', 'demonstration');
                    }
                }
            ?>
        </div>
    </div>
</div>
<!-- SLIDER / END -->

<?php