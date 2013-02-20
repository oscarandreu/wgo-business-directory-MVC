<?php
/**
 * wgodbControllerBase
 * Controllers base class
 *
 * @package Controllers
 * @author  Oscar Andreu
 **/
class WgoBd_ControllerBase{
	
	/**
	 * _instance class variable
	 *
	 * Class instance
	 *
	 * @var null | object
	 **/
	protected static $_instance = NULL;
	
	/**
	 * _load_domain class variable
	 *
	 * Load domain
	 *
	 * @var bool
	 **/
	protected static $_load_domain = FALSE;
	
	/**
	 * page_content class variable
	 *
	 * String storing page content for output by the_content()
	 *
	 * @var null | string
	 **/
	protected $page_content = NULL;
	
}
