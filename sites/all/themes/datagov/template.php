<?php

// Create a theme function that can be overridden by other theme developers.
function datagov_text_resize_block() {
  if (_get_text_resize_reset_button() == TRUE) {
    $output = t('<a href="javascript:;" class="changer" id="text_resize_decrease" title="Text Decrease"><sup>-</sup>A</a> <a href="javascript:;" class="changer" id="text_resize_reset" title="Text Reset"><sup>A</sup></a> <a href="javascript:;" class="changer" id="text_resize_increase" title="Text Increase"><sup>+</sup>A</a><div id="text_resize_clear"></div>');
  }
  else {
    $output = t('<a href="javascript:;" class="changer" id="text_resize_decrease" title="Text Decrease"><sup>-</sup>A</a> <a href="javascript:;" class="changer" id="text_resize_increase" title="Text Increase"><sup>+</sup>A</a><div id="text_resize_clear"></div>');
  }
  return $output;
}

function datagov_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id != 'search_block_form') {
    return;
  }

  // Prefill "Search Data.gov" in the search box.
  $placeholder = "Data.gov"; 
  if (module_exists('og') && module_exists('usasearch') && variable_get('usasearch_search_page', 0) && variable_get('usasearch_og_sensitive', 0)) {
    $group = og_context();
    if ($group) {
      $placeholder = "in " . $group->label;
    }
  }

  $form['search_block_form']['#title'] = t('Search'); // Change the text on the label element
  $form['search_block_form']['#title_display'] = 'invisible'; // Toggle label visibilty
  $form['search_block_form']['#size'] = 40;  // define size of the textfield
  $form['search_block_form']['#default_value'] = t('Search ') . $placeholder; // Set a default value for the textfield

  // Add extra attributes to the text box
  $form['search_block_form']['#attributes']['onblur'] = "if (this.value == '') {this.value = 'Search " . $placeholder . ";}";
  $form['search_block_form']['#attributes']['onfocus'] = "if (this.value == 'Search " . $placeholder . "') {this.value = '';}";
  // Prevent user from searching the default text
  $form['#attributes']['onsubmit'] = "if(this.search_block_form.value=='Search " . $placeholder. "'){ alert('Please enter the keyword(s) to search for.'); return false; }";
}

/**
 * Implements template_process_html().
 *
 * Override or insert variables into the page template for HTML output.
 */
function datagov_process_html(&$variables) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_html_alter($variables);
  }
}

/*
* Implements template_process_page().
*/
function datagov_process_page(&$variables, $hook) {
  // Hook into color.module.
  if (module_exists('color')) {
    _color_page_alter($variables);
  }
  if (strtolower($variables['title']) == 'home') {
    $variables['title'] = 'User Account';
  }
}

/**
 * Implements template_preprocess()

function datagov_preprocess(&$variables, $hook) {
  // Redirect to a non-purl page when $space and !$group
  // Otherwise the community search result will include non-community content.
  // Use generic template_preprocess so that we can get redirected asap.

  // Use static variable to bypass redudent if-condition evaluations
  static $b_noredir;
  if ($b_noredir) {
    return;
  }

  // Redirect to url without purl if not within a og.
  $group = og_context();
  $space = spaces_get_space();

  // check if group and space are synched
  if (($group && $space) && ($group->gid != $space->og->gid)) {
    $space = spaces_load('og', og_load($group->gid)->etid);
    $space->activate();
  }

  if ($group && $group->gid) {
     $_SESSION['og_context'] = $group->gid; // this helps set og_context() for the next page click, in case its content belongs to multiple communities
   }

  if ($group || !$space) {
    $b_noredir = 1;
    return;
  }

  // Except for search pages, where we want to keep space as indication of current community search scope.
  // Except for comment pages,
  // Put other exceptions here, if any.
  if (
      strpos($_GET['q'], 'search/') === 0
      ||
      strpos($_GET['q'], 'comment/') === 0
      ) {
    $b_noredir = 1;
    return;
  }

  $purl = '\/' . $space->group->purl;
  $url_np = preg_replace("/$purl/", '/', $_SERVER['REQUEST_URI'], 1);
  $url_np = preg_replace('/\/\//', '/', $url_np, 1);
  header('Location: ' . $url_np, TRUE, 301);
  exit;
}

/**
 * Implements template_preprocess_page().

function datagov_preprocess_page(&$vars) {
  // check if we are at home page
  if (current_path() == 'node/23') { // TODO: this is 'home' community node, is there a way to dynamically find this?
    // clear out title, we do not want to render it
    $vars['is_skip_title'] = TRUE;
  }


  if (current_path() == 'communities') { // only load on communities home page
    // TODO: remove necessity of loading jQuery UI manually (currently it's not loading for anonymous users)
      drupal_add_js('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js', 'external');
      drupal_add_css('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css', 'external');

    drupal_add_css(drupal_get_path('theme', 'datagov') . '/glDatePicker-v1.3/css/default.css');
    drupal_add_js(drupal_get_path('theme', 'datagov') . '/glDatePicker-v1.3/js/glDatePicker-modified.js'); // TODO: move out modifications and use original version

    drupal_add_js(drupal_get_path('theme', 'datagov') . '/js/block-toggler.js');
    drupal_add_js(drupal_get_path('theme', 'datagov') . '/js/read-more-link.js');
    drupal_add_js(drupal_get_path('theme', 'datagov') . '/js/communities-hub-resize.js');
    drupal_add_js(drupal_get_path('theme', 'datagov') . '/js/slider-controls.js');
    drupal_add_js(drupal_get_path('theme', 'datagov') . '/js/community-events.js');
    drupal_add_js(drupal_get_path('theme', 'datagov') . '/js/featured-feeds.js');
    drupal_add_js(drupal_get_path('theme', 'datagov') . '/js/upcoming-events-dateblocks.js');

    $vars['scripts'] = drupal_get_js(); // necessary in D7?
  }
}
*/
/**
 * Implements template_preprocess_region().
 */
function datagov_preprocess_region(&$variables) {
  if (current_path() == 'communities' && $variables['region'] == 'content') {
    if (count($variables['classes_array'])) {
      foreach ($variables['classes_array'] as $key => $value) {
        if ($value == 'grid12-12') {
          unset($variables['classes_array'][$key]);
        }
      }
    }
    $variables['classes_array']['communities-hub'] = 'communities-hub';
  }
}

/**
 * Implements template_preprocess_node().
 */
function datagov_preprocess_node(&$variables) {
  if ($variables['teaser'] && $variables['comment_count'] === '0') { // explicitly generate a comments link if there are zero comments
    $new_arr = array(
      'comment-comments' => array(
        'title' => '0 comments',
        'href' => 'node/' . $variables['node']->nid,
        'attributes' => array('title' => "No comments."),
        'fragment' => 'comments',
        'html' => TRUE,
      )
    );
    foreach ($variables['content']['links']['comment']['#links'] as $key => $value) {
      $new_arr[$key] = $value;
    }
    $variables['content']['links']['comment']['#links'] = $new_arr;
  }

  // remove username blog link (e.g.: "admin's blog")
    if (isset($variables['content']['links']['blog']['#links']['blog_usernames_blog'])) {
    unset($variables['content']['links']['blog']['#links']['blog_usernames_blog']);
    }

    if ($variables['type']!= 'data' || $variables['view_mode']!= 'full') {
     return;
    }
    $node = node_load(arg(1));
    $field_overall = field_view_field('node', $node, 'field_overall','default');
    $variables['fivestar_overall'] = drupal_render($field_overall);
    $field_data_utility = field_view_field('node', $node, 'field_data_utility','default');
    $variables['fivestar_utility'] = drupal_render($field_data_utility);
    $field_usefulness = field_view_field('node', $node, 'field_usefulness','default');
    $variables['fivestar_usefulness'] = drupal_render($field_usefulness);
    $field_ease_of_access = field_view_field('node', $node, 'field_ease_of_access','default');
    $variables['fivestar_easeofaccess'] = drupal_render($field_ease_of_access);

}

/**
 * Implements template_preprocess_html().
 */
function datagov_preprocess_html(&$variables) {
  if(arg(0)=='node' && is_numeric(arg(1))) {
    $node = node_load(arg(1));

    if (is_within_community($node, $group_entity_type, $etid)) {
      $base_class = 'datagov-community';
      $variables['classes_array'][] = $base_class;

      // determine the community we are in (e.g.: Education)
      $group_obj = og_get_group($group_entity_type, $etid);
      $group_safe_name = str_replace(' ', '-', strtolower($group_obj->label));
      $base_class .= '-' . $group_safe_name;
      $variables['classes_array'][] = $base_class;

      // determine if we are in a subpage (e.g.: Education > Apps)
      if ($node->type != 'community') {
        $safe_name = str_replace(' ', '-', strtolower($node->type));
        $base_class .= '-' . $safe_name;
        $variables['classes_array'][] = $base_class;
      }
    }
  }
}

/**
 * Implements template_preprocess_block().
 */
function datagov_preprocess_block(&$variables) {
  if(arg(0)=='node' && is_numeric(arg(1))) {
    $node = node_load(arg(1));

    if (is_within_community($node, $group_entity_type, $etid)) {
      $group_obj = og_get_group($group_entity_type, $etid);
      $community_name = $group_obj->label;
      // Previously we were using $community_node = node_load($group_obj->etid) and $community_node->path['source'] for the
      // community-name link. we are not sure why it stops working now.
      // for now we change it to drupal_get_path_alias method.

      // do we have a release label (e.g.: Beta) to display after the community name?
        $community_node = node_load($group_obj->etid);
        $release_label = '';
        if ($release_tid = $community_node->field_release_label['und'][0]['tid']) {
          $release_label = '<h2 class="community-release-label">' . taxonomy_term_load($release_tid)->name . '</h2>';
        }

      // display community name and (optionally) release label
        $variables['community_label'] = '
          <div class="community-label">
            <span>/</span>
            <h1 class="community-name">' . l($community_name, drupal_get_path_alias("node/$group_obj->etid")) . '</h1>
            ' . $release_label . '
          </div>
        ';
    }

    // prepare breadcrumb for pages within a community (excluding community home page)
    if (isset($node->group_audience['und'][0])) { // TODO: handle content that may belong to multiple communities
      datagov_rebuild_breadcrumbs($node); // rebuild breadcrumbs to prevent spaces OG fom taking over
      $variables['community_breadcrumb'] = theme(
        'grid_block',
        array(
          'content' => theme('breadcrumb', array('breadcrumb' => drupal_get_breadcrumb())),
          'id' => 'breadcrumbs'
        )
      );
    }
  }
}

function datagov_preprocess_views_view(&$vars) {
    $view = $vars['view'];
    $from = ($view->query->pager->current_page * $view->query->pager->options['items_per_page']) + 1;
    $to = $from + count($view->result) - 1;
    $total = $view->total_rows;
    $counter_html = '<div class="clearfloat"></div><div class="views-result-count">';
    if (empty($view->total_rows)) {
        // if there are no results
        $counter_html .= '';
    }
    elseif ($total <= $view->query->pager->options['items_per_page']) {
        // If there's no pager, just print the total.
       // $counter_html .= $total . ' results.';
        $counter_html .= 'Showing ' . $from . ' - ' . $to . ' of '. $total . ' results.';
    }else {
        // Otherwise, show "Showing X - X of XX results."
        $counter_html .= 'Showing ' . $from . ' - ' . $to . ' of '. $total . ' results.';
    }
    $counter_html .= '</div><div class="clearfloat"></div>';

    $vars['counter'] = $counter_html;
}

/**
 * Utility function to determine if we are in a community
 */
function is_within_community($node, &$group_entity_type, &$etid) {
  $is_within_community = FALSE;
  if (isset($node->group_group['und'][0]['value'])) {
    $is_within_community = TRUE;
    $group_entity_type = 'node';
    $etid = $node->nid;
  }
  if (isset($node->group_audience['und'][0])) { // TODO: handle content that may belong to multiple communities
    $is_within_community = TRUE;
    $group_entity_type = 'group';
    $etid = og_context()->gid;
  }

  return $is_within_community;
}


// Rewrite function from theme_tagadelic_weighted in file tagadelic.module 
function datagov_tagadelic_weighted(array $vars) {
  $terms = $vars['terms'];
  $output = '';

  foreach ($terms as $term) {
    $output .= '<a href="?field_dataset_vocabulary_tid=' . $term->name . '" title="' . $term->description . '" class="tagadelic level' . $term->weight . '">' . $term->name . '</a>' . " \n";
  }
  return $output;
}


/**
 * Utility function. Custom breadcrumbs module tries to 'fix' double-slashes in path, but it messes up things like 'http://'
 */
function fix_double_slash($bc) {
  $patterns = array('/:\/([^\/])/');
  $replacements = array('://$1');
  return preg_replace($patterns, $replacements, $bc);
}

/**
 * Implements theme_link().
 */
function datagov_link(&$variables) {
  $is_comment_count_link = FALSE;
  /**
   * match a number + [space] + the word 'comment' or 'comments'
   * e.g.: 0 comments, 1 comment, 2 comments, 145 comments
   * however, do not match 'Add new comment'
   */
  if (preg_match('/[\d]+ comment[s]*/', $variables['text'])) {
    $is_comment_count_link = TRUE;
  }

  if ($is_comment_count_link) {
    return '
      <span class="comment-bubble-container">
        <a href="' . check_plain(url($variables['path'], $variables['options'])) . '"' . drupal_attributes($variables['options']['attributes']) . '>
          ' . intval($variables['options']['html'] ? $variables['text'] : check_plain($variables['text'])) . '</a>
      </span>
      comment(s)
      |
    ';
  }

  return theme_link($variables);
}

/**
 * Utility function for generating special CSS for communities like Energy.
 * TODO: deprecate this ASAP
 */
function getDesignkitBgCss($hexColor, $index = FALSE) {
  $images = array(
    'slider_bg' => 'background:transparent url("/sites/all/themes/datagov/images/communityBannerBg.png") no-repeat 0 0;',
    'read_more_bg' => 'background-image: url("/sites/all/themes/datagov/images/search-bg.png");',
    'slider_control_left' => 'background-image: url("/sites/all/themes/datagov/images/slide-arrow-left.jpg");',
    'slider_control_pause' => 'background-image: url("/sites/all/themes/datagov/images/slide-pause.jpg");',
    'slider_control_right' => 'background-image: url("/sites/all/themes/datagov/images/slide-arrow-right.jpg");',
    'join_community_button' => 'background-image: url("/sites/all/themes/datagov/images/join-community-bg.png");',
  );

  // TODO: instead of matching on a hex color, match based on OG group or Group ID
  if (strtolower($hexColor) == '#4b712d') { // 'Green' Community - i.e. Energy
    $images = array(
      'slider_bg' => 'background:transparent url("/sites/all/themes/datagov/images/showcase-energy-bg-resized.png") no-repeat 0 0;',
      'read_more_bg' => 'background-image: url("/sites/all/themes/datagov/images/search-bg-energy.png");',
      'slider_control_left' => 'background-image: url("/sites/all/themes/datagov/images/slide-arrow-left-energy.jpg");',
      'slider_control_pause' => 'background-image: url("/sites/all/themes/datagov/images/slide-pause-energy.jpg");',
      'slider_control_right' => 'background-image: url("/sites/all/themes/datagov/images/slide-arrow-right-energy.jpg");',
      'join_community_button' => 'background-image: url("/sites/all/themes/datagov/images/join-community-bg-energy.png");',
    );
  }

  if (!$index) return $images;
  return $images[$index];
}

/**
 * Rebuild breadcrumbs since Custom Breadcrumb module can't handle nodes that belong to multiple communities
 */
function datagov_rebuild_breadcrumbs($node) {
  // mostly taken from custom_breadcrumbs_node_view()
    if ($breadcrumb = _custom_breadcrumbs_load_for_type($node)) {
      $titles = preg_split("/[\n]+/", $breadcrumb->titles);
      $paths = preg_split("/[\n]+/", $breadcrumb->paths);

      $trail = array();
      for ($i = 0; $i < count($titles); $i++) {
        $data = array('node' => $node);
        $title = token_replace(_populate_selected_community(trim($titles[$i]), og_context()->gid), $data, array('clear'=>TRUE));
        if (($title != '') && ($title != '<none>')) {
          $path = token_replace(_populate_selected_community_url(trim($paths[$i]), og_context()->gid), $data, array('clear'=>TRUE));
          // Create breadcrumb only if there is a title.
          $trail[] = _custom_breadcrumbs_create_crumb($title, $path);
        }
      }
      drupal_set_breadcrumb($trail);
    }

  $breadcrumbs_to_insert = array(
    l(t('Data.gov'), '', array('purl' => array('disabled' => TRUE))),
    l(t('Communities'), 'communities', array('purl' => array('disabled' => TRUE))),
  );
  $breadcrumb = array_unique(drupal_get_breadcrumb());
  $breadcrumb = array_merge($breadcrumbs_to_insert, $breadcrumb);
  $breadcrumb = fix_double_slash($breadcrumb);
  drupal_set_breadcrumb($breadcrumb);
}

function _populate_selected_community($str, $gid) {
  $str = str_ireplace('[selected_community]', og_get_group('group', $gid)->label, $str);
  return $str;
}

function _populate_selected_community_url($str, $gid) {
  $str = str_ireplace('[selected_community_url]', drupal_get_path_alias("node/" . og_get_group('group', $gid)->etid), $str);
  return $str;
}

function datagov_preprocess_username(&$vars) {

    // Update the username so it's the full name of the user.
    $account = $vars['account'];

    // Revise the name trimming done in template_preprocess_username.
    $name = $vars['name_raw'] = format_username($account);

    // Trim the altered name as core does, but with a higher character limit.
    if (drupal_strlen($name) > 25) {
        $name = drupal_substr($name, 0, 100);
    }

    // Assign the altered name to $vars['name'].
    $vars['name'] = check_plain($name);
}

function datagov_form_views_exposed_form_alter(&$form, $form_state) {
  // sort out the multiselect options
  foreach($form_state['view']->filter as $filter) {
    if($fid = $filter->options['expose']['identifier']) asort($form[$fid]['#options']);
  }
}
