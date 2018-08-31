<?php
// Adds your styles to the WordPress editor
add_action( 'init', 'betube_editor_styles' );
function betube_editor_styles() {
    add_editor_style( get_template_directory_uri() . '/assets/css/editor-style.min.css' );
}