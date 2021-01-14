<p align="center">
	<img height="250px" src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/logo.png">
</p>
<h1 align="center">
    Levels Ranks - WEB Interface
</h1>
<p><a href="https://www.codacy.com/manual/M0st1ce/levels-ranks-web?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=levelsranks/levels-ranks-web&amp;utm_campaign=Badge_Grade"><img src="https://api.codacy.com/project/badge/Grade/76c6d7faeac04277ba27d1e112f186fd"/></a>
<a href="https://php.net/" rel="nofollow"><img src="https://img.shields.io/badge/PHP-%3E%3D7.0-blue" alt="PHP" data-canonical-src="https://img.shields.io/badge/PHP-%3E%3D7.0-blue" style="max-width:100%;"></a></p>

-----

User WEB interface for interacting with statistics plugins <a href="https://github.com/levelsranks/levels-ranks-core">Levels Ranks</a>, <a href="https://hlmod.com/resources/fire-players-stats.1232/">Fire Players Stats</a> and <a href="https://forums.alliedmods.net/showthread.php?t=290063">RankMe Kento Edition</a>.
Official support channel at <a href="https://discord.gg/Mbjnh3h">Discord</a>.

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

Demo
-----

- https://truesrv.ru/
- https://unitcsgo.ru/
- https://oupro.su/
- https://nokill.ru/
- https://stats.blackflash.ru/
- https://ilitagame.ru/
- https://wocawp.ru/stats/
- https://stats.unity.pp.ua/
- https://yablochko-csgo.ru/
- https://lr.neostrike.ru/
- https://horizoncsgo.ru/
- https://gg-pro.ru/levels/
- https://prog-cs.ru/levelrank/
- https://crystalx.ru/
- https://rsb-cs.ru/
- https://cs-pbox.su/
- https://stats.веселаяжизнь.рф/
- https://asgard-project.ru/
- https://nightproject.ru/

Requirements
-----

- **Required**
  - PHP 7.0 and higher.
  - PHP PDO support.
  - PHP GMP support.
  - PHP BCMath support.
  - PHP cURL support.
  - PHP json support.
  - PHP Zip support.
- **Recommended**
  - MySQL 5.7 or MariaDB 10.1 and higher.

Installation
-----

- Download **stable *(recommended)*** or dev release of Levels Ranks WEB.
- Extract files from archive and move them to any directory on your domain or subdomain.
- Go to your website with the extracted Levels Ranks WEB and go through the installation process.
- Profit!

Detailed Database Setup
-----

File and directory:
```
/storage/cache/sessions/db.php
```
<details><summary>Main Template</summary>

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
                                                  'table' => 'Название таблицы (lvl_base)',
                                                  'name'  => 'Название (Основной AWP сервер)',
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

<details><summary>If you are using two or more tables in one database</summary>

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
                                                  'table' => 'Название таблицы (lvl_base)',
                                                  'name'  => 'Название (Основной AWP сервер)',
                                                  'mod' => '730 / 240 / 215',
												  'ranks_pack' => 'default',
                                                  'steam' => '1 / 0'
                                                  ],
                                                  [
                                                  'table' => 'Название таблицы 2 (lvl_base_2)',
                                                  'name'  => 'Название (Основной MM сервер)',
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

<details><summary>If you use two or more databases from under one user</summary>

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
                                                  'table' => 'Название таблицы (lvl_base)',
                                                  'name'  => 'Название (Основной AWP сервер)',
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
                                                  'table' => 'Название таблицы (lvl_base)',
                                                  'name'  => 'Название (Новый MM сервер)',
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

<details><summary>If you are using two or more users with different databases</summary>

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
                                                  'table' => 'Название таблицы (lvl_base)',
                                                  'name'  => 'Название (Основной AWP сервер)',
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
                                                  'table' => 'Название таблицы (lvl_base)',
                                                  'name'  => 'Название (Основной AWP сервер)',
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

<details><summary>If the module needs to be connected to another **mod (SB / MA example)**</summary>

Use the connection pattern from the module description.
Example. SourceBans or Material Admin iteration:

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
                                                  'table' => 'Название таблицы (lvl_base)',
                                                  'name'  => 'Название (Основной AWP сервер)',
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

Available Modules
-----

<details><summary>LR WEB (min. dev #0.2.114) - Mini Statistics on the home page</summary>

<p align="center">
	<img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_block_main_stats.png">
</p>

- **Display page**: Home
- **Info**: Adds three mini blocks describing the number of players, players who have logged in in the last 24 hours and the number of headshots.
- **Download:** Available in the base module package.
</details>

<details><summary>LR WEB (min. dev #0.2.114) - Online monitoring on the main page</summary>

<p align="center">
	<img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_block_main_servers_monitoring_type_3.png">
</p>

- **Display Page**: Home
- **Info**: Adds online monitoring of servers with connectivity.
- **Download:** Available in the base module package.
</details>

<details><summary>LR WEB (min. dev #0.2.114) - Top players on the homepage</summary>

<p align="center">
	<img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_block_main_top.png">
</p>

- ** Display Page**: Home
- ** Info**: Adds "top 10" blocks to each connected Levels Ranks table.
- ** Download:** Available in the base module package.
</details>

<details><summary>LR WEB (min. dev #0.2.114) - Profiles</summary>

<p align="center">
	<img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_page_profiles.png">
</p>

- **Display Page**: profiles
- **Info**: Adds player pages with their personal statistics.
- **Download:** Available in the base module package.
</details>

<details><summary>LR WEB (min. dev #0.2.114) - Player Stats</summary>

<p align="center">
	<img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_page_toppoints.png">
</p>

- **Display Page**: toppoints
- **Info**: Adds a page with statistics of all players players.
- **Download:** Available in the base module package.
</details>

<details><summary>LR WEB (min. dev #0.2.114) - Distribution of Ranks</summary>

<p align="center">
	<img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_page_rankstats.png">
</p>

- **Display Page**: rankstats
- **Information**: Adds a page with the distribution of ranks on servers.
- **Download:** Available in the base module package.
</details>

<details><summary>LR WEB (min. dev #0.2.114) - Admin Panel</summary>

- **Display Page**: adminpanel
- **Info**: Adds flexible administration to the web interface and useful features.
- **Download:** Available in the base module package.
</details>

<details><summary>LR WEB (min. dev #0.2.114) - Bans Page</summary>

<p align="center">
	<img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_page_bans.png">
</p>

- **Display Page**: bans
- **Information**:
  - Integration with SB / MA.
  - It is necessary to add a new "SourceBans" mod to db.php and describe the connection. Specify the table name with a prefix, for example: "sb_".
- **Download:** Available in the base module package.
</details>

<details><summary>LR WEB (min. dev #0.2.114) - Mutes Page</summary>
        
<p align="center">
	<img src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/modules/module_page_comms.png">
</p>

- **Display Page**: comms
- **Information**:
  - Integration with SB / MA.
  - It is necessary to add a new "SourceBans" mod to db.php and describe the connection. Specify the table name with a prefix, for example: "sb_".
- **Download:** Available in the base module package.
</details>

Thanks
-----

- pedrotski#1184 (Discord, ghostcapgaming.com) - 3 803 RUB.
- Larsalex    (hlmod.ru)  - 3000 RUB.
- .ZΛCHΞR#1337(Discord)   - 2093.37 RUB.
- CEED 🐼#4061  (Discord)   - 1488 RUB.
- mixxed.xyz#4469 (Discord) - 1200 RUB.
- Эльдарка#7777   (Discord)  - 1055.1 RUB.
- OkyHek#2441 (Discord)   - 1000 RUB.
- Felya#1342  (Discord)   - 817.12 RUB.
- Clubber#2324 (Discord) - 784,44 RUB.
- Nestor#9876 (Discord)   - 600 RUB.
- MAMAC#9993  (Discord)   - 511.05 RUB.
- dyoma#5525  (Discord)   - 500 RUB.
- Морячок#9904  (Discord)   - 500 RUB.
- Xzotys#3880  (Discord)   - 500 RUB.
- Unity       (hlmod.ru)  - 460 RUB.
- MotherRussia#2235    (Discord)   - 350 RUB.
- interes#3153    (Discord)   - 300 RUB.
- xek#1152    (Discord)   - 300 RUB.
- Paranoiiik  (hlmod.ru)  - 300 RUB.
- L1MON#4529  (Discord)   - 300 RUB.
- ju4ka1371   (hlmod.ru)  - 282 RUB.
- Good Game Project ( gg-pro.ru ) - 250 RUB.
- Wend4r      (hlmod.ru)  - 250 RUB.
- Rabb1t      (hlmod.ru)  - 250 RUB.
- Sleep#0725  (Discord)   - 250 RUB.
- ERROR404#9842 (Discord)  - 200 RUB.
- Malenkiy Alik#1945 (Discord)  - 200 RUB.
- Морковка#7277 (Discord)  - 200 RUB.
- valerun     (hlmod.ru)  - 185 RUB.
- FIVE#3136   (Discord)   - 155 RUB.
- MaZa#8322    (Discord)  - 150 RUB.
- ™S.E.N.A.T.O.R™♛#1466 (Discord)  - 150 RUB.
- SynZilla    (hlmod.ru)  - 150 RUB.
- d4Ck#0698 (Discord)   - 147.67 RUB.
- ka1jaru#1648 (Discord)  - 137.45 RUB.
- uraganas#7978 (Discord)   - 132 RUB.
- Domikuss#3855 (Discord) - 121.45 RUB.
- punisher89#7116 (Discord)  - 104.45 RUB.
- SV3N#9923   (Discord)   - 100.40 RUB.
- HILER#3959  (Discord)   - 100 RUB.
- Truyn#6750  (Discord)   - 100 RUB.
- DevBT#4750  (Discord)   - 100 RUB.
- DismoraL    (hlmod.ru)  - 100 RUB.
- xXMaXimXx   (hlmod.ru)  - 100 RUB.
- Twenix#4347 (Discord)   - 100 RUB.
- LEGACY#3877 (Discord)   - 50 RUB.
- ARONGAMES#2063 (Discord)   - 50 RUB.
- fr4nch#3619 (Discord)   - 50 RUB.
- HolyHender#8673 (Discord)   - 33 RUB.
- Мировой     (hlmod.ru)  - 29 RUB.

Developer Block
-----

<details><summary>dev</summary>

Скелет WEB интерфейса (dev #0.2.114):
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
Modules
-----

Directory with modules:
```
/app/modules
```
What is a module **(For example `module_block_main_stats`)**:
```
/app
  /modules
    /module_block_main_stats       - Название папки = ID модуля.
      /ext          		   	   - PHP Классы.
      /assets                      - Ассеты.
        /css                       - CSS ассеты.
        /js                        - JS ассеты.
      /forward                     - Функциональная часть.
        /data.php                  - Пре-инициализация. Скрипт начинает свою работу до загрузки шаблона страницы.
	/data_always.php           	   - Пре-инициализация. Скрипт начинает свою работу до загрузки шаблона и работает на всех страницах.
        /interface.php             - Инициализация. Скрипт начинает свою работу во время загрузки шаблона.
      /temp						   - Кэш файлы.
    /description.json - Описание модуля
    /translation.json - Если модуль имеет мультиязычность, переводы описываются в данном файле.

```
</details>

-----

<p align="right">
	<img height="75px" src="https://raw.githubusercontent.com/levelsranks/levels-ranks-web/alpha/.github/authors.png">
</p>
