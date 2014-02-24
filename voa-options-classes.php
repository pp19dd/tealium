<?php

function include_custom_options_init_2013() {
    global $voa_option_groups;
    
    foreach( $voa_option_groups as $entry ) {
        @register_setting( $entry['group'], $entry['name'] );
    }
}

function include_custom_options_add_page_2013() {
    global $voa_option_groups;

    // main, hardcoded
    add_menu_page(
        'VOA Options', 'VOA Options', 'edit_posts',
        'voa_options_2013', 'include_voa_options_page_2013'
    );
    foreach( $voa_option_groups as $entry ) {
        add_submenu_page(
            'voa_options_2013',
            $entry['title'],
            $entry['title'],
            0,
            'voa_options_'.$entry['short'], 
            $entry['func']
        );
    }
}

function voa_prepare_groups_2013() {
    global $voa_option_groups;
    global $voa_option_groups_n;
    // global $voa_t_info;

    foreach( $voa_option_groups_n as $k => $v ) {
        $c = count($voa_option_groups);
        $voa_option_groups[] = array(
            "short" => $k,
            "name" => "voa_opt_{$k}",
            "group" => "voa_opt_grp_{$c}",
            "class" => "voa_option_page_{$k}",
            "title" => $v
        );
    }
    foreach( $voa_option_groups as $k => $v ) {
        $voa_option_groups[$k]["func"] = create_function('',
            #"echo 'voa_option_page_" . $v['short'] . "()';" .
            "\$info = unserialize('" . serialize( $v ) . "');" .
            #"var_dump( \$info );" .
            "\$temp = new voa_option_page_" . $v['short'] . "(\$info); " .
            "\$temp->render_page();"
        );

    }
}

function voa_option_draw_all_textboxes( $textboxes, $that ) {
    echo '<div class="voa_textboxes">';
    foreach( $textboxes as $key => $data ) {
        voa_option_text(
            "id_{$key}", $data['caption'], $data['style'],
            "{$that->option_name}[{$key}]", $that->voa_options[$key]
        );
    }
    echo '</div>';
}

function voa_option_draw_all_checkboxes( $checkboxes, $that ) {
    echo '<div class="voa_textboxes">';
    foreach( $checkboxes as $key => $data ) {
    
        $checked = '';
        if( isset( $that->voa_options[$key] ) ) $checked='checked="checked"';
    
        voa_option_checkbox(
            "id_{$key}", $data['caption'], $data['style'],
            "{$that->option_name}[{$key}]", 
            //checked($that->voa_options[$key])
            $checked
        );
    }
    echo '</div>';
}

function voa_option_draw_all_selects( $selects, $that ) {
    echo '<div class="voa_textboxes">';
    foreach( $selects as $key => $data ) {
        voa_option_select(
            "id_{$key}", $data['caption'], $data['style'],
            "{$that->option_name}[{$key}]", $that->voa_options[$key],
            $data['available']
        );
    }
    echo '</div>';
}

function voa_option_select( $id, $caption, $style, $name, $value, $available_options ) {

echo "<label style='margin-bottom:0; padding-bottom:0' for=\"{$id}\">";
echo "<p style='padding-bottom:0'>{$caption}</p></label>";

echo "<select style=\"{$style}\" id=\"{$id}\" name=\"{$name}\">";
foreach( $available_options as $available_value => $available_label ) {
    printf(
        "<option %s value=\"%s\">%s</option>\n",
        ($available_value == $value ? 'selected="selected"' : ''),
        $available_value,
        $available_label
    );
}
echo "</select>";
}

function voa_option_text( $id, $caption, $style, $name, $value ) {

echo 
"<label for=\"{$id}\">
    <p>{$caption}</p>
    <textarea style=\"{$style}\" id=\"{$id}\" name=\"{$name}\">{$value}</textarea>
</label>";

}

function voa_option_checkbox( $id, $caption, $style, $name, $value ) {

echo 
"<div>
<label for=\"{$id}\">
<input style=\"{$style}\" id=\"{$id}\" name=\"{$name}\" type=\"checkbox\" value=\"{$value}\" ";

echo $value;

echo " /> {$caption}
</label>
</div>
";


}



// generic 
class voa_option_page {
    var $title = "VOA Options";
    var $option_group = "";
    var $option_name = "";
    var $voa_options = null;
    
    function __construct( $info ) {
        $this->option_group = $info['group'];
        $this->option_name = $info['name'];
        $this->voa_options = get_option( $this->option_name );
    }
    
    
    function render_form() {
    
    }
    
    function render_page() {
    
?>

<div class="wrap">
<div class="icon32" id="icon-plugins"><br/></div>
<h2><?php echo $this->title ?></h2>

<?php if( isset( $_GET['settings-updated'] ) ) { ?>

<div class="updated settings-error" id="setting-error-settings_updated"> 
<p><strong>Settings saved.</strong></p></div>

<?php } ?>

<div style="float:right; width:500px">
    <div style='text-align: right'>
        <a href="#" onclick="jQuery('#voa_template_tags').slideToggle('fast');return(false); ">
            Template Tags
        </a>
    </div>
    <div id="voa_template_tags" style="position: absolute; display:none; width:500px; background-color: midnightblue; color: white; padding:5px">
        <pre>Option Group: <?php echo $this->option_group ?>

Option Name: <?php echo $this->option_name ?>

<?php echo htmlentities(print_r( $this->voa_options, true)) ?>
        </pre>
    </div>
</div>

<form method="post" action="options.php">
<?php settings_fields( $this->option_group ); ?>

<div style="margin-top:3em">
<fieldset>

<?php $this->render_form() ?>

</fieldset>
</div>

<p class="submit">
    <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
</p>

</form>

</div>

<?php

    }
} # end voa_option_page


