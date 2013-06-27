<?php
/**
 * @package		Asikart.Plugin
 * @subpackage	system.plg_remoteimage
 * @copyright	Copyright (C) 2012 Asikart.com, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Remoteimage System Plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	System.remoteimage
 * @since		1.5
 */
class plgSystemRemoteimage extends JPlugin
{
	
	public static $_self ;
	
	/**
	 * Constructor
	 *
	 * @access      public
	 * @param       object  $subject The object to observe
	 * @param       array   $config  An array that holds the plugin configuration
	 * @since       1.6
	 */
    public function __construct(&$subject, $config)
    {
		parent::__construct( $subject, $config );
		$this->loadLanguage();
        $this->loadLanguage('com_remoteimage', JPATH_ADMINISTRATOR.'/components/com_remoteimage');
		$this->app = JFactory::getApplication();
		
		self::$_self = $this ;
    }
	
	
	
	/*
	 * function getInstance
	 */
	
	public static function getInstance()
	{
		return self::$_self ;
	}
	
	
	
	// system Events
	// ======================================================================================
	
	/*
	 * function onAfterRoute
	 */
	
	public function onAfterRoute()
	{
        $doc = JFactory::getDocument();
		$doc->addScript(JURI::root(true).'/administrator/components/com_remoteimage/includes/js/remoteimage-admin.js');
        
		$uri = JFactory::getURI() ;
        $option = JRequest::getVar('option') ;
        $view   = JRequest::getVar('view') ;
        $app    = JFactory::getApplication() ;
        $tmpl   = JRequest::getVar('tmpl') ;
        $fieldid= JRequest::getVar('fieldid') ;
        $params = JComponentHelper::getParams('com_remoteimage') ;
        
        // Replace Insert to Article
        if( $app->isAdmin() && $option == 'com_media' && $view == 'images' && !$fieldid && $tmpl == 'component' && $params->get('Integrate_Override_InsertImageArticle', 1)) {
            
            $uri->setVar('option', 'com_remoteimage');
            $uri->delVar('view');
            $uri->setVar('insert_id', JRequest::getVar('e_name') );
            
            $app->redirect((string) $uri);
        }
        
        // Replace FormField
        if( $app->isAdmin() && $option == 'com_media' && $view == 'images' && $fieldid && $tmpl == 'component' && $params->get('Integrate_Override_MediaFormField', 1)) {
            
            $uri->setVar('option', 'com_remoteimage');
            $uri->delVar('view');
            
            $app->redirect((string) $uri);
        }
        
        // Replace Media Manager
        if( $app->isAdmin() && $option == 'com_media' && ($view == 'image' || !$view) && $params->get('Integrate_Override_MediaManager', 1)) {
            
            $uri->setVar('option', 'com_remoteimage');
            $uri->delVar('view');
            
            $app->redirect((string) $uri);
        }
	}
    
	
	// AKFramework Functions
	// ====================================================================================
	
	
	/**
	 * function call
	 * 
	 * A proxy to call class and functions
	 * Example: $this->call('folder1.folder2.function', $args) ; OR $this->call('folder1.folder2.Class::function', $args)
	 * 
	 * @param	string	$uri	The class or function file path.
	 * 
	 */
	
	public function call( $uri ) {
		// Split paths
		$path = explode( '.' , $uri );
		$func = array_pop($path);
		$func = explode( '::', $func );
		
		// set class name of function name.
		if(isset($func[1])){
			$class_name = $func[0] ;
			$func_name = $func[1] ;
			$file_name = $class_name ;
		}else{
			$func_name = $func[0] ;
			$file_name = $func_name ;
		}
		
		$func_path 		= implode('/', $path).'/'.$file_name;
		$include_path = JPATH_ROOT.'/'.$this->params->get('include_path', 'easyset');
		
		// include file.
		if( !function_exists ( $func_name )  && !class_exists($class_name) ) :			
			$file = trim($include_path, '/').'/'.$func_path.'.php' ;
			
			if( !file_exists($file) ) {
				$file = dirname(__FILE__).'/lib/'.$func_path.'.php' ;
			}
			
			if( file_exists($file) ) {
				include_once( $file ) ;
			}
		endif;
		
		// Handle args
		$args = func_get_args();
        array_shift( $args );
        
		// Call Function
		if(isset($class_name) && method_exists( $class_name, $func_name )){
			return call_user_func_array( array( $class_name, $func_name ) , $args );
		}elseif(function_exists ( $func_name )){
			return call_user_func_array( $func_name , $args );
		}
		
	}
	
	
	
	public function includeEvent($func) {
		$include_path = JPATH_ROOT.'/'.$this->params->get('include_path', 'easyset');
		$event = trim($include_path, '/').'/'.'events/'.$func.'.php' ;
		if(file_exists( $event )) return $event ;
	}
	
	
	
	public function resultBool($result = array()) {
		foreach( $result as $result ):
			if(!$result) return false ;
		endforeach;
		
		return true ;
	}
}
