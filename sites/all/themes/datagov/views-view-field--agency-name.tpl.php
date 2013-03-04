<?php
 /**
  * This template is used to print a single field in a view. It is not
  * actually used in default Views, as this is registered as a theme
  * function which has better performance. For single overrides, the
  * template is perfectly okay.
  *
  * Variables available:
  * - $view: The view object
  * - $field: The field handler object that can process the input
  * - $row: The raw SQL result that can be used
  * - $output: The processed output that will normally be used.
  *
  * When fetching output from the $row, this construct should be used:
  * $data = $row->{$field->field_alias}
  *
  * The above will guarantee that you'll always get the correct data,
  * regardless of any changes in the aliasing that might happen if
  * the view is modified.
  */
?>
<?php
if(empty($row->dataset_counts_subagency_name)) {
  $name = '<span class="main"> <a href="/list/agency/' . $row->dataset_counts_agency_id . '/*">' . $row->dataset_counts_agency_name . ' (' . $row->dataset_counts_agency_abbr . ') </a></span>';
}
else {
  // if subagency_id = agency_id, it means Department/Agency Level.
  if ($row->dataset_counts_subagency_id == $row->dataset_counts_agency_id) {
    $row->dataset_counts_subagency_id = 0;
  }
  $name = '<span class="sub"> <a href="/list/agency/' . $row->dataset_counts_agency_id  . '/' . $row->dataset_counts_subagency_id . '">' . $row->dataset_counts_subagency_name . ' (' . $row->dataset_counts_subagency_abbr . ') </a></span>';
}

print $name;
?>
