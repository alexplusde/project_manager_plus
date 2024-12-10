<?php

$addon = rex_addon::get('project_manager_plus');

echo rex_view::title($addon->i18n('project_manager_plus_client_title'));

$form = rex_config_form::factory($addon->getName());

// API Key
$field = $form->addInputField('text', 'project_manager_plus_api_key', null, ['class' => 'form-control']);
$field->setLabel($addon->i18n('project_manager_plus_api_key_label'));
$field->setNotice($addon->i18n('project_manager_plus_api_key_notice') . ' <code>13f15d69755585c3a825c3eccf2d654fc6578dadb7e05475</code>');

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('project_manager_plus_client_title'), false);
$fragment->setVar('body', $form->get(), false);

echo $fragment->parse('core/page/section.php');
