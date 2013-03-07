<?php

/**
 * implementation of hook_panels_layouts
 */
// Plugin definition
$plugin = array(
  'title' => t('Datagov three column 25/50/25'),
  'category' => t('Data.gov Panels'),
  'icon' => 'datagov_threecol_25_50_25.png',
  'theme' => 'datagov_threecol_25_50_25',
  'theme arguments' => array('id', 'content'),
  'css' => 'datagov_threecol_25_50_25.css',
  'regions' => array(
    'left' => t('Left side'),
    'middle' => t('Middle column'),
    'right' => t('Right side')
  ),
);

