<?php

// Plugin definition
$plugin = array(
  'title' => t('Datagov three column 25/50/25 stacked'),
  'category' => t('Data.gov Panels'),
  'icon' => 'datagov_threecol_25_50_25_stacked.png',
  'theme' => 'datagov_threecol_25_50_25_stacked',
  'css' => 'datagov_threecol_25_50_25_stacked.css',
  'regions' => array(
    'top' => t('Top'),
    'left' => t('Left side'),
    'middle' => t('Middle column'),
    'right' => t('Right side'),
    'bottom' => t('Bottom'),
  ),
);
