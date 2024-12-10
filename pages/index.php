<?php

$addon = rex_addon::get('project_manager_plus');

echo rex_view::title($addon->i18n('project_manager_plus_title'));

rex_be_controller::includeCurrentPageSubPath();
