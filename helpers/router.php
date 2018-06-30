<?php
namespace Helpers;
use Controller;


class Router {

	private $post;
	private $get;



	public function __construct( $get, $post ) {
		if ( is_array( $get )and is_array( $post ) ) {
			$this->post = $post;
			$this->get = $get;
		}
	}

	public static function getController( $get, & $file, & $controller, & $method ) {
		unset( $_GET[ 'route' ] );
		$get = trim( $get, '/\\' );
		$url = explode( '/', $get );
		$path = CONTROLLER . 'controller_';
		$subdir = false;
		foreach ( $url as $key ) {
			if ( is_dir( $path . $key ) ) {
				$path .= $key . '/controller_';
				$subdir = true;
				$subcontroller = 'controller_' .$key . '/';
				array_shift($url);
				continue;
			}
			if ( is_file( $path . $key. '.php' ) ) {
				$controller = 'controller_' . $key;
				array_shift( $url );
				break;
			}
		}
		if ( empty( $controller ) ) {
			$controller = 'controller_index';
		}
		$method = array_shift( $url );
		if ( empty( $method ) ) {
			$method = 'ShowIndex';
		}
		if($subdir) {
		$file = CONTROLLER. $subcontroller . $controller . '.php';
		} else {
			$file = CONTROLLER . $controller . '.php';
		}
	}

	public function start() {
		
		if ( empty( $this->post )and empty( $this->get )) {
			Controller\Controller_index::showIndex();

		} else {
			$this->getController( $_GET[ 'route' ], $file, $controller, $method );
			if ( !is_readable( $file ) ) {
				Controller\Controller_error::showErrorPage();
			}
			require_once( $file );
			if($file == CONTROLLER . $controller . '.php') {
				$class = 'Controller\\' . $controller;
		} else {
				$class = 'Controller\\Controller_work\\' . $controller;
			}
			$controller = new $class();
			if ( !is_callable( array( $controller, $method ) ) ) {
				Controller\Controller_error::showErrorPage();
			}
			if(!empty($this->post)) {
				$controller->$method($this->post);
			} else {
				$controller->$method();
			}
			
		} 
	}


}









?>