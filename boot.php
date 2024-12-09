<?php

/** @var rex_addon project_manager_plus */

// Addonrechte (permissions) registieren
if (rex::isBackend() && is_object(rex::getUser())) {
    rex_perm::register('project_manager_plus[]');
}

if (rex::isBackend() && rex_be_controller::getCurrentPagePart(1) == 'project_manager_plus') {
    rex_view::addCssFile($this->getAssetsUrl('css/styles.css'));
}
