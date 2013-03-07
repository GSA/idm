<?php

/**
 * @file
 * Fusion theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all, or
 *   print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct url of the current node.
 * - $terms: the themed list of taxonomy term links output from theme_links().
 * - $display_submitted: whether submission information should be displayed.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the following:
 *   - node: The current template type, i.e., "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type, i.e. story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
 * - $id: Position of the node. Increments each time it's output.
 *
 * Node status variables:
 * - $view_mode: View mode, e.g. 'full', 'teaser'...
 * - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
 * - $page: Flag for the full page state.
 * - $promote: Flag for front page promotion state.
 * - $sticky: Flags for sticky post setting.
 * - $status: Flag for published status.
 * - $comment: State of comment settings for the node.
 * - $readmore: Flags true if the teaser content of the node cannot hold the
 *   main body content.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 *
 * Field variables: for each field instance attached to the node a corresponding
 * variable is defined, e.g. $node->body becomes $body. When needing to access
 * a field's raw values, developers/themers are strongly encouraged to use these
 * variables. Otherwise they will have to explicitly specify the desired field
 * language, e.g. $node->body['en'], thus overriding any language negotiation
 * rule that was previously applied.
 *
 * @see template_preprocess()
 * @see template_preprocess_node()
 * @see template_process()
 */
?>
<?php
function print_link($x) {
  $original = explode('; ', $x); // ; followed by space indicates the end of a url
  $temp = array();
  foreach ($original as $value) {
    $temp[] = _filter_url($value, -1);
  }
  $modified = implode('; ', $temp);
  echo $modified;
}
?>

<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <?php print $user_picture; ?>

  <?php print render($title_prefix); ?>
  <?php if (!$page): ?>
    <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
  <?php endif; ?>
  <?php print render($title_suffix); ?>

  <?php if ($display_submitted || !empty($content['links']['terms'])): ?>
    <div class="meta">
      <?php if ($display_submitted && isset($submitted) && $submitted): ?>
        <span class="submitted"><?php print $submitted; ?></span>
      <?php endif; ?>

      <?php if (!empty($content['links']['terms'])): ?>
        <div class="terms terms-inline">
          <?php print render($content['links']['terms']); ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endif; ?>

  <?php if (!$teaser): ?>
    <div id="node-top" class="node-top region nested">
      <?php print render($node_top); ?>
    </div>
  <?php endif; ?>
  
  <div class="content"<?php print $content_attributes; ?>>
    <?php
      // We hide the comments and links now so that we can render them later.
      hide($content['comments']);
      hide($content['links']);
      //print render($content);
/* Start customization */
// $datasetInfo is prepared in module file.
?>

<?php
    // Current theme has not room for node title. Borrow pane/block title for style
?>
<h2 class="pane-title block-title"><?php print $title; ?></h2>
 <div class="detail">
<a name="description"></a>
<div class="detail-left">
<div class="categories">
<div class="detail-header"><h2>Dataset Summary</h2></div>
<table border="0" cellpadding="0" cellspacing="0" class="details-table">
    <tbody>
        <tr>
            <td align="left" valign="top"
                nowrap="nowrap" class="detailhead1 pad-top tablepad">Agency</td>
            <td align="left" valign="top" class="pad-top tablepad"><?php echo $datasetInfo->agency_name;?></td>
        </tr>
        <tr>
            <td align="left" valign="top"
                nowrap="nowrap" class="detailhead1 pad-top tablepad">Sub-Agency/Organization</td>
            <td align="left" valign="top" class="pad-top tablepad"><?php echo $datasetInfo->subagency_name;?></td>
        </tr>
        <tr>
            <td align="left" valign="top" nowrap="nowrap" class="detailhead1 tablepad">
                Category
            </td>
            <td align="left" valign="top" class="data tablepad"><?php echo $datasetInfo->category_name; ?></td>
        </tr>
        <tr>
            <td valign="top"
                nowrap="nowrap" class="detailhead1 tablepad">Date Released</td>
            <td align="left" valign="top" class="data tablepad"><?php echo $datasetInfo->date_released;?></td>
        </tr>
        <tr>
            <td align="left" valign="top"
                nowrap="nowrap" class="detailhead1 tablepad">Date Updated</td>
            <td align="left" valign="top" class="data tablepad"><?php echo $datasetInfo->date_updated;?></td>
        </tr>
        <tr>
            <td align="left" valign="top"
                nowrap="nowrap" class="detailhead1 tablepad">Time Period</td>
            <td align="left" valign="top" class="data tablepad">
            <?php echo $datasetInfo->temporal_coverage ?>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top"
                nowrap="nowrap" class="detailhead1 tablepad">Frequency
            </td>
            <td align="left" valign="top" class="data tablepad"><?php echo $datasetInfo->periodicity;?></td>
        </tr>

        <tr>
            <td align="left" valign="top"
                nowrap="nowrap" class="detailhead1 tablepad">Description
                <?php
                if($datasetInfo->public_suggested=='Y') {?>
                <br/>
                <img id='tooltip_public_suggested_dataset' src="<?php print '/'.path_to_theme().'/images/public_suggested.gif' ?>" alt="Dataset suggested by public" title="Dataset suggested by public"/>
                <?php }?>
            </td>
            <td align="left" valign="top" class="data tablepad">
            <?php
            /** Removed "more" logic 05182011 Will display full description on all nodes now. */
            //$descriptionDisplayCharacters = 400;
            $descriptionText = _filter_url($datasetInfo->description);
            //Display description if it will fit within allowable display
            //if(strlen($descriptionText) <= $descriptionDisplayCharacters){
            echo $descriptionText;
            //}
            //else{
            //    $firstPart = substr($descriptionText, 0, $descriptionDisplayCharacters);
            //    $secondPart = substr($descriptionText, $descriptionDisplayCharacters);
            //    echo $firstPart;
            //    echo "<span id='description_text' class='collapsible'>$secondPart</span>&nbsp;<a id='description' onclick=\"return toggleCollapsible('description');\" href=\"#description\">(more)</a>";
            //}
            ?>
            </td>
        </tr>
    </tbody>
</table>
</div>


<div class="categories">
    <div class="detail-header"><h2>Dataset Ratings</h2></div>
    <table border="0" cellpadding="0" cellspacing="0" class="details-table" >
        <tbody>
        <tr>
            <td class="detailhead1 tablepad">Overall</td>
            <td class="tablepad data"><?php print $fivestar_overall; ?></td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Data Utility</td>
            <td class="tablepad data"><?php print $fivestar_utility; ?></td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Usefulness</td>
            <td class="tablepad data"><?php print $fivestar_usefulness; ?></td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Ease of Access</td>
            <td class="tablepad data"><?php print $fivestar_easeofaccess; ?></td>
        </tr>
        </tbody></table></div>



<div class="categories">
    <div class="detail-header"><h2>Dataset Metrics</h2></div>
    <table border="0" cellpadding="0" cellspacing="0" class="details-table" >
    <tbody>
                  <tr>
                  <?php
                  $tooltip = "";
                  if($datasetInfo->data_category_type_id == 1){
                        $tooltip = "Download represents the number of times users have clicked on <br/>
                                XML / CSV / XLS / KML/KMZ /Shapefile / Maps in the Download Information section.";

                  }else{
                    $tooltip = "Download represents the number of times users have clicked on <br/>
                                Data Extraction / Feeds / Widgets in the Download Information section.";

                  }

                  ?>
            <td class="detailhead1 tablepad"
            title='<?php echo $tooltip?>'
                        id='tooltipTd'>Number of Downloads</td>
            <td class="tablepad data">
                      <?php
                      echo ($datasetInfo->count!=null) ?
                            number_format($datasetInfo->count)
                            :"0";
                      ?>
                      </td>
                  </tr>
</tbody></table></div>

<div class="categories">
    <div class="detail-header"><h2>Dataset Information</h2></div>
    <table border="0" cellpadding="0" cellspacing="0" class="details-table" >
    <tbody>
        <tr>
            <td class="detailhead1 tablepad">
            <div class="pad-top">Data.gov Data Category Type</div>
            </td>
            <td class="tablepad data">
            <div class="pad-top"><?php echo $datasetInfo->data_category_type_name; ?></div>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Specialized Data
            Category Designation</td>
            <td class="tablepad data"><?php echo $datasetInfo->data_specialized_category_name;?></td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Keywords</td>
            <td class="tablepad data"><?php echo $datasetInfo->keywords; ?></td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Unique ID</td>
            <td class="tablepad data"><?php echo $datasetInfo->unique_id;?></td>
        </tr>
    </tbody>
</table>
</div>
<div class="categories">
    <div class="detail-header"><h2>Contributing Agency Information</h2></div>
    <table border="0" cellpadding="0" cellspacing="0" class="details-table">
    <tbody>
        <tr>
            <td class="detailhead1 tablepad">
            <div class="pad-top">Citation</div>
            </td>
            <td class="tablepad data">
            <div class="pad-top"><?php print_link($datasetInfo->citation);?></div>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Agency Program Page</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->agency_program_page);?></td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Agency Data Series Page</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->agency_data_series_page);?></td>
        </tr>
    </tbody>
</table>
</div>
<div class="categories">
    <div class="detail-header"><h2>Dataset Coverage</h2></div>
    <table border="0" cellpadding="0" cellspacing="0" class="details-table">
    <tbody>
        <tr>
            <td class="detailhead1 tablepad">
            <div class="pad-top">Unit of Analysis</div>
            </td>
            <td class="tablepad data">
            <div class="pad-top"><?php echo $datasetInfo->unit_of_analysis;?></div>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Granularity</td>
            <td class="tablepad data"><?php echo $datasetInfo->granularity;?></td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Geographic Coverage</td>
            <td class="tablepad data"><?php echo $datasetInfo->geographic_coverage;?></td>
        </tr>
    </tbody>
</table>
</div>
<div class="categories">
    <div class="detail-header"><h2>Data Description</h2></div>
    <table border="0" cellpadding="0" cellspacing="0" class="details-table">
    <tbody>
        <tr>
            <td class="detailhead1 tablepad">
            <div class="pad-top">Collection Mode</div>
            </td>
            <td class="tablepad data">
            <div class="pad-top"><?php echo $datasetInfo->collection_mode;?></div>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Data
            Collection Instrument</td>
            <td class="tablepad data"><?php print_link($datasetInfo->collection_instrument);?></td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Data
            Dictionary/Variable List</td>
            <td class="tablepad data"><?php print_link($datasetInfo->dictionary_list); ?></td>
        </tr>
    </tbody>
</table>
</div>
<div class="categories">
<div class="detail-header"><h2>Additional Dataset Documentation</h2></div>
<table border="0" cellpadding="0" cellspacing="0" class="details-table">
    <tbody>
        <tr>
            <td class="detailhead1 tablepad">
            <div class="pad-top">Technical Documentation</div>
            </td>
            <td class="tablepad data">
            <div class="pad-top"><?php print_link($datasetInfo->technical_documentation);?></div>
            </td>
        </tr>
        <?php if($datasetInfo->data_specialized_category_id == 3) { //Only display if geospatial ?>
        <tr>
            <td class="detailhead1 tablepad">FGDC Compliance
            (Geospatial Only)</td>
            <td class="tablepad data">
                <?php echo $datasetInfo->fgdc_compliance; ?>
            </td>
        </tr>
        <?php } ?>
        <tr>
            <td class="detailhead1 tablepad">Additional Metadata</td>
            <td class="tablepad data">
<?php if ($datasetInfo->data_category_type_id != 0): ?>
<?php print_link($datasetInfo->additional_metadata);?>
<?php else: ?>
<a href="http://geo.data.gov/geoportal/rest/document?id=%7B<?php echo $datasetInfo->unique_id; ?>%7D">XML Format</a>
<?php endif; ?>
            </td>
        </tr>
    </tbody>
</table>
</div>
<?php if($datasetInfo->data_specialized_category_id  == 2) {  //tools ?>
<div class="categories">
<div class="detail-header"><h2>Statistical Information</h2></div>
<table border="0" cellpadding="0" cellspacing="0" class="details-table">
    <tbody>
        <tr>
            <td class="detailhead1 tablepad">
            <div class="pad-top">Statistical Methodology</div>
            </td>
            <td class="tablepad data">
            <div class="pad-top"><?php print_link($datasetInfo->statistical_methodology); ?></div>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Sampling</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->statistical_sampling);?>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Estimation</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->statistical_estimation); ?>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Weighting</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->statistical_weighting); ?>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Disclosure
            avoidance</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->statistical_disclosure_avoidance); ?>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Questionnaire
            design</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->statistical_questionnaire_design); ?>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Series
            breaks</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->statistical_series_breaks); ?>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Non-response
            adjustment</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->statistical_non_response_adjustment);?>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Seasonal
            adjustment</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->statistical_seasonal_adjustment); ?>
            </td>
        </tr>
        <tr>
            <td class="detailhead1 tablepad">Statistical Characteristics</td>
            <td class="tablepad data">
                <?php print_link($datasetInfo->statistical_data_quality); ?>
            </td>
        </tr>
    </tbody>
</table>
</div>
<?php } ?>
</div>
<div class="sidepad">
<div class="sidebar">
<div class="detail-header"><h2>Download Information</h2></div>
<table border="0" cellpadding="0" cellspacing="0" class="download-table">
    <?php if($datasetInfo->data_category_type_id == 1) { //Instant Download?>
    <tbody>
        <tr>
            <td width="50%" class="catheader2"><!--[if lt IE 7]><a href="javascript:popupxml()">XML<img src="<?php print '/'.path_to_theme().'/images/arrow-blue.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row1">
            <div id="popupdet">
            <p><a href="#">XML<img src="<?php print '/'.path_to_theme().'/images/arrow-blue.gif' ?>" alt="" width="7"
                height="7" /><span><img src="<?php print '/'.path_to_theme().'/images/popup-xml.gif' ?>"
                alt="Used by automated programs capable of handling raw XML files."
                width="176" height="85" /></span></a></p>
            </div>
            </div>
            </td>
            <td class="catheader2"><!--[if lt IE 7]><a href="javascript:popupcsv()">CSV/TXT<img src="<?php print '/'.path_to_theme().'/images/arrow-green.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row1">
            <div id="popupdet">
            <p><a href="#">CSV/TXT<img src="<?php print '/'.path_to_theme().'/images/arrow-green.gif' ?>" alt=""
                width="7" height="7" /><span><img src="<?php print '/'.path_to_theme().'/images/popup-csv.gif' ?>"
                alt="Used for easy access to data through most desktop spreadsheet applications."
                width="176" height="111" /></span></a></p>
            </div>
            </div>
            </td>
        </tr>
        <tr>
            <td class="row-gray small"><?php if($datasetInfo->xml){?> <a
                href="/download/<?php echo $dataset_id; ?>/xml"><img
                src="<?php print '/'.path_to_theme().'/images/download-xml.gif' ?>" alt="xml document" title="xml document" width="41"
                height="13" /><br />
                <?php echo $datasetInfo->xml[0]->file_size; ?></a>
                <?php } else { echo '&nbsp;'; } ?></td>
            <td class="row-gray small"><?php if($datasetInfo->csv){?> <a
                href="/download/<?php echo $dataset_id; ?>/csv"><img
                src="<?php print '/'.path_to_theme().'/images/download-csv.gif' ?>" alt="csv document" title="csv document" width="41"
                height="13" /><br />
                <?php echo $datasetInfo->csv[0]->file_size;; ?></a>
                <?php } else { echo '&nbsp;'; } ?></td>
        </tr>
        <tr>
            <td class="catheader2"><!--[if lt IE 7]><a href="javascript:popupexcel()">XLS<img src="<?php print '/'.path_to_theme().'/images/arrow-purple.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row2">
            <div id="popupdet">
            <p><a href="#">XLS<img src="<?php print '/'.path_to_theme().'/images/arrow-purple.gif' ?>" alt=""
                width="7" height="7" /><span><img src="<?php print '/'.path_to_theme().'/images/popup-excel.gif' ?>"
                alt="File format used with Microsoft Excel." width="176" height="97" /></span></a></p>
            </div>
            </div>
            </td>
            <td class="catheader2"><!--[if lt IE 7]><a href="javascript:popupkml()">KML/KMZ<img src="<?php print '/'.path_to_theme().'/images/arrow-red.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row2">
            <div id="popupdet">
            <p><a href="#">KML/KMZ<img src="<?php print '/'.path_to_theme().'/images/arrow-red.gif' ?>" alt=""
                width="7" height="7" /><span><img src="<?php print '/'.path_to_theme().'/images/popup-kml.gif' ?>"
                alt="Displays geospatial data in Google Earth/Maps, and similar applications."
                width="176" height="85" /></span></a></p>
            </div>
            </div>
            </td>
        </tr>
        <tr>
            <td class="row-gray small"><?php if($datasetInfo->xls){?> <a
                href="/download/<?php echo $dataset_id; ?>/xls"><img
                src="<?php print '/'.path_to_theme().'/images/download-xls.gif' ?>" alt="XLS document"  title="XLS document" width="41"
                height="13" /><br />
                <?php echo $datasetInfo->xls[0]->file_size; ?></a>
                <?php } else { echo '&nbsp;'; } ?></td>
            <td class="row-gray small"><?php if($datasetInfo->kml){?> <a
                href="/download/<?php echo $dataset_id; ?>/kml"><img
                src="<?php print '/'.path_to_theme().'/images/download-kml.gif' ?>" alt="kml document" title="kml document" width="41"
                height="13" /><br />
                <?php echo $datasetInfo->kml[0]->file_size; ?></a>
                <?php
                    $raw_title = $datasetInfo->title;
                    $raw_resource = str_replace('%27','\\\\\\\'',$datasetInfo->kml[0]->access_point);
                    $extension = substr($raw_resource,strrpos($raw_resource,"."));
                    $allowed_extns = array('.kml', '.kmz', '.zip', '.gzip', '.tar', '.xml');
                    if(in_array($extension,$allowed_extns)
                       || (strpos($raw_resource,'service=wms')!=false)
                       || (strpos($raw_resource,'wmsserver')!=false)
                       || (strpos($raw_resource,'com.esri.wms.esrimap')!=false)
                       || (strpos($raw_resource,'com.esri.esrimap.esrimap')!=false)
                       || (strpos($raw_resource,'arcgis/rest')!=false && strpos($raw_resource,'MapServer')!=false)
                       || (strpos($raw_resource,'rest/services')!=false && strpos($raw_resource,'MapServer')!=false)){ ?>
<br/>
<script type="text/javascript">
document.write('<a href="javascript:viewer(\'<?php echo addslashes($raw_title); ?>\',\'<?php echo $raw_resource; ?>\');"><img src="<?php print '/'.path_to_theme().'/images/preview-kml.gif' ?>" alt="Preview Data" height="13" width="60" border="0"/></a>');
</script>
<noscript>
<a href="/dataGovGeoViewer/?configXml=datagov.xml&title=<?php echo urlencode($raw_title); ?>&resource=:<?php echo $raw_resource; ?>" target="_blank"><img src="<?php print '/'.path_to_theme().'/images/preview-kml.gif' ?>" alt="Preview Data" height="13" width="60" border="0"/></a>
</noscript>
                <?php } } else { echo '&nbsp;'; } ?></td>
        </tr>
        <tr>
            <td class="catheader2"><!--[if lt IE 7]><a href="javascript:popupesri()">Shapefile<img src="<?php print '/'.path_to_theme().'/images/arrow-gold.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row3">
            <div id="popupdet">
            <p><a href="#">Shapefile<img src="<?php print '/'.path_to_theme().'/images/arrow-gold.gif' ?>" alt="" width="7"
                height="7" /><span><img src="<?php print '/'.path_to_theme().'/images/popup-esri.gif' ?>"
                alt="Used by ESRI-compatible mapping applications and are updated monthly/quarterly."
                width="176" height="120" /></span></a></p>
            </div>
            </div>
            </td>
            <td class="catheader2">Maps</td>
        </tr>
        <tr>
            <td class="row-gray small"><?php if($datasetInfo->esri){?>
            <a
                href="/download/<?php echo $dataset_id; ?>/esri"><img
                src="<?php print '/'.path_to_theme().'/images/download-esri.gif' ?>" alt="Shapefile document" title="Shapefile document" width="41"
                height="13" /><br />
                <?php echo $datasetInfo->esri[0]->file_size; ?></a>
                <?php
                    $raw_title = $datasetInfo->title;
                    $raw_resource = str_replace('%27','\\\\\\\'',$datasetInfo->esri[0]->access_point);
                    $extension = substr($raw_resource,strrpos($raw_resource,"."));
                    $allowed_extns = array('.kml', '.kmz', '.zip', '.gzip', '.tar', '.xml');
                    if(in_array($extension,$allowed_extns)
                       || (strpos($raw_resource,'service=wms')!=false)
                       || (strpos($raw_resource,'wmsserver')!=false)
                       || (strpos($raw_resource,'com.esri.wms.esrimap')!=false)
                       || (strpos($raw_resource,'com.esri.esrimap.esrimap')!=false)
                       || (strpos($raw_resource,'arcgis/rest')!=false && strpos($raw_resource,'MapServer')!=false)
                       || (strpos($raw_resource,'rest/services')!=false && strpos($raw_resource,'MapServer')!=false)){ ?>
<br/>
<script type="text/javascript">
document.write('<a href="javascript:viewer(\'<?php echo addslashes($raw_title); ?>\',\'<?php echo $raw_resource; ?>\');"><img src="<?php print '/'.path_to_theme().'/images/preview-esri.gif' ?>" alt="Preview Data" height="13" width="60" border="0"/></a>');
</script>
<noscript>
<a href="/dataGovGeoViewer/?configXml=datagov.xml&title=<?php echo urlencode($raw_title); ?>&resource=:<?php echo $raw_resource; ?>" target="_blank"><img src="<?php print '/'.path_to_theme().'/images/preview-esri.gif' ?>" alt="Preview Data" height="13" width="60" border="0"/></a>
</noscript>
                <?php } } else { echo '&nbsp;'; } ?></td>
            <td class="row-gray map">
            <?php if($datasetInfo->map) { ?>
            <a href="<?php echo '/externallink/map/' . rawurlencode(str_replace('/', '###', $datasetInfo->map[0]->access_point)) . '/' . rawurlencode(str_replace('/', '###', $_SERVER['REQUEST_URI'])) ?>">View Map</a>
            <?php } else { echo "&nbsp;"; } ?>
            </td>
        </tr>
        <tr>
            <td width="50%" class="catheader2"><!--[if lt IE 7]><a href="javascript:popupxml()">RDF<img src="<?php print '/'.path_to_theme().'/images/arrow-darkblue.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row4">
            <div id="popupdet">
            <p><a href="#">RDF<img src="<?php print '/'.path_to_theme().'/images/arrow-darkblue.gif' ?>" alt="" width="7"
                height="7" /><span><img src="<?php print '/'.path_to_theme().'/images/popup-rdf.gif' ?>"
                alt="Used by automated programs capable of handling RDF files."
                width="176" height="85" /></span></a></p>
            </div>
            </div>
            </td>
            <td width="50%" class="catheader2"><!--[if lt IE 7]><a href="javascript:popupxml()">PDF<img src="<?php print '/'.path_to_theme().'/images/arrow-pdfred.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row4">
            <div id="popupdet">
            <p><a href="#">PDF<img src="<?php print '/'.path_to_theme().'/images/arrow-pdfred.gif' ?>" alt="" width="7"
                height="7" /><span><img src="<?php print '/'.path_to_theme().'/images/popup-pdf.gif' ?>"
                alt="Portable Document Format files."
                width="176" height="265" /></span></a></p>
            </div>
            </div>
            </td>
        </tr>
        <tr>
            <td class="row-gray small"><?php if($datasetInfo->rdf){?> <a
                href="<?php echo $datasetInfo->rdf[0]->access_point; ?>"><img
                src="<?php print '/'.path_to_theme().'/images/download-rdf.gif' ?>" alt="RDF document" title="RDF document" width="41"
                height="13" /><br />
                <?php echo $datasetInfo->rdf[0]->file_size; ?></a>
                <?php } else { echo '&nbsp;'; } ?></td>
            <td class="row-gray small"><?php if($datasetInfo->pdf){?> <a
                href="<?php echo $datasetInfo->pdf[0]->access_point; ?>"><img
                src="<?php print '/'.path_to_theme().'/images/download-pdf.gif' ?>" alt="PDF document" title="PDF document" width="22"
                height="23" /><br />
                <?php echo $datasetInfo->pdf[0]->file_size; ?></a>
                <?php } else { echo '&nbsp;'; } ?></td>
        </tr>
    </tbody>
    <?php } else if ($datasetInfo->data_category_type_id == 2) { // Tools ?>
    <tbody>
        <tr>
            <td width="70%" class="catheader3"><!--[if lt IE 7]><a href="javascript:popupext()">Data Extraction<img src="<?php print '/'.path_to_theme().'/images/arrow-black.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row1">
            <div id="popupdet">
            <p><a href="#">Data Extraction<img src="<?php print '/'.path_to_theme().'/images/arrow-black.gif' ?>"
                alt="" width="7" height="7" /><span><img
                src="<?php print '/'.path_to_theme().'/images/popup-extraction.gif' ?>"
                alt="Allows you to select a databasket full of variables and then recode those variables in a form that the user desires. The user can then develop and customize tables. Selecting the results in a table driven by customer requirements for one-time or continued reuse."
                width="176" height="179" /></span></a></p>
            </div>
            </div>
            </td>
            <td width="30%" class="catheader3">
                <?php if($datasetInfo->data_extraction){?>
                <a href="/download/<?php echo $dataset_id; ?>/dataextraction"><img
                src="<?php print '/'.path_to_theme().'/images/icon-extraction.gif' ?>" alt="extraction documents" title="extraction documents"
                width="21" height="21" /></a>
                <?php } else { echo '&nbsp;';} ?>
                </td>
        </tr>
        <tr>
            <td width="70%" class="catheader3"><!--[if lt IE 7]><a href="javascript:popupfeeds()">Feeds<img src="<?php print '/'.path_to_theme().'/images/arrow-black.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row2">
            <div id="popupdet">
            <p><a href="#">Feeds<img src="<?php print '/'.path_to_theme().'/images/arrow-black.gif' ?>"
                alt="" width="7" height="7" /><span><img
                src="<?php print '/'.path_to_theme().'/images/popup-feeds.gif' ?>"
                alt="Feed files include RSS, CAP and Atom feeds"
                width="176" height="170" /></span></a></p>
            </div>
            </div>
            </td>
            <td width="30%" class="catheader3">
                <?php if($datasetInfo->rss){?>
                <a href="/download/<?php echo $dataset_id; ?>/rss"><img
                src="<?php print '/'.path_to_theme().'/images/icon-feed.gif' ?>" alt="Feed documents" title="Feed documents"
                width="21" height="21" /></a>
                <?php } else { echo '&nbsp;';} ?>
                </td>
        </tr>
        <tr>
            <td width="70%" class="catheader3"><!--[if lt IE 7]><a href="javascript:popupwid()">Widget<img src="<?php print '/'.path_to_theme().'/images/arrow-black.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row3">
            <div id="popupdet">
            <p><a href="#">Widget<img src="<?php print '/'.path_to_theme().'/images/arrow-black.gif' ?>" alt=""
                width="7" height="7" /><span><img src="<?php print '/'.path_to_theme().'/images/popup-widget.gif' ?>"
                alt="Interactive virtual tool that provides single-purpose services such as showing the user the latest news, the current weather, the time, a calendar, a dictionary, a map program, a calculator, desktop notes, photo viewers, or even a language translator, among other things."
                width="176" height="179" /></span></a></p>
            </div>
            </div>
            </td>
            <td width="30%" class="catheader3">
                <?php if($datasetInfo->widget) { ?>
                <a href="/download/<?php echo $dataset_id; ?>/widget"><img src="<?php print '/'.path_to_theme().'/images/icon-widget.gif' ?>"
                alt="widget documents" title="widget documents" width="18" height="18" /></a>
                <?php } else { echo '&nbsp;'; } ?>
                </td>
        </tr>
    </tbody>
    <?php } else { // Geodata ?>
    <tbody>
        <tr>
            <td width="70%" class="catheader3"><!--[if lt IE 7]><a href="javascript:popupext()">Data Extraction<img src="<?php print '/'.path_to_theme().'/images/arrow-black.gif' ?>" alt="" width="7" height="7" /></a><![endif]-->
            <div id="row1">
            <div id="popupdet">
            <p><a href="#">Geodata<img src="<?php print '/'.path_to_theme().'/images/arrow-black.gif' ?>"
                alt="" width="7" height="7" /><span><img
                src="<?php print '/'.path_to_theme().'/images/popup-extraction.gif' ?>"
                alt="Allows you to select a databasket full of variables and then recode those variables in a form that the user desires. The user can then develop and customize tables. Selecting the results in a table driven by customer requirements for one-time or continued reuse."
                width="176" height="179" /></span></a></p>
            </div>
            </div>
            </td>
            <td width="30%" class="catheader3">
                <?php if($datasetInfo->data_extraction){?>
                <a href="/download/<?php echo $datasetInfo->unique_id; ?>/geodata"><img
                src="<?php print '/'.path_to_theme().'/images/icon-geo.png' ?>" alt="Geo-enabled data" title="geodata"
                width="21" height="21" /></a>
                <?php } else if($datasetInfo->geodata){?>
                <a href="/geodata/<?php echo $datasetInfo->unique_id; ?>"><img
                src="<?php print '/'.path_to_theme().'/images/icon-geo.png' ?>" alt="Geo-enabled data" title="geodata"
                width="21" height="21" /></a>
                <?php } else { echo '&nbsp;';} ?>
                </td>
        </tr>
    </tbody>
    <?php } ?>
</table>
&nbsp;<br />
<div class="commentbox">
<?php
/*
$suggest_dataset_url = $datagovpath."/suggestdataset/frame?datasetId=".$dataset_id."&datasetType=stg.data.gov&";
<a title='Suggest Other Datasets' href="<?php echo $suggest_dataset_url?>KeepThis=false&TB_iframe=false&height=500&width=500" class='thickbox' id='suggest_dataset_frame'>Cannot find data you are looking for?  Suggest other datasets!</a><br/>
*/
?>
<a title="Suggest Other Datasets" href="http://explore.data.gov/nominate" target="_blank">Cannot find data you are looking for?  Suggest other datasets!</a><br/>
&nbsp;<br/>
</div>
</div>
</div>
</div>

<div style="clear: both;"><div class="small" style="padding:20px; text-align:right;">OMB Control No. 3090-0284</div></div>












<?php
/* End customization */
?>
  </div>

  <?php print render($content['links']); ?>

  <?php //print render($content['comments']); ?>

  <?php if (!$teaser): ?>
    <div id="node-bottom" class="node-bottom region nested">
      <?php print render($node_bottom); ?>
    </div>
  <?php endif; ?>
  
</div>
