<?php
require_once( 'tealium.php' );

class RFE_Tealium extends WP_Tealium {
    function get_wordpress_title() {
        // return (not echo) the inside of your 
        // WP template's title tag, so that it matches exactly
        // ex: 
        return( wp_title('&laquo;', false, 'right') );
    }

    function after_render_tealium_html() {
?>

<script type="text/javascript">
(function(a,b,c,d){
a='//tags.tiqcdn.com/utag/bbg/voa-nonpangea/dev/utag.js';
b=document;c='script';d=b.createElement(c);d.src=a;d.type='text/java'+c;d.async=true;
a=b.getElementsByTagName(c)[0];a.parentNode.insertBefore(d,a);
})();
</script>

<?php
    }
}

// adjust the entity/platform parameters accordingly
$Tealium = new RFE_Tealium();
$Tealium->setVariable( "entity",                  "RFE" );
$Tealium->setVariable( "platform",                "Blog" );
$Tealium->setVariable( "platform_short",          "B" );

$Tealium->setVariable( "language",                "English" );
$Tealium->setVariable( "language_service",        "RFE English");
$Tealium->setVariable( "short_language_service",  "EN");
$Tealium->setVariable( "property_id",             "300" );

// option 1: tag is inserted via wp_footer() hook
$Tealium->activateTag();

// option 2: you can manually inser tag wherever needed
// $Tealium->render_tealium_html();
