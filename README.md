<p align="center">
        <img height="250px" src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/master/.github/logo.png"/>
</p>
<h1 align="center">
    Levels Ranks - WEB Interface
</h1>
Пользовательский WEB интерфейс для взаимодействием с плагином статистики <a href="https://github.com/levelsranks/levels-ranks-core">Levels Ranks</a>.

-----
<p align="center">
        <img height="43px" src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/master/.github/just_themes.png"/>
</p>
<p align="center">
        <img height="560px" src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/master/.github/interface.png"/>
</p>
<p align="center">
        <img height="43px"src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/master/.github/full_adaptation.png"/>
</p>
<p align="center">
        <img height="880px"src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/master/.github/profile.png"/>
</p>

-----

```
640K ought to be enough for anybody
```

Требования:
-----

- Обязательно:
  - PHP 7.0 и выше.
  - Поддержка PHP PDO.
  - Поддержка PHP GMP.
- Рекомендуется:
  - MySQL 5.7 или MariaDB 10.1 и выше.

Установка:
-----

- Скачать stable ( Рекомендуется ) или dev релиз Levels Ranks WEB.
- Извлечь файлы из архива и переместить их в любой каталог на вашем домене или субдомене.
- Перейти на ваш сайт с извлеченной Levels Ranks WEB и пройти процесс установки.
- Profit!

Детальная настройка базы данных:
-----

- Файл и директория - **/storage/cache/sessions/db.php**


<details><summary>Основной шаблон</summary>

```
array ('LevelsRanks' => 
      array (0 => 
            array (
                  'HOST' => 'Ваш хост',
                  'USER' => 'Логин',
                  'PASS' => 'Пароль',
                  'DB'   => array (0 => 
                                   array (
                                         'DB'     => 'Имя основной базы данных',
                                         'Prefix' => array (0 => 
                                                            array (
                                                                  'table' => 'Название таблицы ( lvl_base )',
                                                                  'name'  => 'Название ( Основной AWP сервер )',
                                                                  'mod' => 'CSGO / CSS',
                                                                  ),
                                                           ),
                                         ),
                                  ),
                  ),
            ),
      );
```
</details>

<details><summary>Если вы используете две и более таблиц в одной базе данных</summary>

```
array ('LevelsRanks' => 
      array (0 => 
            array (
                  'HOST' => 'Ваш хост',
                  'USER' => 'Логин',
                  'PASS' => 'Пароль',
                  'DB'   => array (0 => 
                                   array (
                                         'DB'     => 'Имя основной базы данных',
                                         'Prefix' => array (0 => 
                                                            array (
                                                                  'table' => 'Название таблицы ( lvl_base )',
                                                                  'name'  => 'Название ( Основной AWP сервер )',
                                                                  'mod' => 'CSGO / CSS',
                                                                  ),
                                                            array (
                                                                  'table' => 'Название таблицы 2 ( lvl_base_2 )',
                                                                  'name'  => 'Название ( Основной MM сервер )',
                                                                  'mod' => 'CSGO / CSS',
                                                                  ),
                                                           ),
                                         ),
                                  ),
                  ),
            ),
      );
```

</details>

<details><summary>Если вы используете две и более базы данных из под одного пользователя</summary>

```
array ('LevelsRanks' => 
      array (0 => 
            array (
                  'HOST' => 'Ваш хост',
                  'USER' => 'Логин',
                  'PASS' => 'Пароль',
                  'DB'   => array (0 => 
                                   array (
                                         'DB'     => 'Имя основной базы данных',
                                         'Prefix' => array (0 => 
                                                            array (
                                                                  'table' => 'Название таблицы ( lvl_base )',
                                                                  'name'  => 'Название ( Основной AWP сервер )',
                                                                  'mod' => 'CSGO / CSS',
                                                                  ),
                                                            array (
                                                                  'table' => 'Название таблицы 2 ( lvl_base_2 )',
                                                                  'name'  => 'Название ( Основной MM сервер )',
                                                                  'mod' => 'CSGO / CSS',
                                                                  ),
                                                           ),
                                         ),
                                         (
                                         'DB'     => 'Имя второй базы данных',
                                         'Prefix' => array (0 => 
                                                            array (
                                                                  'table' => 'Название таблицы ( lvl_base )',
                                                                  'name'  => 'Название ( Новый MM сервер )',
                                                                  'mod' => 'CSGO / CSS',
                                                                  )
                                                           ),
                                         ),
                                  ),
                  ),
            ),
      );
```

</details>

<details><summary>Если модулю необходимо подключение к другому "моду"</summary>

Используйте шаблон подключения из описания модуля.
Пример. Интерация SourceBans или Material Admin:

```
array ('LevelsRanks' => 
      array (0 => 
            array (
                  'HOST' => 'Ваш хост',
                  'USER' => 'Логин',
                  'PASS' => 'Пароль',
                  'DB'   => array (0 => 
                                   array (
                                         'DB'     => 'Имя основной базы данных',
                                         'Prefix' => array (0 => 
                                                            array (
                                                                  'table' => 'Название таблицы ( lvl_base )',
                                                                  'name'  => 'Название ( Основной AWP сервер )',
                                                                  'mod' => 'CSGO / CSS',
                                                                  ),
                                                           ),
                                         ),
                                  ),
                  ),
       ),
      'SourceBans' => 
       array (0 => 
             array (
                   'HOST' => 'Хост SB / MA',
                   'USER' => 'Логин SB / MA',
                   'PASS' => 'Пароль SB / MA',
                   'DB'   => array (0 => 
                                    array (
                                          'DB'     => 'Имя базы данных SB / MA',
                                          'Prefix' => array (0 => 
                                                             array (
                                                                   'table' => 'sb_',
                                                                   'name'  => 'SourceBans',
                                                                   'mod' => 'CSGO / CSS',
                                                                   ),
                                                            ),
                                          ),
                                   ),
                   ),
             ),
      );
```

</details>

Блок разработчика:
-----

<details><summary>dev</summary>

Скелет WEB интерфейса ( dev #0.2.92 ) :
-----

```
/app            - Ядро.
  /ext          - PHP Классы.
  /includes     - Основные и дополнительные PHP функции.
  /modules      - Каталог с модулями.
  /page         - Основные заготовки и шаблоны WEB интерфейса.
  
/storage        - Хранилище.
  /assets       - CSS, JS, Fonts файлы.
  /cache        - Основной кэш.
    /img        - Кэш изображений.
    /sessions   - Кэш связанный с работой ядра.
      /modules  - Кэш модулей.
      
/index.php      - 'Hello World'
```

Модули:
-----

Каталог с модулями:
```
/app/modules
```

Что представляет из себя модуль ( На примере **module_block_main_stats** ):

```
/app
  /modules
    /module_block_main_stats       - Название папки = ID модуля.
      /assets                      - Ассеты.
        /js.php                    - Доп. JS код если имеется.
        /css.php                   - Доп. CSS код если имеется.
      /forward                     - Функциональная часть.
        /data.php                  - Пре-инициализация. Скрипт начинает свою работу до загрузки шаблона страницы.
        /interface.php             - Инициализация. Скрипт начинает свою работу во время загрузки шаблона.
        
/storage
  /cache
    /sessions
      /modules
        /module_block_main_stats
          /cache.php               - Кэш модуля.
          /translation.json        - Если модуль имеет мультиязычность, переводы описываются в данном файле.
      
/description.json - Описание модуля
```

</details>

-----

<p align="right">
        <img height="75px" src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/master/.github/authors.png"/>
</p>
