<?php
! empty( $_SESSION['steamid32'] ) && $_SESSION['steamid32'] == $General->arr_general['admin'] && $Modules->set_sidebar_select('module_page_adminpanel', ["href" =>"?page=adminpanel", "open_new_tab" =>"0", "icon_group" =>"zmdi", "icon_category" =>"", "icon" =>"coffee", "name" =>"_Admin_panel", "sidebar_directory" =>""]);
