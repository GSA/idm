<?php

  /**
   * PART 1. Basic Color module settings
   */

  $info = array();

  // Define the possible replaceable items and their labels.
  $info['fields'] = array(
    'base' => t('Main Background'),
    'link' => t('Hyperlinks Color'),
    'text' => t('Paragraph Text Color'),
    'headernolink' => t('Headline Colors (No Hyperlink)'),
    'headerwithlink' => t('Headline Colors (With Hyperlink)'),
    'sfishbgtop' => t('Main Menu Gradient Top Bg'),
    'sfishbgbottom' => t('Main Menu Gradient Bottom Bg'),
    'sfishbgactive' => t('Main Menu Active Hyperlink Bg'),
    'sfishitem' => t('Main Menu Text Hyperlink'),
    'sfishbg2' => t('Main Menu Dropdown Bg'),
    'promoareatop' => t('Promo/Page Title Gradient Top Bg'),
    'promoareabottom' => t('Promo/Page Title Gradient Bottom Bg'),
    'tableheaderbg' => t('Tables Header Bg'),
    'tableheadertext' => t('Tables Header Text'),
  );

  // Color schemes for the site. Note: use only lowercase letters, otherwise Color won't pick up your colors correctly.
  //Please do not edit color settings for this array.
  $info['schemes']['default'] = array(
      'title' => t('Data.gov Default Colors'), // Scheme title.
      'colors' => array( // Scheme colors (Keys are coming from $info['fields']).
        'base' => '#fdfdfd',
        'link' => '#284a77',
        'text' => '#666666',
        'headernolink' => '#284a78',
        'headerwithlink' => '#284a79',
        'sfishbgtop' => '#294b78',
        'sfishbgbottom' => '#0b3064',
        'sfishbgactive' => '#4782b1',
        'sfishitem' => '#fefefe',
        'sfishbg2' => '#366c9f',
        'promoareatop' => '#5ea0d2',
        'promoareabottom' => '#033162',
        'tableheaderbg' => '#036',
        'tableheadertext' => '#fffffe',
      ),
  );

  // Color schemes for the site. Note: use only lowercase letters, otherwise Color won't pick up your colors correctly
  $info['schemes']['green'] = array(
      'title' => t('Green Palette'), // Scheme title.
      'colors' => array( // Scheme colors (Keys are coming from $info['fields']).
        'base' => '#fdfdfd',
        'link' => '#284a77',
        'text' => '#666666',
        'headernolink' => '#366c9d',
        'headerwithlink' => '#366c9e',
        'sfishbgtop' => '#294b78',
        'sfishbgbottom' => '#0b3064',
        'sfishbgactive' => '#4782b1',
        'sfishitem' => '#fefefe',
        'sfishbg2' => '#366c9f',
        'promoareatop' => '#5ea0d2',
        'promoareabottom' => '#033162',
        'tableheaderbg' => '#025506',
        'tableheadertext' => '#fffffe',
      ),
  );


  // Define the CSS file(s) that we want the Color module to use as a base.
  $info['css'] = array(
    'css/color.css',
  );

  /***** Advanced Color settings - Defaults. Will be used in the Part 2. *****/

  /**
   * Default settings for the advanced stuff.
   * No need to edit these if you just want to play around with the colors.
   * Color wants these, otherwise it's not going to play.
   *
   * We dive deeper into these in the Part 2. Advanced Color settings
   */

  // Files we want to copy along with the CSS files.
  $info['copy'] = array(
    'logo.png',
  );

  // Files used in the scheme preview.
  $info['preview_css'] = 'color/preview.css';
  $info['preview_js'] = 'color/preview.js';
  $info['preview_html'] = 'color/preview.html';

  // Gradients
  $info['gradients'] = array();

  // Color areas to fill (x, y, width, height).
  $info['fill'] = array(
    'banner' => array(0, 0, 990, 62),
  );

  // Coordinates of all the theme slices (x, y, width, height)
  // with their filename as used in the stylesheet.
  $info['slices'] = array(
    'images/colorized-header.png' => array(0, 0, 990, 62),
  );

  // Base file for image generation.
  $info['base_image'] = 'color/base.png';
  $info['blend_target'] = '#ffffff';
