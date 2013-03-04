<?php

// Plugin definition
$plugin = array(
  'title' => t('Datagov two column'),
  'category' => t('Data.gov Panels'),
  'icon' => 'datagov_twocol.png',
  'theme' => 'datagov_twocol',
  'css' => 'datagov_twocol.css',
  'regions' => array(
    'left' => t('Left side'),
    'right' => t('Right side')
  ),
);
