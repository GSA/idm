<?php
// TODO: move this functionality out of tpl file (template.php?)
  $page['#theme_wrappers'] = array();
  $page['#contextual_links'] = array();
  $page['#views_contextual_links_info'] = array();
?>

<h3><?php print $title ?></h3>
<?php print render($page['content']); ?>