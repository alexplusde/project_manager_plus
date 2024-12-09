<?php
// CRONJOB REGISTER
if (rex_addon::get('cronjob')->isAvailable()) {
	rex_cronjob_manager::registerType('rex_cronjob_project_manager_plus_data');
  rex_cronjob_manager::registerType('rex_cronjob_project_manager_plus_favicon');
}


if (rex::isBackend() && is_object(rex::getUser())) {
  
  if (rex::getUser()->hasPerm('project_manager_plus_server[]')) { 
    //  set as start page to server if perm is ok
    rex_extension::register('PAGES_PREPARED', function (rex_extension_point $ep) {
      $pages = $ep->getSubject();
      $pages[$this->getAddOn()->getName()]->setHref(rex_url::backendPage($this->getProperty('package')));
      $ep->setSubject($pages);
    }, rex_extension::LATE);
  }
}
