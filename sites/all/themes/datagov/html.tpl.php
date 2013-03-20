<?php

/**
 * @file
 * Default theme implementation to display the basic html structure of a single
 * Drupal page.
 *
 * Variables:
 * - $css: An array of CSS files for the current page.
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $rdf_namespaces: All the RDF namespace prefixes used in the HTML document.
 * - $grddl_profile: A GRDDL profile allowing agents to extract the RDF data.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $page_top: Initial markup from any modules that have altered the
 *   page. This variable should always be output first, before all other dynamic
 *   content.
 * - $page: The rendered page content.
 * - $page_bottom: Final closing markup from any modules that have altered the
 *   page. This variable should always be output last, after all other dynamic
 *   content.
 * - $classes String of classes that can be used to style contextually through
 *   CSS.
 *
 * @see template_preprocess()
 * @see template_preprocess_html()
 * @see template_process()
 */
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML+RDFa 1.0//EN" "http://www.w3.org/MarkUp/DTD/xhtml-rdfa-1.dtd">

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js ie6 ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9 ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" version="XHTML+RDFa 1.0" dir="<?php print $language->dir; ?>" <?php print $rdf_namespaces; ?>> <!--<![endif]-->

<head profile="<?php print $grddl_profile; ?>">
  <?php print $head; ?>
  <title><?php print $head_title; ?></title>
  <?php print $styles; ?>
  <?php if ($mobile_friendly): ?>    
  <meta name="viewport" content="width=device-width" />
  <meta name="MobileOptimized" content="width" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <?php endif; ?>
  <?php print $scripts; ?>
    <script type="text/javascript">
        jQuery(function ($) {

                    $ul  = $("#menu-1568-1 ul");


            $ul.css('float','left');
            $ul.addClass("sf-hidden clist1")

            var size = $('.clist1 li').size();

            var csize2= Math.ceil(size/2);



            var col_max_item = csize2; //Max Items per column
            var col_width = $('#menu-1568-1 ul li').css('width').replace("px", "");  //Pixels, get width from CSS
            var col_height = $('#menu-1568-1 ul li').css('height').replace("px", ""); //Pixels, get height from CSS

            $('#menu-1568-1 ul').each(function() {
                $(this).find('li').each(function(index){
                    column = parseInt(index/col_max_item);
                    $(this).css('margin-left', column * col_width + 'px')
                    if(column > 0 && (index / col_max_item) == column) {
                        $(this).css('margin-top', (col_max_item * col_height * -1)  + 'px').addClass('col_'+column);
                    }
                });
            });
        });
        fixDropdown = function () { jQuery(function ($)
        {

            $("#edit-field-organization-type-und").live("change", function() {
                var one = $(this).val();
                if(one ==="State Government") {
                    $("#edit-field-organization").css("display","block");
                    $("#edit-field-organization-affiliation").css("display","block");
                }
                if(one !="Federal Government" && one != "_none") {
                    $("#edit-field-organization").css("display","block");
                }
            });

        });
            setTimeout('fixDropdown()', 1000);
        }
        fixDropdown();


     </script>


    <?php $uid= $user->uid;  if ($uid==0) { ?>
    <style type="text/css">
    .node-type-forum .comment-reply, .node-type-forum .comment-add {display: none !important;}
    .node-type-forum .title.comment-form, .node-type-forum #comment-form ,.node-type-forum .plus1-vote{display:none !important;}
    .node-type-forum .plus1-widget{width:2em;}
    </style>
<?php } ?>
</head>
<body id="<?php print $body_id; ?>" class="<?php print $classes; ?>" <?php print $attributes;?>>
  <div id="skip-link">
    <a href="#main-content-area"><?php print t('Skip to main content area'); ?></a>
  </div>
  <?php print $page_top; ?>
  <?php print $page; ?>
  <?php print $page_bottom; ?>

<?php if (strtolower($_SERVER['SERVER_NAME']) == 'www.data.gov' || strtolower($_SERVER['SERVER_NAME']) == 'communities-data-gov.data.gov'): ?>
<script type="text/javascript" src="<?php print base_path();?>sites/all/themes/datagov/js/webtrends.js"></script>
<!-- START OF SmartSource Data Collector TAG -->
<!-- Copyright (c) 1996-2012 Webtrends Inc. All rights reserved. -->
<!-- Version: 9.4.0 -->
<!-- Tag Builder Version: 3.3 -->
<!-- ----------------------------------------------------------------------------------- -->
<!-- Warning: The two script blocks below must remain inline. Moving them to an external -->
<!-- JavaScript include file can cause serious problems with cross-domain tracking. -->
<!-- ----------------------------------------------------------------------------------- -->
<script type="text/javascript">
//<![CDATA[
var _tag=new WebTrends();
_tag.dcsGetId();
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
_tag.dcsCustom=function(){
// Add custom parameters here.
//_tag.DCSext.param_name=param_value;
}
_tag.dcsCollect();
//]]>
</script>
<noscript>
<div><img alt="DCSIMG" id="DCSIMG" width="1" height="1" src="//statse.webtrendslive.com/dcskvhvj85dv0ho233advllsc_7b4v/njs.gif?dcsuri=/nojavascript&amp;WT.js=No&amp;WT.tv=9.4.0&amp;dcssip=www.data.gov"/></div>
</noscript> 
<?php endif; ?>
  <script type="text/javascript">
      jQuery(function ($) {
          $('.content-slider').cycle({
              fx: 'scrollLeft',
              timeout: 0,
              speed: 'fast',
              pager: '#content-nav',
              pagerAnchorBuilder: function(idx, slide) {
                  return '#content-nav li:eq(' + (idx) + ') a';
              }
          });
      });
  </script>

  <script type="text/javascript">
      jQuery(function ($) {
          $('.nav-toggle').click(function(){
              //get collapse content selector
              var collapse_content_selector = $(this).attr('href');

              //make the collapse content to be shown or hide
              var toggle_switch = $(this);
              $(collapse_content_selector).toggle(function(){
                  if($(this).css('display')=='none'){
                      //change the button label to be 'Show'
                      toggle_switch.html('(Show answer)');
                  }else{
                      //change the button label to be 'Hide'
                      toggle_switch.html('(Hide answer)');
                  }
              });
          });

      });
      // Hack to assign title and alt tags for all the views with images first one is hack for ajax enabled view
      //second one assigns when the user sees the view for first time.
      jQuery(function ($) {
          $('.view').ajaxComplete(function() {
          $("img:[alt]").each(function() {
              if($(this).attr("alt") != ''){
                  $(this).attr("alt", $(this).parent().attr("title"))
                  $(this).attr("title", $(this).parent().attr("title"))
              }

          });
      });
      });
      jQuery(function ($) {
          $('.view img:[alt]').each(function() {
                  if($(this).attr("alt") != ''){
                      $(this).attr("alt", $(this).parent().attr("title"))
                      $(this).attr("title", $(this).parent().attr("title"))
                  }

              });
          });


  </script>
  <script type="text/javascript">
              jQuery(function ($) {
                  $('.nav-toggle-1').click(function(){
                      //get collapse content selector
                      var collapse_content_selector = $(this).attr('href');

                      //make the collapse content to be shown or hide
                      var toggle_switch = $(this);
                      $(collapse_content_selector).toggle(function(){
                          if($(this).css('display')=='none'){
                              //change the button label to be 'Show'
                              toggle_switch.html('(More)');
                          }else{
                              //change the button label to be 'Hide'
                              toggle_switch.html('(Less)');
                          }
                      });
                  });

              });
  </script>
<script type="text/javascript">
    jQuery(function ($) {
        $('form.webform-client-form *:input[type!=hidden]:first').focus();
    });
</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
        $(":checkbox:checked").each(function () {

            this.click();
        });
        $('input[type=checkbox]').attr('checked',false);
        $("#edit-field-administrator-approved-und").attr("checked","");

});
    document.getElementById("edit-field-administrator-approved-und").checked = false;
</script>
<script type="text/javascript" src="<?php print base_path();?>sites/all/themes/datagov/js/google-analytics.js"></script>
</body>
</html>
