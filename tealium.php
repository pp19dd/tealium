<?php
/*
    helper object for tealium tag implementation
    requires wordpress, mbstring PHP module (multibyte)
*/


class WP_Tealium {

    var $utag_data = array(
        "runs_js" => "Yes"
    );
    
    function setVariable( $key, $value ) {
        $this->utag_data[$key] = $value;
    }

    function getVariable( $key ) {
        return( $this->utag_data[$key] );
    }
    
    // override this function to match your theme customization
    // check header.php for the <title></title> tag
    function get_wordpress_title() {
        return( wp_title('', false, 'right') );
    }
    
    function terms_as_string( $terms ) {
        if( !is_array( $terms ) ) return( "" );
        
        $found_terms = array();
        foreach( $terms as $term ) $found_terms[] = $term->name;
        return( implode(";", $found_terms ) );
    }
    
    
    // convenient hook for debugging
    function before_render_tealium_html() {
    
    }

    // convenient hook for debugging
    function after_render_tealium_html() {
    
    }
    
    // generates the tag with appropriate javascript
    function render_tealium_html() {
    
        $this->before_render_tealium_html();
    
        printf( "\n<script type=\"text/javascript\">\n" );
        printf( "var utag_data = %s;\n", json_encode( $this->utag_data ) );
        printf( "</script>\n" );
        
        $this->after_render_tealium_html();
    }

    function get_page_number() {
        $page_number = get_query_var('paged');

        // wordpress skips 1. goes 0, 2, 3, 4...
        if( $page_number === 0 ) $page_number = 1;
        
        return( $page_number );
    }
    
    // assembles all WP information needed for tealium
    function craft_tealium_tag() {
        global $post;

        // prefix, content, suffix for later
        $page_name = array("p" => "", "c" => "", "s" => "");
        
        $this->setVariable( "content_type", "navigation" );    // default

        $this->setVariable( "page_title", $this->get_wordpress_title() );
        $this->setVariable( "page_type", get_bloginfo('name') );
        
        if( is_search() ) {
            $this->setVariable( "search_keyword", get_search_query() );
            
            $page_name['c'] = "Search Results";
            $page_name['s'] = $this->get_page_number();
        }
        
        if( is_author() ) {
            $page_name['p'] = "Author";
            $page_name['c'] = get_query_var('author_name');
            $page_name['s'] = $this->get_page_number();
        }
        
        if( is_date() ) {
            $d = get_query_var('day');
            $m = get_query_var('monthnum');
            $y = get_query_var('year');
            
            // zero pad if needed
            if( strlen($d) > 0 && intval($d) > 0 )
            	$date_string[] = str_pad( $d, 2, "0", STR_PAD_LEFT );
            
            if( strlen($m) > 0 && intval($m) > 0 )
            	$date_string[] = str_pad( $m, 2, "0", STR_PAD_LEFT );
            
            if( strlen($y) > 0 ) $date_string[] = $y;
            
            $page_name['p'] = "Date";
            $page_name['c'] = implode("/", $date_string );
            $page_name['s'] = $this->get_page_number();
        }
        
        if( is_category() ) {
            $page_name['p'] = "Category";
            $page_name['c'] = single_cat_title( "", false );
            $page_name['s'] = $this->get_page_number();
        }
        
        if( is_tag() ) {
            $page_name['p'] = "Tags";
            $page_name['c'] = single_tag_title( "", false );
            $page_name['s'] = $this->get_page_number();
        }
        
        if( is_home() ) {
            $page_name['c'] = "Home";
            $page_name['s'] = $this->get_page_number();
        }
        
        if( is_404() ) {
            // copy blog name first
            $page_name['c'] = $this->getVariable("page_type");
            
            // then change that to 404
            $this->setVariable( "page_type", "404 Error" );
        }
        
        // post, page, attachment
        if( is_singular() ) {

            $this->setVariable( "article_cms_id", $post->ID );
            $this->setVariable( "article_uid", $post->ID );
            $this->setVariable( "slug", $post->post_name );
            
            // headline, short_headline, long_headline - (all, 75, 255)
            $this->setVariable( "headline", get_the_title() );
            $this->setVariable( "short_headline",
            	mb_strcut( $this->getVariable("headline"), 0, 75, 'utf-8' )
        	);
            $this->setVariable( "long_headline",
            	mb_strcut( $this->getVariable("headline"), 0, 255, 'utf-8' )
        	);

            // byline: last, first - else, username
            $byline = sprintf(
                "%s, %s", 
                get_the_author_meta('user_lastname'),
                get_the_author_meta('user_firstname')
            );
            if( strlen( trim($byline) ) == 1 ) {
                $byline = get_the_author_meta('user_login');
            }
            $this->setVariable( "byline", $byline );
            
            // timestamps
            $this->setVariable( "pub_year",     get_the_date( "Y" ) );
            $this->setVariable( "pub_month",    get_the_date( "m" ) );
            $this->setVariable( "pub_day",      get_the_date( "d" ) );
            $this->setVariable( "pub_weekday",	get_the_date( "l" ) );
            $this->setVariable( "pub_hour",     get_the_date( "H" ) );
            $this->setVariable( "pub_minute",   get_the_date( "i" ) );

            if( is_attachment() ) {
                $this->setVariable( "content_type", "attachment" );
                $this->setVariable( "template", "attachment" );
                
                $page_name['p'] = "Attachment";
                $page_name['c'] = $this->getVariable("headline");
            } elseif( is_single() ) {
                $this->setVariable( "content_type", "post" );
                $this->setVariable( "template", "post" );
                
                $page_name['c'] = $this->getVariable("headline");
            } elseif( is_page() ) {
                $this->setVariable( "content_type", "page" );
                $this->setVariable( "template", "page" );
                
                $page_name['p'] = "Page";
                $page_name['c'] = $this->getVariable("headline");
            }
            
            // cats and tags
            $cats = $this->terms_as_string( get_the_category() );
            $tags = $this->terms_as_string( get_the_tags() );
            if( strlen($cats) > 0 ) $this->setVariable( "categories", $cats );
            if( strlen($tags) > 0 ) $this->setVariable( "tags", $tags );
            
        }
        
        
        /* ensure implode order is maintained */
        if( $page_name['p'] == '' ) unset( $page_name['p'] );
        if( $page_name['c'] == '' ) unset( $page_name['c'] );
        if( $page_name['s'] == '' ) unset( $page_name['s'] );
        $this->setVariable( "page_name", implode(" - ", $page_name ) );
        
        $this->render_tealium_html();
    }
    
    function activateTag() {
        add_action( 'wp_footer', array( $this, 'craft_tealium_tag' ) );
    }
    
}
