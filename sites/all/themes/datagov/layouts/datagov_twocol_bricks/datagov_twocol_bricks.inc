<?php

/**
 * @file
 * Implementation for the two column bricked layout
 */

// Plugin definition
$plugin = array(
  'title' => t('Datagov two column bricks'),
  'category' => t('Data.gov Panels'),
  'icon' => 'datagov_twocol_bricks.png',
  'theme' => 'datagov_twocol_bricks',
  'css' => 'datagov_twocol_bricks.css',
  'regions' => array(
    'top' => t('Top'),
    'left_above' => t('Left above'),
    'right_above' => t('Right above'),
    'middle' => t('Middle'),
    'left_below' => t('Left below'),
    'right_below' => t('Right below'),
    'bottom' => t('Bottom'),
  ),
);

