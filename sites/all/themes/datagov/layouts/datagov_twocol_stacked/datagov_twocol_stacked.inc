<?php

// Plugin definition
$plugin = array(
  'title' => t('Datagov two column stacked'),
  'category' => t('Data.gov Panels'),
  'icon' => 'datagov_twocol_stacked.png',
  'theme' => 'datagov_twocol_stacked',
  'css' => 'datagov_twocol_stacked.css',
  'regions' => array(
    'top' => t('Top'),
    'left' => t('Left side'),
    'right' => t('Right side'),
    'bottom' => t('Bottom')
  ),
);
