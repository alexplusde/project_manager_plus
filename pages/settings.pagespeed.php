<?php

$addon = rex_addon::get('project_manager_plus');

echo rex_view::title($addon->i18n('project_manager_plus_pagespeed_api_key_title'));

$form = rex_config_form::factory($addon->getName());

// API Key
$field = $form->addInputField('text', 'project_manager_plus_pagespeed_api_key', null, ['class' => 'form-control']);
$field->setLabel($addon->i18n('project_manager_plus_pagespeed_api_key_label'));
$field->setNotice($addon->i18n('project_manager_plus_pagespeed_api_key_notice'));

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit', false);
$fragment->setVar('title', $addon->i18n('project_manager_plus_pagespeed_api_key_title'), false);
$fragment->setVar('body', $form->get(), false);
echo $fragment->parse('core/page/section.php');
