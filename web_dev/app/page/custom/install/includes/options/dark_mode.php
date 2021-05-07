<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="sidebar_title"><?php echo $options['language'] == 'EN' ? 'Dark Mode - Default' : 'Тёмный режим - По умолчанию'?></div>
    <form enctype="multipart/form-data" method="post">
        <div class="sidebar_left">
            <button type="submit" name="dark_mode_on">
                <div class="sidebar_eng_img"><img src="../../../../app/page/custom/install/img/dark_mode_on.png"></div>
                <div class="sidebar_name"><?php echo $options['language'] == 'EN' ? 'On' : 'Включен'?></div></button>
        </div>
        <div class="sidebar_right">
            <button type="submit" name="dark_mode_off">
                <div class="sidebar_rus_img"><img src="../../../../app/page/custom/install/img/dark_mode_off.png"></div>
                <div class="sidebar_name"><?php echo $options['language'] == 'EN' ? 'Off' : 'Выключен'?></div></button>
        </div>
    </form>
</div>