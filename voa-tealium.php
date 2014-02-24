<?php
/*
Plugin Name: VOA Tealium
Description: Provides Tealium tags
Version: 2.0
Author: Dino Beslagic
Author URI: http://pp19dd.com
License: No license, use at own risk.
*/

require_once( 'tealium.php' );

class VOA_Tealium extends WP_Tealium {

    // matches voa's wide theme, as rendered
    function get_wordpress_title() {
        return( sprintf(
            "%s %s", 
            wp_title('&laquo;', false, 'right'),
            get_bloginfo('name')
        ));
    }
    
    function before_render_tealium_html() {
        // $this->setVariable( "property_id", "dev" );
    }
    
    function table($a) {
        $html = "<table>";
        foreach( $a as $k => $v ) {
            $html .= sprintf(
            	"<tr><td style='width:250px'>%s</td><td>%s</td></tr>",
            	$k,
            	$v
			);
        }
        $html .= "</table>";
        return( $html );
    }
    
    // debugging help
    function after_render_tealium_html() {
        
        if( isset( $this->all_options['show_javascript_tag'] ) ) {

            echo "\n\n<!-- start tealium/wp -->";
        
            switch( $this->all_options['tag_mode'] ) {
                case 'qa':
echo "\n<script type=\"text/javascript\">
(function(a,b,c,d){
a='//tags.tiqcdn.com/utag/bbg/voa-nonpangea/qa/utag.js';
b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true;
a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a);
})();
</script>\n";
                break;
                
                case 'prod':
echo "\n<script type=\"text/javascript\">
(function(a,b,c,d){
a='//tags.tiqcdn.com/utag/bbg/voa-nonpangea/prod/utag.js';
b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true;
a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a);
})();
</script>\n";
                break;
                
                default:

echo "\n<script type=\"text/javascript\">
(function(a,b,c,d){
a='//tags.tiqcdn.com/utag/bbg/voa-nonpangea/dev/utag.js';
b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true;
a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a);
})();
</script>\n";

                break;
            }
            
            echo "<!-- end tealium/wp -->\n\n";
            
        }
        
        // crafted specifically for the voa header
        if( isset( $this->all_options['show_debug'] ) ) {
            if ( is_user_logged_in() ) {
                
                $debug = sprintf(
                    "<pre style='word-wrap:break-word; white-space:pre-line'>%s</pre>",
                    # print_r( $this->utag_data, true )
                    $this->table( $this->utag_data )
                );
                
                echo '<script type="text/javascript">';
                //echo '$("#proto_header").after(' . json_encode($debug) . ');';
                echo 'document.getElementById("proto_header").outerHTML += ' . json_encode($debug) . ';';
                echo '</script>';
            }
        }
    }
    
    
}

$Tealium = new VOA_Tealium();
$Tealium->setVariable( "entity",                    "VOA" );
$Tealium->setVariable( "platform",                  "Blog" );
$Tealium->setVariable( "platform_short",            "B" );

$t_options = get_option("voa_opt_teal");
$Tealium->setVariable( "language",                  $t_options["voa_tealium_language"] );
$Tealium->setVariable( "language_service",          $t_options["voa_tealium_language_service"] );
$Tealium->setVariable( "short_language_service",    $t_options["voa_tealium_language_short"] );
$Tealium->setVariable( "property_id",				$t_options["voa_tealium_language_propertyid"] );

$Tealium->all_options = $t_options;

$Tealium->activateTag();
