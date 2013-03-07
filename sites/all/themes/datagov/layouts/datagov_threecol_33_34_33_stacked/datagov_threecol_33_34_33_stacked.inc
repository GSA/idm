<?php

// Plugin definition
$plugin = array(
  'title' => t('Datagov three column 33/34/33 stacked'),
  'category' => t('Data.gov Panels'),
  'icon' => 'datagov_threecol_33_34_33_stacked.png',
  'theme' => 'datagov_threecol_33_34_33_stacked',
  'css' => 'datagov_threecol_33_34_33_stacked.css',
  'regions' => array(
    'top' => t('Top'),
    'left' => t('Left side'),
    'middle' => t('Middle column'),
    'right' => t('Right side'),
    'bottom' => t('Bottom')
  ),
);
