<?php
// CRONJOB REGISTER
if (rex_addon::get('cronjob')->isAvailable()) {
	rex_cronjob_manager::registerType('rex_cronjob_project_manager_plus_data');
  rex_cronjob_manager::registerType('rex_cronjob_project_manager_plus_favicon');
}
