<p align="center">
        <img height="250px" src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/logo.png">
</p>
<h1 align="center">
    Levels Ranks - WEB Interface
</h1>
<a href="https://www.codacy.com/manual/M0st1ce/levels-ranks-web?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=levelsranks/levels-ranks-web&amp;utm_campaign=Badge_Grade"><img src="https://api.codacy.com/project/badge/Grade/76c6d7faeac04277ba27d1e112f186fd"/></a>

-----

Пользовательский WEB интерфейс для взаимодействия с плагином статистики <a href="https://github.com/levelsranks/levels-ranks-core">Levels Ranks</a>.
Официальный канал поддержки в <a href="https://discord.gg/Mbjnh3h">Discord</a>.

-----
<p align="center">
        <img height="43px" src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/just_themes.png">
</p>
<p align="center">
        <img height="560px" src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/interface.png">
</p>
<p align="center">
        <img height="43px"src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/full_adaptation.png">
</p>
<p align="center">
        <img height="880px"src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/profile.png">
</p>
<p align="center">
        <img height="43px"src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/multi_lingual.png">
</p>
<p align="center">
        <img width="720"src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/flags.png">
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
  - Поддержка PHP BCMath.
  - Поддержка PHP cURL.
  - Поддержка PHP Zip.
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

Файл и директория:

```
/storage/cache/sessions/db.php
```

<details><summary>Основной шаблон</summary>

```
<?php return ['LevelsRanks' => 
                [0 => 
                    [
                    'HOST' => 'Ваш хост',
                    'USER' => 'Логин',
                    'PASS' => 'Пароль',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя основной базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'Название таблицы ( lvl_base )',
                                                  'name'  => 'Название ( Основной AWP сервер )',
                                                  'mod' => '730 / 240 / 215',
					          'ranks_pack' => 'default',
                                                  'steam' => '1 / 0'
                                                  ],
                                               ],
                                  ],
                              ],
                    ],
                ],
		'Core' => 
                [0 => 
                    [
                    'HOST' => 'Ваш хост',
                    'USER' => 'Логин',
                    'PASS' => 'Пароль',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя основной базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'lvl_'
                                                  ],
                                               ],
                                  ],
                              ],
                    ],
                ],
];
```
</details>

<details><summary>Если вы используете две и более таблиц в одной базе данных</summary>

```
<?php return ['LevelsRanks' => 
                [0 => 
                    [
                    'HOST' => 'Ваш хост',
		    'PORT' => '3306',
                    'USER' => 'Логин',
                    'PASS' => 'Пароль',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя основной базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'Название таблицы ( lvl_base )',
                                                  'name'  => 'Название ( Основной AWP сервер )',
                                                  'mod' => '730 / 240 / 215',
						  'ranks_pack' => 'default',
                                                  'steam' => '1 / 0'
                                                  ],
                                                  [
                                                  'table' => 'Название таблицы 2 ( lvl_base_2 )',
                                                  'name'  => 'Название ( Основной MM сервер )',
                                                  'mod' => '730 / 240 / 215',
						  'ranks_pack' => 'default',
                                                  'steam' => '1 / 0'
                                                  ],
                                              ],
                                  ],
                              ],
                    ],
                ],
		'Core' => 
                [0 => 
                    [
                    'HOST' => 'Ваш хост',
                    'USER' => 'Логин',
                    'PASS' => 'Пароль',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя основной базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'lvl_'
                                                  ],
                                               ],
                                  ],
                              ],
                    ],
                ],
];
```

</details>

<details><summary>Если вы используете две и более базы данных из под одного пользователя</summary>

```
<?php return ['LevelsRanks' => 
                [0 => 
                    [
                    'HOST' => 'Ваш хост',
		    'PORT' => '3306',
                    'USER' => 'Логин',
                    'PASS' => 'Пароль',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя основной базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'Название таблицы ( lvl_base )',
                                                  'name'  => 'Название ( Основной AWP сервер )',
                                                  'mod' => '730 / 240 / 215',
						  'ranks_pack' => 'default',
                                                  'steam' => '1 / 0'
                                                   ],
                                               ],
                                  ],
                                  [
                                  'DB'     => 'Имя второй базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'Название таблицы ( lvl_base )',
                                                  'name'  => 'Название ( Новый MM сервер )',
                                                  'mod' => '730 / 240 / 215',
						  'ranks_pack' => 'default',
                                                  'steam' => '1 / 0'
                                                  ]
                                              ],
                                  ],
                              ],
                    ],
                ],
		'Core' => 
                [0 => 
                    [
                    'HOST' => 'Ваш хост',
                    'USER' => 'Логин',
                    'PASS' => 'Пароль',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя основной базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'lvl_'
                                                  ],
                                               ],
                                  ],
                              ],
                    ],
                ],
];
```

</details>

<details><summary>Если вы используете двух и более пользователей с разными базами данных</summary>

```
<?php return ['LevelsRanks' => 
                [0 => 
                    [
                    'HOST' => 'Ваш хост',
		    'PORT' => '3306',
                    'USER' => 'Логин',
                    'PASS' => 'Пароль',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя основной базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'Название таблицы ( lvl_base )',
                                                  'name'  => 'Название ( Основной AWP сервер )',
                                                  'mod' => '730 / 240 / 215',
						  'ranks_pack' => 'default',
                                                  'steam' => '1 / 0'
                                                   ],
                                               ],
                                  ],
                              ],
                    ],
                    [
                    'HOST' => 'Ваш хост 2',
		    'PORT' => '3306',
                    'USER' => 'Логин 2',
                    'PASS' => 'Пароль 2',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'Название таблицы ( lvl_base )',
                                                  'name'  => 'Название ( Основной AWP сервер )',
                                                  'mod' => '730 / 240 / 215',
						  'ranks_pack' => 'default',
                                                  'steam' => '1 / 0'
                                                   ],
                                               ],
                                  ],
                              ],
                    ],
                ],
		'Core' => 
                [0 => 
                    [
                    'HOST' => 'Ваш хост',
                    'USER' => 'Логин',
                    'PASS' => 'Пароль',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя основной базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'lvl_'
                                                  ],
                                               ],
                                  ],
                              ],
                    ],
                ],
];
```

</details>

<details><summary>Если модулю необходимо подключение к другому "моду" ( SB / MA пример )</summary>

Используйте шаблон подключения из описания модуля.
Пример. Интерация SourceBans или Material Admin:

```
<?php return ['LevelsRanks' => 
                [0 => 
                    [
                    'HOST' => 'Ваш хост',
		    'PORT' => '3306',
                    'USER' => 'Логин',
                    'PASS' => 'Пароль',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя основной базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'Название таблицы ( lvl_base )',
                                                  'name'  => 'Название ( Основной AWP сервер )',
                                                  'mod' => '730 / 240 / 215',
						  'ranks_pack' => 'default',
                                                  'steam' => '1 / 0'
                                                  ],
                                              ],
                                  ],
                              ],
                    ],
                ],
		'Core' => 
                [0 => 
                    [
                    'HOST' => 'Ваш хост',
                    'USER' => 'Логин',
                    'PASS' => 'Пароль',
                    'DB'   => [0 => 
                                  [
                                  'DB'     => 'Имя основной базы данных',
                                  'Prefix' => [0 => 
                                                  [
                                                  'table' => 'lvl_'
                                                  ],
                                               ],
                                  ],
                              ],
                    ],
                ],
		'SourceBans' => 
                [0 => 
                   [
                   'HOST' => 'Хост SB / MA',
		   'PORT' => '3306',
                   'USER' => 'Логин SB / MA',
                   'PASS' => 'Пароль SB / MA',
                   'DB'   => [0 => 
                                 [
                                 'DB'     => 'Имя базы данных SB / MA',
                                 'Prefix' => [0 => 
                                                 [
                                                 'table' => 'sb_',
                                                 'name'  => 'SourceBans',
                                                 'mod' => '730 / 240 / 215',
                                                 'steam' => '1 / 0'
                                                 ],
                                             ],
                                 ],
                             ],
                   ],
               ],
];
```

</details>

Доступные модули:
-----

<details><summary>LR WEB ( min. dev #0.2.114 ) - Мини-Статистика на главной странице</summary>

<p align="center">
        <img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_block_main_stats.png">
</p>

- **Старница отображения**: Главная
- **Информация**: Добавляет три мини блока с описанием количества игроков, игроков которые заходили за последние 24 часа и количестве убийств в голову.
- **Скачать:** Доступен в базовом пакете модулей.
</details>

<details><summary>LR WEB ( min. dev #0.2.114 ) - Мониторинг онлайна на главной странице</summary>

<p align="center">
        <img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_block_main_servers_monitoring_type_3.png">
</p>

- **Старница отображения**: Главная
- **Информация**: Добавляет мониторинг онлайна серверов с возможностью подключения.
- **Скачать:** Доступен в базовом пакете модулей.
</details>

<details><summary>LR WEB ( min. dev #0.2.114 ) - Топ игроков на главной странице</summary>

<p align="center">
        <img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_block_main_top.png">
</p>

- **Старница отображения**: Главная
- **Информация**: Добавляет блоки с "топ 10" каждой подключенной таблице Levels Ranks.
- **Скачать:** Доступен в базовом пакете модулей.
</details>

<details><summary>LR WEB ( min. dev #0.2.114 ) - Профили</summary>

<p align="center">
        <img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_page_profiles.png">
</p>

- **Старница отображения**: profiles
- **Информация**: Добавляет страницы игроков с их личной статистикой.
- **Скачать:** Доступен в базовом пакете модулей.
</details>

<details><summary>LR WEB ( min. dev #0.2.114 ) - Статистика игроков</summary>

<p align="center">
        <img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_page_toppoints.png">
</p>

- **Старница отображения**: toppoints
- **Информация**: Добавляет страницу со статистикой всех игроков игроков.
- **Скачать:** Доступен в базовом пакете модулей.
</details>

<details><summary>LR WEB ( min. dev #0.2.114 ) - Распределением рангов</summary>

<p align="center">
        <img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_page_rankstats.png">
</p>

- **Старница отображения**: rankstats
- **Информация**: Добавляет страницу с распределением рангов на серверах.
- **Скачать:** Доступен в базовом пакете модулей.
</details>

<details><summary>LR WEB ( min. dev #0.2.114 ) - Панель администратора</summary>

- **Старница отображения**: adminpanel
- **Информация**: Добавляет гибкое администрирование вэб интерфейсом и полезные функции.
- **Скачать:** Доступен в базовом пакете модулей.
</details>

<details><summary>LR WEB ( min. dev #0.2.114 ) - Страница с банами</summary>
        
<p align="center">
        <img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_page_bans.png">
</p>

- **Старница отображения**: bans
- **Информация**: 
  - Интеграция с SB / MA.
  - Необходимо добавить в db.php новый мод "SourceBans" и описать подключение. Название таблицы указать префиксом, пример: "sb_".
- **Скачать:** Доступен в базовом пакете модулей.
</details>

<details><summary>LR WEB ( min. dev #0.2.114 ) - Страница с мутами</summary>
        
<p align="center">
        <img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_page_comms.png">
</p>

- **Старница отображения**: comms
- **Информация**: 
  - Интеграция с SB / MA.
  - Необходимо добавить в db.php новый мод "SourceBans" и описать подключение. Название таблицы указать префиксом, пример: "sb_".
- **Скачать:** Доступен в базовом пакете модулей.
</details>

Демо:
-----

- https://ocgn.ru/
- https://wocawp.ru/stats/
- https://stats.unity.pp.ua/
- https://yablochko-csgo.ru/
- http://lr.neostrike.ru/
- http://ilitagame.ru/
- https://gg-pro.ru/levels/
- http://prog-cs.ru/levelrank/
- http://rsb-cs.ru/

Благодарность:
-----

- Larsalex    ( hlmod.ru )  - 3000 RUB.
- .ZΛCHΞR#1337( Discord )   - 2093.37 RUB.
- mixxed.xyz#4469 ( Discord ) - 1200 RUB.
- OkyHek#2441 ( Discord )   - 1000 RUB.
- Felya#1342  ( Discord )   - 817.12 RUB.
- dyoma#5525  ( Discord )   - 500 RUB.
- Морячок#9904  ( Discord )   - 500 RUB.
- Unity       ( hlmod.ru )  - 460 RUB.
- xek#1152    ( Discord )   - 300 RUB.
- Paranoiiik  ( hlmod.ru )  - 300 RUB.
- L1MON#4529  ( Discord )   - 300 RUB.
- ju4ka1371   ( hlmod.ru )  - 282 RUB.
- Эльдарка#7777   ( Discord )  - 277.77 RUB.
- Good Game Project ( gg-pro.ru ) - 250 RUB.
- Wend4r      ( hlmod.ru )  - 250 RUB.
- Rabb1t      ( hlmod.ru )  - 250 RUB.
- Sleep#0725  ( Discord )   - 250 RUB.
- FIVE#3136   ( Discord )   - 155 RUB.
- valerun     ( hlmod.ru )  - 150 RUB.
- SynZilla    ( hlmod.ru )  - 150 RUB.
- Nestor#9876 ( Discord )   - 150 RUB.
- uraganas#7978 ( Discord )   - 132 RUB.
- SV3N#9923   ( Discord )   - 100.40 RUB.
- DevBT#4750  ( Discord )   - 100 RUB.
- DismoraL    ( hlmod.ru )  - 100 RUB.
- xXMaXimXx   ( hlmod.ru )  - 100 RUB.
- ka1jaru#1648 ( Discord )  - 72.45 RUB.
- Мировой     ( hlmod.ru )  - 29 RUB.

Блок разработчика:
-----

<details><summary>dev</summary>

Скелет WEB интерфейса ( dev #0.2.114 ) :
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
      /ext          		   - PHP Классы.
      /assets                      - Ассеты.
        /css                       - CSS ассеты.
        /js                        - JS ассеты.
      /forward                     - Функциональная часть.
        /data.php                  - Пре-инициализация. Скрипт начинает свою работу до загрузки шаблона страницы.
	/data_always.php           - Пре-инициализация. Скрипт начинает свою работу до загрузки шаблона и работает на всех страницах.
        /interface.php             - Инициализация. Скрипт начинает свою работу во время загрузки шаблона.
      /temp			   - Кэш файлы.
    /description.json - Описание модуля
    /translation.json - Если модуль имеет мультиязычность, переводы описываются в данном файле.

```

</details>

-----

<p align="right">
        <img height="75px" src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/authors.png">
</p>
