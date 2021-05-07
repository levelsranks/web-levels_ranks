<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="sidebar_title"><?php echo $options['language'] == 'EN' ? 'Database setup' : 'Настройка базы данных'?></div>
    <form enctype="multipart/form-data" method="post">
        <div class="db_left">
            <div class="input-form"><div class="input_text">Статистика</div>
                <select name="STATS">
                    <option value="LevelsRanks">Levels Ranks</option>
                    <option value="FPS">Fire Players Stats</option>
                    <option value="RankMeKento">RankMe Kento</option>
                </select>
            </div>
            <div class="input-form"><div class="input_text">HOST</div><input name="HOST" value="<?php ! empty( $_POST['HOST'] ) && print $_POST['HOST']?>" required></div>
            <div class="input-form"><div class="input_text">USER</div><input name="USER" value="<?php ! empty( $_POST['USER'] ) && print $_POST['USER']?>" required></div>
            <div class="input-form"><div class="input_text">DATABASE</div><input name="DATABASE" value="<?php ! empty( $_POST['DATABASE'] ) && print $_POST['DATABASE']?>" required></div>
            <div class="input-form"><div class="input_text">PORT</div><input name="PORT" value="3306" required></div>
            <div class="input-form"><div class="input_text">PASS</div><input type="password" name="PASS" value="<?php ! empty( $_POST['PASS'] ) && print $_POST['PASS']?>" required></div>
            <div class="input-form"><div class="input_text">TABLE</div><input name="TABLE" value="<?php ! empty( $_POST['TABLE'] ) && print $_POST['TABLE']?>" placeholder="Если вы не меняли название таблицы, оставьте поле пустым, пожалуйста"></div>
            <div class="input-form"><div class="input_text"><?php echo $options['language'] == 'EN' ? 'Server Name' : 'Название сервера'?></div><input name="NAME" value="<?php ! empty( $_POST['NAME'] ) && print $_POST['NAME']?>" placeholder="<?php echo $options['language'] == 'EN' ? 'KNIFE | GLOVES | ANIME' : 'НОЖИ | ПЕРЧАТКИ | АНИМЕ'?>"></div>
            <div class="input-form"><div class="input_text">Game mode</div>
                <select name="game_mod">
                    <option value="730">CS:GO</option>
                    <option value="240">CS:S</option>
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
                <img src="app/page/custom/install/img/db.png">
                <div class="sidebar_name"><?php echo $options['language'] == 'EN' ? 'Take data from' : 'Данные брать из'?> databases.cfg</div>
                <?php if( ! empty( $db_check ) && $db_check == 1):?><div class="sidebar_name ERROR"><?php echo $options['language'] == 'EN' ? 'CONNECT ERROR' : 'НЕТУ ПОДКЛЮЧЕНИЯ К ВАШЕЙ БАЗЕ ИЛИ НЕТУ ТАБЛИЦЫ'?></div><?php endif?>
        </div>
    </form>
</div>