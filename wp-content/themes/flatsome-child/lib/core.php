<?php
namespace HLWP\Core;

use HLWP\Utils;

function widgets_init() {
	// register_sidebar( [
	// 	'name'          => 'Hotline Trên Chỗ Menu',
	// 	'id'            => 'sidebar-hotline-menu',
	// 	'before_widget' => '',
	// 	'after_widget'  => '',
	// 	'before_title'  => '',
	// 	'after_title'   => '',
	// ] );

	// register_sidebar( [
	// 	'name'          => 'Ảnh nền đầu Trang',
	// 	'id'            => 'sidebar-background-global',
	// 	'before_widget' => '',
	// 	'after_widget'  => '',
	// 	'before_title'  => '',
	// 	'after_title'   => '',
	// ] );

	// register_sidebar( [
	// 	'name'          => 'Thanh chọn ngôn ngữ',
	// 	'id'            => 'sidebar-select-language',
	// 	'before_widget' => '',
	// 	'after_widget'  => '',
	// 	'before_title'  => '',
	// 	'after_title'   => '',
	// ] );

	// register_sidebar( [
	// 	'name'          => 'Thanh thông tin đầu trang',
	// 	'id'            => 'sidebar-topbar',
	// 	'before_widget' => '',
	// 	'after_widget'  => '',
	// 	'before_title'  => '',
	// 	'after_title'   => '',
	// ] );

	// register_sidebar( [
	// 	'name'          => 'Thanh Menu thứ 2',
	// 	'id'            => 'sidebar-menu-2',
	// 	'before_widget' => '',
	// 	'after_widget'  => '',
	// 	'before_title'  => '',
	// 	'after_title'   => '',
	// ] );

	// register_sidebar( [
	// 	'name'          => 'Footer',
	// 	'id'            => 'sidebar-footer',
	// 	'before_widget' => '',
	// 	'after_widget'  => '',
	// 	'before_title'  => '',
	// 	'after_title'   => '',
	// ] );

	// register_sidebar( [
	// 	'name'          => 'Nút Gọi & Zalo chat',
	// 	'id'            => 'sidebar-call',
	// 	'before_widget' => '',
	// 	'after_widget'  => '',
	// 	'before_title'  => '',
	// 	'after_title'   => '',
	// ] );

	// register_sidebar( [
	// 	'name'          => 'Script End Head',
	// 	'id'            => 'sidebar-script-end-head',
	// 	'before_widget' => '',
	// 	'after_widget'  => '',
	// 	'before_title'  => '',
	// 	'after_title'   => ''
	// ] );

	// register_sidebar( [
	// 	'name'          => 'Script Start Body',
	// 	'id'            => 'sidebar-script-start-body',
	// 	'before_widget' => '',
	// 	'after_widget'  => '',
	// 	'before_title'  => '',
	// 	'after_title'   => ''
	// ] );

	// register_sidebar( [
	// 	'name'          => 'Script End Body',
	// 	'id'            => 'sidebar-script-end-body',
	// 	'before_widget' => '',
	// 	'after_widget'  => '',
	// 	'before_title'  => '',
	// 	'after_title'   => ''
	// ] );


}

add_action( 'widgets_init', __NAMESPACE__ . '\\widgets_init' );

?>