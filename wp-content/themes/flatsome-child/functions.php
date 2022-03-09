<?php
// Add custom Theme Functions here

//Quay lại widget cũ
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );
add_filter( 'use_widgets_block_editor', '__return_false' );

include_once 'lib/widget.php';

include_once 'widgets/history.php';