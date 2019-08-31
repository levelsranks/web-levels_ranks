<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="webkey_title"><?php echo $options['language'] == 'EN' ? 'Servers Info' : 'Информация о серверах'?></div>
    <form enctype="multipart/form-data" method="post">
        <div class="webkey_form">
            <div class="webkey_input">
                <div class="input-form">
                    <div class="input_text">
                        <div class="info"><?php echo $options['language'] == 'EN' ? 'Short Name' : 'Короткое название'?></div>
                        <input name="servers_name" value="" placeholder="<?php echo $options['language'] == 'EN' ? 'Waffle' : 'Вафелька'?>" required>
                    </div>
                </div>
                <div class="input-form">
                    <div class="input_text">
                        <div class="info"><?php echo $options['language'] == 'EN' ? 'Full Name' : 'Полное название'?></div>
                        <input name="servers_full_name" value="" placeholder="<?php echo $options['language'] == 'EN' ? 'Game Server Network - Waffle' : 'Сеть игровых серверов - Вафелька'?>" required>

                    </div>
                </div>
                <div class="input-form">
                    <div class="input_text">
                        <div class="info"><?php echo $options['language'] == 'EN' ? 'Info' : 'Описание'?></div>
                        <div class="servers_info">
                            <input name="servers_info" value="" placeholder="<?php echo $options['language'] == 'EN' ? 'The best CS:S and CS:GO game server network with huge online and top admins!' : 'Лучшая сеть игровых серверов по CS:S и CS:GO с огромным онлайном и лучшими админами!'?>" required>
                        </div>
                    </div>
                </div>
            </div>
            <div class="webkey_btn_check"><input class='btn' name="servers_info_save" type="submit" value="<?php echo $options['language'] == 'EN' ? 'Save' : 'Сохранить'?>"></div>
        </div>
    </form>
</div>