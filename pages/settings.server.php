<?php

$addon = rex_addon::get('project_manager_plus');

echo rex_view::title($addon->i18n('project_manager_plus_server_title'));

$form = rex_config_form::factory($addon->getName());

// PHP MIN
$field = $form->addSelectField('php_min', null, ['class' => 'form-control']);
$field->setLabel($addon->i18n('project_manager_plus_server_php_min'));
$select = $field->getSelect();
$phpVersions = $addon->getProperty('php_versions');
foreach ($phpVersions as $version) {
    $select->addOption($version, $version);
}

// CMS MIN
$field = $form->addSelectField('cms_min', null, ['class' => 'form-control']);
$field->setLabel($addon->i18n('project_manager_plus_server_cms_min'));
$select = $field->getSelect();
$cmsVersions = $addon->getProperty('cms_versions');
foreach ($cmsVersions as $version) {
    $select->addOption($version, $version);
}

// Skip Addon
$field = $form->addInputField('text', 'skip_addon', null, ['class' => 'form-control']);
$field->setLabel($addon->i18n('project_manager_plus_server_skip_addon'));
$field->setNotice($addon->i18n('project_manager_plus_server_skip_addon_notice'));

// Skip Addon Version
$field = $form->addInputField('text', 'skip_addon_version', null, ['class' => 'form-control']);
$field->setLabel($addon->i18n('project_manager_plus_server_skip_addon_version'));
$field->setNotice($addon->i18n('project_manager_plus_server_skip_addon_version_notice'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('project_manager_plus_server_title'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
