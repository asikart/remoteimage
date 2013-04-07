<?php
/**
 * @package		Asikart.Plugin
 * @subpackage	editors-xtd.plg_remoteimage
 * @copyright	Copyright (C) 2012 Asikart.com, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('joomla.plugin.plugin');

/**
 * Remoteimage Editors-xtd Plugin
 *
 * @package		Joomla.Plugin
 * @subpackage	Editors-xtd.remoteimage
 * @since		1.5
 */
class plgButtonRemoteimage extends JPlugin
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
		$this->loadLanguage('com_remoteimage', JPATH_ADMINISTRATOR.'/components/com_remoteimage');
		$this->app = JFactory::getApplication();
		
		
		
		self::$_self = $this ;
    }
	
	
	/**
	 * Display the button
	 *
	 * @return array A two element array of (imageName, textToInsert)
	 */
	public function onDisplay($name, $asset, $author)
	{
		
		$js = "
		function insertImage(imgs)
		{

			jInsertEditorText(imgs, '".$name."');
			SqueezeBox.close();
			
		}";

		$doc = JFactory::getDocument();
		$doc->addScriptDeclaration($js);
		
		
		$app = JFactory::getApplication();
		$user = JFactory::getUser();
		$extension = $app->input->get('option');
		if ($asset == '')
		{
			$asset = $extension;
		}
		if (	$user->authorise('core.edit', $asset)
			||	$user->authorise('core.create', $asset)
			||	(count($user->getAuthorisedCategories($asset, 'core.create')) > 0)
			||	($user->authorise('core.edit.own', $asset) && $author == $user->id)
			||	(count($user->getAuthorisedCategories($extension, 'core.edit')) > 0)
			||	(count($user->getAuthorisedCategories($extension, 'core.edit.own')) > 0 && $author == $user->id)
		)
		{
			$link = 'index.php?option=com_remoteimage&view=manager&tmpl=component';
			JHtml::_('behavior.modal');
			$button = new JObject;
			$button->modal = true;
			$button->link = $link;
			$button->text = JText::_('COM_REMOTEIMAGE_IMAGE_BUTTON');
			$button->name = 'picture';
			$button->options = "{handler: 'iframe', size: {x: 800, y: 500}}";
			return $button;
		}
		else
		{
			return false;
		}
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
	 * function onAfterInitialise
	 */
	
	public function onAfterInitialise()
	{
		
	}
	
	
	
	/*
	 * function onAfterRoute
	 */
	
	public function onAfterRoute()
	{
		
	}
	
	
	
	/*
	 * function onAfterDispatch
	 */
	
	public function onAfterDispatch()
	{
		
	}
	
	
	
	/*
	 * function onAfterRender
	 */
	
	public function onAfterRender()
	{
		
	}
	
	
	
	
	// Content Events
	// ======================================================================================
	
	
	/**
	 * Remoteimage prepare content method
	 *
	 * Method is called by the view
	 *
	 * @param	string	The context of the content being passed to the plugin.
	 * @param	object	The content object.  Note $article->text is also available
	 * @param	object	The content params
	 * @param	int		The 'page' number
	 * @since	1.6
	 */
	public function onContentPrepare($context, &$article, &$params, $page=0)
	{
		$app = JFactory::getApplication();
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
	}
	
	
	/**
	 * Remoteimage after display title method
	 *
	 * Method is called by the view and the results are imploded and displayed in a placeholder
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int			The 'page' number
	 * @return	string
	 * @since	1.6
	 */
	public function onContentAfterTitle($context, &$article, &$params, $page=0)
	{
		$app 	= JFactory::getApplication();
		$result = null ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $result ;
	}
	
	
	/**
	 * Remoteimage before display content method
	 *
	 * Method is called by the view and the results are imploded and displayed in a placeholder
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int			The 'page' number
	 * @return	string
	 * @since	1.6
	 */
	public function onContentBeforeDisplay($context, &$article, &$params, $page=0)
	{
		$app 	= JFactory::getApplication();
		$result = null ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $result ;
	}
	

	/**
	 * Remoteimage after display content method
	 *
	 * Method is called by the view and the results are imploded and displayed in a placeholder
	 *
	 * @param	string		The context for the content passed to the plugin.
	 * @param	object		The content object.  Note $article->text is also available
	 * @param	object		The content params
	 * @param	int			The 'page' number
	 * @return	string
	 * @since	1.6
	 */
	public function onContentAfterDisplay($context, &$article, &$params, $page=0)
	{
		$app 	= JFactory::getApplication();
		$result = null ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $result ;
	}
	
	
	/**
	 * Remoteimage before save content method
	 *
	 * Method is called right before content is saved into the database.
	 * Article object is passed by reference, so any changes will be saved!
	 * NOTE:  Returning false will abort the save with an error.
	 *You can set the error by calling $article->setError($message)
	 *
	 * @param	string		The context of the content passed to the plugin.
	 * @param	object		A JTableContent object
	 * @param	bool		If the content is just about to be created
	 * @return	bool		If false, abort the save
	 * @since	1.6
	 */
	public function onContentBeforeSave($context, &$article, $isNew)
	{
		$app 	= JFactory::getApplication();
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * Remoteimage after save content method
	 * Article is passed by reference, but after the save, so no changes will be saved.
	 * Method is called right after the content is saved
	 *
	 * @param	string		The context of the content passed to the plugin (added in 1.6)
	 * @param	object		A JTableContent object
	 * @param	bool		If the content is just about to be created
	 * @since	1.6
	 */
	public function onContentAfterSave($context, &$article, $isNew)
	{
		$app 	= JFactory::getApplication();
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	

	/**
	 * Remoteimage before delete method.
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	object	The data relating to the content that is to be deleted.
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentBeforeDelete($context, $data)
	{
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * Remoteimage after delete method.
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	object	The data relating to the content that was deleted.
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentAfterDelete($context, $data)
	{
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	

	/**
	 * Remoteimage after delete method.
	 *
	 * @param	string	The context for the content passed to the plugin.
	 * @param	array	A list of primary key ids of the content that has changed state.
	 * @param	int		The value of the state that the content has been changed to.
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentChangeState($context, $pks, $value)
	{
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	
	// Form Events
	// ====================================================================================
	
	
	/**
	 * @param	JForm	$form	The form to be altered.
	 * @param	array	$data	The associated data for the form.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareForm($form, $data)
	{
		$app 	= JFactory::getApplication() ;
		$result = null ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $result;
	}
	
	
	
	// User Events
	// ====================================================================================
	
	
	/**
	 * Utility method to act on a user after it has been saved.
	 *
	 *
	 * @param	array		$user		Holds the new user data.
	 * @param	boolean		$isnew		True if a new user is stored.
	 * @param	boolean		$success	True if user was succesfully stored in the database.
	 * @param	string		$msg		Message.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function onUserBeforeSave($user, $isnew, $success, $msg)
	{
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * Utility method to act on a user after it has been saved.
	 *
	 *
	 * @param	array		$user		Holds the new user data.
	 * @param	boolean		$isnew		True if a new user is stored.
	 * @param	boolean		$success	True if user was succesfully stored in the database.
	 * @param	string		$msg		Message.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function onUserAfterSave($user, $isnew, $success, $msg)
	{
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * This method should handle any login logic and report back to the subject
	 *
	 * @param	array	$user		Holds the user data
	 * @param	array	$options	Array holding options (remember, autoregister, group)
	 *
	 * @return	boolean	True on success
	 * @since	1.5
	 */
	public function onUserLogin($user, $options = array())
	{
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * This method should handle any logout logic and report back to the subject
	 *
	 * @param	array	$user		Holds the user data.
	 * @param	array	$options	Array holding options (client, ...).
	 *
	 * @return	object	True on success
	 * @since	1.5
	 */
	public function onUserLogout($user, $options = array())
	{
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * Utility method to act on a user before it has been saved.
	 *
	 *
	 * @param	array		$user		Holds the new user data.
	 * @param	boolean		$isnew		True if a new user is stored.
	 * @param	boolean		$success	True if user was succesfully stored in the database.
	 * @param	string		$msg		Message.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public function onUserBeforeDelete($user, $isnew, $success, $msg)
	{
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * Remove all sessions for the user name
	 *
	 * @param	array		$user	Holds the user data
	 * @param	boolean		$succes	True if user was succesfully stored in the database
	 * @param	string		$msg	Message
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	public function onUserAfterDelete($user, $success, $msg)
	{
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
	}
	
	
	/**
	 * @param	string	$context	The context for the data
	 * @param	int		$data		The user id
	 * @param	object
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	public function onContentPrepareData($context, $data)
	{
		$result = array() ;
		
		// Code here
		
		
		if( $path = $this->includeEvent(__FUNCTION__) ) @include $this->includeEvent(__FUNCTION__);
		
		return $this->resultBool($result);
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
