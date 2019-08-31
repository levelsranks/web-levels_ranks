<?php ! defined("IN_LR") && die()?>
<div class="back">
    <div class="sidebar_title">Настройка базы данных</div>
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
                    <div class="info">Название сервера</div>
                    <input name="NAME" value="" placeholder="НОЖИ | ПЕРЧАТКИ | АНИМЕ" required>
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
            <div class="check"><input class='btn' name="db_check" type="submit" value="Проверить"></div>
        </div>
        <div class="db_right">
                <img src="../../../../app/page/custom/install/img/db.png">
                <div class="sidebar_name">Данные брать из databases.cfg</div>
                <?php if( ! empty( $db_check ) && $db_check == 1):?><div class="sidebar_name ERROR">НЕТУ ПОДКЛЮЧЕНИЯ К ВАШЕЙ БАЗЕ ИЛИ НЕТУ ТАБЛИЦЫ</div><?php endif?>
        </div>
    </form>
</div>