<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="sidebar_title"><?php echo $options['language'] == 'EN' ? 'Block Edges - Default' : 'Края блоков - По умолчанию'?></div>
    <form enctype="multipart/form-data" method="post">
        <div class="sidebar_left">
            <button type="submit" name="form_border_0">
                <div class="sidebar_eng_img"><img src="../../../../app/page/custom/install/img/form_border_0.png"></div>
                <div class="sidebar_name"><?php echo $options['language'] == 'EN' ? '90 degrees' : '90 градусов'?></div></button>
        </div>
        <div class="sidebar_right">
            <button type="submit" name="form_border_1">
                <div class="sidebar_rus_img"><img src="../../../../app/page/custom/install/img/form_border_1.png"></div>
                <div class="sidebar_name"><?php echo $options['language'] == 'EN' ? 'Rounded' : 'Закругленные'?></div></button>
        </div>
    </form>
</div>