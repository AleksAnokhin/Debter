<?php

namespace Controller;

abstract class Controller_base {
	
	protected static $css = array(CSS.'bootstrap.min.css',CSS.'main.css',CSS.'fontawesome-all.min.css');
	protected static $js = array(JS.'jquery-3.3.1.min.js',JS.'bootstrap.min.js',JS.'popup_plugin.js',JS.'main.js');
	protected static $favicon = IMG.'favicon.ico';
	protected static $pages = ['head','header','main','footer'];
	
	
	
	
	public function render( $controller,$page, $data = [] ) {
		extract( $data );
		$page .= '.html';
		if ( file_exists( VIEW . $controller . '/' .$page ) ) {
			require_once( VIEW . $controller . '/' .$page );
		}

	}
	
	
	
	
}


















?>