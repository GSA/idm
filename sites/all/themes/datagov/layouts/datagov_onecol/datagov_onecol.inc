<?php

/**
 * implementation of hook_panels_layouts()
 */
// Plugin definition
$plugin = array(
  'title' => t('Datagov single column'),
  'category' => t('Data.gov Panels'),
  'icon' => 'datagov_onecol.png',
  'theme' => 'datagov_onecol',
  'css' => 'datagov_onecol.css',
  'regions' => array('middle' => t('Middle column')),
);
