<?php
isset( $_SESSION['steamid32'] ) && isset( $_SESSION['user_admin'] ) && $Modules->set_sidebar_select('module_page_adminpanel', ["href" =>"?page=adminpanel", "open_new_tab" =>"0", "icon_group" =>"zmdi", "icon_category" =>"", "icon" =>"coffee", "name" =>"_Admin_panel", "sidebar_directory" =>""]);
