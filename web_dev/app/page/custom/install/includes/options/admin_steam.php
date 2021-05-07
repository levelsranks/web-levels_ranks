<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="webkey_title"><?php echo $options['language'] == 'EN' ? 'Administrator' : 'Администратор'?></div>
    <?php if ( empty( $data['avatar'] ) ):?>
    <form enctype="multipart/form-data" method="post">
        <div class="webkey_form">
            <div class="webkey_input">
                <div class="input-form">
                    <div class="input_text">
                        <input name="admin" value="" placeholder="STEAM_1:1:39075162">
                    </div>
                </div>
            </div>
            <div class="webkey_btn_check"><input class='btn' name="check_admin_steam" type="submit" value="<?php echo $options['language'] == 'EN' ? 'Check' : 'Проверить'?>"></div>
        </div>
    </form>
    <?php else:?>
    <form enctype="multipart/form-data" method="post">
        <div class="webkey_form">
            <div class="admin_zone">
                <img src="<?php echo $data['avatarfull']?>">
                <div class="admin_name"><?php echo $data['personaname']?></div>
            <div class="admin_que">
                <div class="admin_text"><?php echo $options['language'] == 'EN' ? 'It is you?' : 'Это вы?'?></div>
                <div class="admin_yes"><input class='btn' name="check_admin_steam_da" type="submit" value="<?php echo $options['language'] == 'EN' ? 'Yes' : 'Да'?>"></div>
                <div class="admin_no"><input class='btn' name="check_admin_steam_net" type="submit" value="<?php echo $options['language'] == 'EN' ? 'No' : 'Нет'?>"></div>
            </div>
            </div>
        </div>
    </form>
    <?php endif?>
</div>