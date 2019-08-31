<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="sidebar_title"><?php echo $options['language'] == 'EN' ? 'Animations - Default' : 'Анимации - По умолчанию'?></div>
    <form enctype="multipart/form-data" method="post">
        <div class="sidebar_left">
            <button type="submit" name="animations_on">
                <div class="animation_mp4">
                    <video loop="" muted="" autoplay="">
                        <source src="../../../../app/page/custom/install/img/sidebar_anim.mp4" type="video/webm">
                    </video>
                </div>
                <div class="sidebar_name"><?php echo $options['language'] == 'EN' ? 'On' : 'Включены'?></div></button>
        </div>
        <div class="sidebar_right">
            <button type="submit" name="animations_off">
                <div class="animation_mp4">
                    <video loop="" muted="" autoplay="">
                        <source src="../../../../app/page/custom/install/img/sidebar_no_anim.mp4" type="video/webm">
                    </video>
                </div>
                <div class="sidebar_name"><?php echo $options['language'] == 'EN' ? 'Off' : 'Выключены'?></div></button>
        </div>
    </form>
</div>