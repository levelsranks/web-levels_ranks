<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="sidebar_title"><?php echo $options['language'] == 'EN' ? 'Database setup' : 'Настройка базы данных'?></div>
    <form enctype="multipart/form-data" method="post">
        <div class="db_left">
            <div class="input-form">
                <div class="input_text">
                    <div class="info">HOST</div>
                    <input name="HOST" value="" placeholder="133.7.22.8" required>
                </div>
            </div>
            <div class="input-form">
                <div class="input_text">
                    <div class="info">USER</div>
                    <input name="USER" value="" placeholder="rootyra" required>
                </div>
            </div>
            <div class="input-form">
                <div class="input_text">
                    <div class="info">DATABASE</div>
                    <input name="DATABASE" value="" placeholder="ocgn" required>
                </div>
            </div>
            <div class="input-form">
                <div class="input_text">
                    <div class="info">PORT</div>
                    <input name="PORT" value="3306" placeholder="3306" required>
                </div>
            </div>
            <div class="input-form">
                <div class="input_text">
                    <div class="info">PASS</div>
                    <input name="PASS" value="" placeholder="ququlolkek" required>
                </div>
            </div>
            <div class="input-form">
                <div class="input_text">
                    <div class="info">TABLE</div>
                    <input name="TABLE" value="" placeholder="lvl_base" required>
                </div>
            </div>
            <div class="input-form">
                <div class="input_text">
                    <div class="info"><?php echo $options['language'] == 'EN' ? 'Server Name' : 'Название сервера'?></div>
                    <input name="NAME" value="" placeholder="<?php echo $options['language'] == 'EN' ? 'KNIFE | GLOVES | ANIME' : 'НОЖИ | ПЕРЧАТКИ | АНИМЕ'?>" required>
                </div>
            </div>
            <div class="input-form"><div class="input_text">Game mode</div>
                <select name="game_mod">
                    <option value="csgo">CS:GO</option>
                    <option value="css">CS:S</option>
                </select>
            </div>
            <div class="input-form"><div class="input_text">Steam mode</div>
                <select name="steam_mod">
                    <option value="1">Only Steam</option>
                    <option value="0">No Steam</option>
                </select>
            </div>
            <div class="check"><input class='btn' name="db_check" type="submit" value="<?php echo $options['language'] == 'EN' ? 'Check' : 'Проверить'?>"></div>
        </div>
        <div class="db_right">
                <img src="../../../../app/page/custom/install/img/db.png">
                <div class="sidebar_name"><?php echo $options['language'] == 'EN' ? 'Take data from' : 'Данные брать из'?> databases.cfg</div>
                <?php if( ! empty( $db_check ) && $db_check == 1):?><div class="sidebar_name ERROR"><?php echo $options['language'] == 'EN' ? 'CONNECT ERROR' : 'НЕТУ ПОДКЛЮЧЕНИЯ К ВАШЕЙ БАЗЕ ИЛИ НЕТУ ТАБЛИЦЫ'?></div><?php endif?>
        </div>
    </form>
</div>