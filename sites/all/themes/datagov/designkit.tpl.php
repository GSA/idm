/**
 * This template should be overridden by implementing themes to establish
 * the styles they would like to use with DesignKit settings. The following
 * template is provided as a simple example of how you can generate CSS
 * styles from DesignKit settings.
 *
 * .designkit-color { color: [?php print $foreground ?]; }
 * .designkit-bg { background-color: [?php print $background ?]; }
 */

/* Community > Menu > Background */
body.datagov-community .comCatMenu .content { background-color: <?php print $menu_background_standard; ?>; }
body.datagov-community .comCatMenu ul.menu li a { background-color: <?php print $menu_background_standard; ?>; }
body.datagov-community #block-system-main table.views-table thead tr th { background-color: <?php print $menu_background_standard; ?>; }
body.datagov-community #block-system-main table.views-table tbody tr td a { color: <?php print $menu_background_standard; ?>; }
body.datagov-community #block-system-main a,
body.datagov-community .breadcrumbs a { color: <?php print $menu_background_standard; ?>; }
body.datagov-community #block-system-main .datagov-2col-sidebar .inner > h2,
body.datagov-community #block-system-main .datagov-2col-sidebar .inner > h2.block-title { color: <?php print $menu_background_standard; ?>; }
body.datagov-community #block-system-main .views-exposed-form .views-submit-button input#edit-submit-datasets { background-color: <?php print $menu_background_standard; ?>; }
body.datagov-community .comCatMenu ul.menu li a:hover,
body.datagov-community .comCatMenu ul.menu li a.active { color: <?php print $menu_background_standard; ?>; }
body.datagov-community #header-group .community-label h1.community-name a { color: <?php print $menu_background_standard; ?>; }
body.datagov-community #block-system-main .datagov-2col-sidebar ul li a { color: <?php print $menu_background_standard; ?>; }
body.datagov-community h2.title { color: <?php print $menu_background_standard; ?>; }

/* Community > Menu > Text,  */
/* Community > Active Menu > Background: */
body.datagov-community .comCatMenu ul.menu li a { color: <?php print $menu_background_active; ?>; }
body.datagov-community .comCatMenu ul.menu li a:hover,
body.datagov-community .comCatMenu ul.menu li a.active {
    background-color: <?php print $menu_background_active; ?>;
    border: 1px solid <?php print $menu_background_active; ?>;
}

body.datagov-community #comCatPan .panel-col-top {
    <?php print getDesignkitBgCss($menu_background_standard, 'slider_bg') ?>
}

body.datagov-community #comCatGreeting a,
body.datagov-community #comCatGreeting a:hover,
body.datagov-community #comCatGreeting a:visited,
body.datagov-community #comCatGreeting a:active { color: <?php print $slider_link; ?>;  }
body.datagov-community .content #comCatGreeting p{color:<?php print $law_color; ?>}
body.datagov-community .content #comCatGreeting h2.block-title{color:<?php print $law_color; ?>}

/* default: 66ccff, energy: 86bf4d */
body.datagov-community #comCatSlider .views-field-field-slide-url a { background-color: <?php print $slider_view_more_button; ?>; }

body.datagov-community #block-system-main a.btn-readmore {
    <?php print getDesignkitBgCss($menu_background_standard, 'read_more_bg') ?>
}

form input.form-submit {
    background: none repeat scroll 0 0 <?php print $apply_button ?>; /* default: #294B78, energy: #507829 */
    border: medium none <?php print $apply_button_border ?>; /* default: #033162, energy: #326103 */
}
form input.form-submit:hover,
form input.form-submit.hover,
form input.form-submit:focus,
#edit-field-ds-file-0-filefield-populate:hover,
#edit-field-ds-file-0-filefield-populate.hover,
#edit-field-ds-file-0-filefield-populate:focus {
    background: none repeat scroll 0 0 <?php print $apply_button_hover ?>; /* default: #4782B1, energy: #7bb046 */
}

div.views-slideshow-controls-text span.views-slideshow-controls-text-previous a {
    <?php print getDesignkitBgCss($menu_background_standard, 'slider_control_left') ?>
}
div.views-slideshow-controls-text span.views-slideshow-controls-text-pause a {
    <?php print getDesignkitBgCss($menu_background_standard, 'slider_control_pause') ?>
}
div.views-slideshow-controls-text span.views-slideshow-controls-text-next a {
    <?php print getDesignkitBgCss($menu_background_standard, 'slider_control_right') ?>
}
body.datagov-community #block-system-main a.join-forum-link {
    <?php print getDesignkitBgCss($menu_background_standard, 'join_community_button') ?>
}
