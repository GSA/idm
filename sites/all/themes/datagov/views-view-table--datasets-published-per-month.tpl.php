<?php
/**
 * @file views-view-table.tpl.php
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $header_classes: An array of header classes keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * - $field_classes: An array of classes to apply to each field, indexed by
 *   field id, then row number. This matches the index in $rows.
 * @ingroup views_templates
 */

$start_date = strtotime(date('Y-M', time()) . ' - 11 months');

$calendar = array(date('y', $start_date) => array(date('M', $start_date) => 1));

for($i = 0; $i <= 11; $i++) {
  $temp_date = strtotime(date('Y-M-d', $start_date) . '+' . $i . ' months');

  $cal_month = date('M', $temp_date);
  $cal_year = date('y', $temp_date);

  $calendar[$cal_year][$cal_month] = 0;
}

$summary_table_headers = array(
  'Agency Name',
  'published_datasets' => $calendar,
  'Total in the Past 12 Months' => 0,
);

$summary_table_rows = array();

foreach($rows as $index => $value){
  $month = date('M', strtotime($value['dataset_last_updated'])); 
  $year = date('y', strtotime($value['dataset_last_updated'])); 
  $full_name = $value['full_name'];

  if(isset($summary_table_rows[$full_name]['published_datasets'][$year][$month])) {
    $summary_table_rows[$full_name]['published_datasets'][$year][$month] += 1;
    $summary_table_rows[$full_name]['agency_id'] = $value['agency_id'];
  }
  else {
    $summary_table_rows[$full_name]['published_datasets'][$year][$month] = 1;
  }
}

$total_months = 0;

foreach($calendar as $year => $month_key) {
  $total_months += count($month_key);
}
?>


<table <?php if ($classes) { print 'class="'. $classes . ' datasets_published_per_month_table' . '" '; } ?><?php print $attributes; ?>>
  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>
  <?php if (!empty($header)) : ?>
    <thead class="datasets_published_per_month_thead">
      <tr class="datasets_published_per_month_row_tr_head">
        <?php foreach ($header as $field => $label): ?>
          <?php if($field == 'agency_id') {continue; } ?>
          <th 
              <?php if ($field == 'dataset_last_updated') { print 'colspan="'. $total_months . '" '; } else { print 'rowspan="2" '; } ?> 
              <?php if ($header_classes[$field]) { print 'class="'. $header_classes[$field] . ' datasets_published_per_month_table_head_fields" '; } ?>
          scope="col" id="<?php
if ($field == 'full_name') 
  $header_id = 'C_AgencyName';
else if ($field == 'dataset_last_updated')
  $header_id = 'C_NumberofDatasetsampToolspublishedbymonth';
else if ($field == 'nothing')   
  $header_id = 'C_TotalinthePast12Months'; 

echo $header_id; ?>">
            <?php print $label; ?>
          </th>
        <?php endforeach; ?>
      </tr>
      <tr class="datasets_published_per_month_row_tr_head">
<?php

  foreach($calendar as $year => $month_key) {
    foreach($month_key as $month => $value) {
      echo '<th class="datasets_published_per_month_table_head_calendar">';
      echo '<span class="datasets_published_month">' .  $month . '</span><br/>';
      echo '<span class="datasets_published_year">' . "'" .$year . '</span>';
      echo '</th>';
    }   
  }
?>
      </tr>
    </thead>
    <tbody class="datasets_published_per_month_tbody">
<?php
$count = 0;

foreach($summary_table_rows as $agency_name => $data_row) {
  $even = $count++ % 2;
  $suffix = ($even == 0) ? 'even even':'odd odd';
  $agency_id = $data_row['agency_id'];

  echo '<tr class="datasets_published_per_month_row_tr_' . $suffix . '">';
  echo '<td class="datasets_published_per_month_table_row_fields">' . $agency_name . '</td>';

  $total = 0;

  foreach($calendar as $year => $month_key) {
   foreach($month_key as $month => $value) {
      echo '<td class="datasets_published_per_month_table_row_calendar">';
      if(isset($data_row['published_datasets'][$year][$month])) {
        $total +=  $data_row['published_datasets'][$year][$month];
        echo '<a href="/list/agency/monthly/' . $agency_id . '/20' . $year . '/' . date("m", strtotime($month)) . '">' . $data_row['published_datasets'][$year][$month] . '</a>';
      }
      else {
        echo '-';
      }

      echo  '</td>';
    }
  }
  echo '<td datasets_published_per_month_table_row_total>' . '<a href="/list/agency/monthly/' . $agency_id . '/20' . $year . '/*">'  .  $total . '</a></td>';

  echo '</tr>';
}

echo '</tbody>';

$total_row = array();

foreach($summary_table_rows as $agency_name => $data_row) {
  foreach($calendar as $year => $month_key) {
    foreach($month_key as $month => $value) {
      if(isset($data_row['published_datasets'][$year][$month])) {
        if(isset($total_row[$year][$month])) {
          $total_row[$year][$month] += $data_row['published_datasets'][$year][$month];
        }
        else {
          $total_row[$year][$month] = $data_row['published_datasets'][$year][$month];
        }
      }
    }
  }
}

echo '<thead>';
echo '<tr>';
echo '<td>Total</td>';

$total_sum = 0;

foreach($calendar as $year => $month_key) {
  foreach($month_key as $month => $value) {
    if(!empty($total_row[$year][$month])) {
      echo '<td>' . $total_row[$year][$month] . '</td>';
      $total_sum += $total_row[$year][$month];
    }
    else {
      echo '<td> - </td>';
    }
  }
}

echo '<td>' . $total_sum . '</td>';

echo '</tr>';
echo '</thead>';

?>
  <?php endif; ?>

</table>
