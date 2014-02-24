<?php
/*
Plugin Name: VOA Options 2013
Description: Provides an option menu for many settings.
Version: 2.0
Author: Dino Beslagic
Author URI: http://pp19dd.com
License: No license, use at own risk.
*/

require_once( "voa-options-classes.php" );
require_once( "voa-tealium-presets.php" );

// =============================================================================
// step 1: list groups
// =============================================================================
$voa_option_groups = array();
$voa_option_groups_n = array(
    # "directory" => "Directory",
    # "comm" => "Comments/Authors",
    # "seo" => "META/SEO",
    # "style" => "Style Adjustments",
    "teal" => "Tealium"
);

// =============================================================================
// step 2: make menu customization clases (pages)
// =============================================================================

// =============================================================================
// custom page: main, hardcoded
// =============================================================================
class voa_option_page_main extends voa_option_page {

    function render_form() {

        echo 
            "<style type='text/css'>" .
            "input[type=submit] { display: none }" .
            "</style>" .
            "<script type='text/javascript'>" .
            "//window.location='?page=voa_options_directory'" .
            "</script>";
    
    }

}

/*
// =============================================================================
// custom page: main, hardcoded
// =============================================================================
class voa_option_page_directory extends voa_option_page {

    function render_form() {

        echo "<p>Top language field is required in order to show the blog at http://blogs.voanews.com/</p>"; 

        voa_option_draw_all_selects( array(
            "voa_language" => array(
                "caption" => "Language",
                "style" => "width:200px",
                "available" => array(
                    "" => "Default (Does not show)", 
                    "english" => "English",
                    "armenian" => "Armenian",
                    "azeri" => "Azerbaijani",
                    "georgian" => "Georgian",
                    "khmer" => "Khmer-English",
                    "kurdish" => "Kurdish",
                    "russian" => "Russian",
                    "spanish" => "Spanish",
                    "turkish" => "Turkish",
                    "ukrainian" => "Ukrainian",
                    "uzbek" => "Uzbek"
                )
            )
        ), $this );
        
        voa_option_draw_all_textboxes( array(
            "voa_introgroup" => array(
                "caption" => "Intro page group",
                "style" => "width:150px; height:25px;resize:none"
            )
        ), $this );
        
        voa_option_draw_all_selects( array(
            "voa_introgroup_cfg" => array(
                "caption" => "Sort/Visibility Options",
                "style" => "width:150px",
                "available" => array(
                    "" => "Default", 
                    "hide" => "Hide this blog",
                    "sort-A" => "Sort -5",
                    "sort-B" => "Sort -4",
                    "sort-C" => "Sort -3",
                    "sort-D" => "Sort -2",
                    "sort-E" => "Sort -1",
                    "sort-F" => "Sort +1",
                    "sort-G" => "Sort +2",
                    "sort-H" => "Sort +3",
                    "sort-I" => "Sort +4",
                    "sort-J" => "Sort +5",
                )
            )
        ), $this );
    
    }
}

function include_voa_options_page_2013() {
    global $voa_option_groups;
    $temp = new voa_option_page_main( array("short"=>"voa","group"=>"voa", "name"=>"main") );
    $temp->render_page();
}

// =============================================================================
// custom page: commenting options
// =============================================================================
class voa_option_page_comm extends voa_option_page {
    var $title = "VOA Commenting / Author Options";
    
    function render_form() {

        voa_option_draw_all_selects( array(
            "voa_commenting" => array(
                "caption" => "Commenting style",
                "style" => "width:200px",
                "available" => array(
                    "traditional" => "Traditional WordPress",
                    "facebook" => "Facebook Commenting"
                )
            )
        ), $this );

        echo "<br/><br/><br/><strong>Post authors</strong>";
    
        $checkboxes = array(
            "show_author" => array("caption" => "Show post authors in blog posts?"),
            "show_menubar" => array("caption" => "Show WP menu bar?"),
            #"comment_traditional" => array("caption" => "Use traditional commenting?"),
            #"comment_facebook" => array("caption" => "Use facebook commenting?"),
        );
        
        voa_option_draw_all_checkboxes( $checkboxes, $this );
    }
}

// =============================================================================
// custom page: seo options
// =============================================================================
class voa_option_page_seo extends voa_option_page {
    var $title = "VOA META/SEO Options";
    
    function render_form() {

        $textboxes = array(
            "voa_seo_keywords" => array(
                "caption" => "META Keywords",
                "style" => "width:100%; height:60px;resize:vertical"
            ),
            "voa_seo_description" => array(
                "caption" => "META Description",
                "style" => "width:100%; height:120px;resize:vertical"
            )
        );
        
        voa_option_draw_all_textboxes( $textboxes, $this );
    }
}

// =============================================================================
// custom page: style
// =============================================================================
class voa_option_page_style extends voa_option_page {
    var $title = "Style Adjustments";

    function render_form() {
        $textboxes = array(
            "voa_header_w" => array(
                "caption"=>"Header Width",
                "default"=>"630px",
                "after"=>"px",
                "style" => "width:50px; height:25px;resize:none\" spellcheck=\"false"
            ),
            "voa_header_h" => array(
                "caption"=>"Header Height",
                "default"=>"125px",
                "style" => "width:50px; height:25px;resize:none\" spellcheck=\"false"
            ),
            "voa_css" => array(
                "caption"=>"Additional CSS",
                "style" => "width:100%; height:200px;resize:vertical\" spellcheck=\"false"
            )
        );
        
        voa_option_draw_all_textboxes( $textboxes, $this );
        
        echo "<br/><br/>";
        
        voa_option_draw_all_checkboxes( array(
            "hyperlinks" => array("caption" => "Don't remove hyperlinks for images that point to themselves")
        ), $this );
        
    }
}
*/

// =============================================================================
// custom page tealium
// =============================================================================
class voa_option_page_teal extends voa_option_page {
    var $title = "VOA Options";
    
    function render_form() {

        $textboxes = array(
            "voa_tealium_language" => array(
                "caption" => "Tealium: Language",
                "style" => "width:100%; height:25px;resize:none"
            ),
            "voa_tealium_language_service" => array(
                "caption" => "Tealium: Language Service",
                "style" => "width:100%; height:25px;resize:none"
            ),
            "voa_tealium_language_short" => array(
                "caption" => "Tealium: Short Language Service",
                "style" => "width:100%; height:25px;resize:none"
            ),
            "voa_tealium_language_propertyid" => array(
                "caption" => "Tealium: Property ID",
                "style" => "width:100%; height:25px;resize:none"
            )
        );

        echo "<table border='0' class='voa_teal' width='100%'>";
        echo "  <tr>";
        echo "    <td style='padding-right:2em'>";
        voa_option_draw_all_textboxes( $textboxes, $this );
        echo "<br/>";

        voa_option_draw_all_selects( array(
            "tag_mode" => array(
                "caption" => "Tag mode",
                "style" => "width:200px",
                "available" => array(
                    "dev" => "DEV script tag",
                    "qa" => "QA script tag",
                    "prod" => "PROD script tag"
                )
            )
        ), $this );

        
        echo "<br/>";
        voa_option_draw_all_checkboxes( array(
            "show_javascript_tag" => array("caption" => "Render &lt;script&gt; tag? (make live)"),
            "show_debug" => array("caption" => "Show debug info for logged-in users?"),
        ), $this );
        
        echo "    </td>";
        echo "    <td style='width:300px'>";
        
        $presets = voa_tealium_get_presets();
        $header = array_shift( $presets );
        #print_r( $presets );
        
/*(
    0 => 'Entity',
    1 => 'Site name',
    2 => 'url',
    3 => 'Langauge',
    4 => 'Site ID',
    5 => 'Culture code',
    6 => 'Platform',
    7 => 'Property ID (for Tealium and Sitecatalyst)',
    8 => 'Language Service',
    9 => 'Short Language Service',
    10 => 'Short Platform',

        )
*/        
        echo "<div style='height:300px; overflow-y:auto'>";
        echo "<ul>";
        foreach( $presets as $preset ) {
            printf(
                "<li><a title='Load this preset' href='#' onclick='voa_tealium(%s); return(false);'>%s</a></li>", 
                //"jQuery(\"#id_voa_tealium_language\").val(\"derp\"); return(false);",
                json_encode( $preset ),
                $preset[1]
            );
        }
        echo "</ul>";
        
        echo "    </td>";
        echo "  </tr>";
        echo "</table>";
        echo "</div>";
    }
    
}

/*
// =============================================================================
// image fixes are now done via plugin
// =============================================================================
function remove_useless_hyperlinked_images_2013( $content ) {

    $o = get_option( "voa_opt_style" );
    if( isset( $o['hyperlinks'] ) ) {
        return( $content );
    }
    
    $doc = new DOMDocument();

    // cheap trick to avoid smart characters being mangled
    @$doc->loadHTML( '<?xml encoding="UTF-8">' . $content );
    $path = new DOMXpath( $doc );
    $images = $path->query( "//a//img" );

    // remove useless hyperlinks
    for( $i = 0; $i < $images->length; $i++ ) {
        $img = $images->item($i);
        $a = $images->item($i)->parentNode;

        // discard useless image link
        if( $img->getAttribute('src') == $a->getAttribute('href') ) {
            $a->parentNode->replaceChild( $img, $a );
        }
    }

    // cheap trick to get <body>
    $html = $doc->saveHTML();
    @preg_match( "/<body\>(.*)<\/body>/is", $html, $r );
    if( is_array( $r ) && isset( $r[1] ) ) {
        return( $r[1] );
    } else {
        return( $content );
    }
    
}

// =============================================================================
// css tweaks are now done via plugin
// =============================================================================
function voa_header_add_2013() {

    $o = get_option( "voa_opt_style" );
    if( isset( $o['voa_css'] ) && strlen(trim($o['voa_css'])) > 0 ) {
        printf( "\n<style type=\"text/css\">\n%s\n</style>\n", $o['voa_css'] );
    }
}

// =============================================================================
// admin tweaks are now done via plugin
// =============================================================================
function voa_disable_admin_bar_2013(){

    $o = get_option( "voa_opt_comm" );
    if( isset($o['show_menubar']) ) {
        return( true );
    }
    return( false );
}
*/

// =============================================================================
// admin side css tweaks
// =============================================================================
function voa_admin_header_add_2013() {

?>
<script type="text/javascript">

function voa_tealium_assign_and_highlight(node, val) {
    node.val( "" );
    
    node.stop().animate({
        'background-color':'#FFFFE0'
    }, 200, function() {
        node.val( val );
        
        node.animate({
            'background-color':'white'
        }, 100 );
    });
}

function voa_tealium(e) {
    voa_tealium_assign_and_highlight( jQuery("#id_voa_tealium_language"), e[3] );
    voa_tealium_assign_and_highlight( jQuery("#id_voa_tealium_language_service"), e[8] );
    voa_tealium_assign_and_highlight( jQuery("#id_voa_tealium_language_short"), e[9] );
    voa_tealium_assign_and_highlight( jQuery("#id_voa_tealium_language_propertyid"), e[7] );
}
</script>

<style type="text/css">
.voa_textboxes p { font-weight: bold; margin-bottom:0px; }
.voa_teal td { vertical-align: top }
#toplevel_page_voa_options_2013 .wp-first-item { display: none }
</style>

<?php
}

// options screen
@voa_prepare_groups_2013();
add_action( 'admin_init', 'include_custom_options_init_2013' );
add_action( 'admin_menu', 'include_custom_options_add_page_2013' );
add_action( 'admin_head', 'voa_admin_header_add_2013', 10, 2 );
# add_action( 'wp_head', 'voa_header_add_2013' );
# add_filter( 'the_content', 'remove_useless_hyperlinked_images_2013' );
# add_filter( 'show_admin_bar', 'voa_disable_admin_bar_2013');
