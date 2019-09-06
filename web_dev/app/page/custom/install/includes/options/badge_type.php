<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="sidebar_title"><?php echo $options['language'] == 'EN' ? 'Badges - Default' : 'Бэйджи - По умолчанию'?></div>
    <form enctype="multipart/form-data" method="post">
        <div class="sidebar_left">
            <button type="submit" name="badge_type_1">
                <div class="badge_1"><?php echo $options['language'] == 'EN' ? 'I want it like this' : 'Хочу вот так'?></div></button>
        </div>
        <div class="sidebar_right">
            <button type="submit" name="badge_type_2">
                <div class="badge_2"><?php echo $options['language'] == 'EN' ? 'No, I want it like this' : 'Нет, хочу вот так'?></div></button>
        </div>
    </form>
</div>