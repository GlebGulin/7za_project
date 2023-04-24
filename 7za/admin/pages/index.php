<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController 
{
    var $contentFile        = "admin/pages/index.tpl.html";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	//$this->core->showQuery = true;
    	//$this->tpl->debugging = true;
        
    	$mode 	  = $this->getParam("GET", "mode", "string");
        $page_id  = $this->getParam("GET", "page_id", "int");
        
        $Pages =& $this->getClassOf("Pages");
        
        $this->tpl->assign("pages", $Pages->getPagesForAdmin() );
        
        if( $mode == 'popup' && $page_id )
        {
        	 $this->tpl->assign( "page", $Pages->getPageById( $page_id ) );
			 $this->tpl->display( "admin/pages/popup.tpl.html" );
			 exit;
        }          
        
        if ($mode == 'edit_page' && $page_id )
        {
        	$this->contentFile = "admin/pages/edit_page.tpl.html";
        	$page = $Pages->getPageById( $page_id );
        	$this->initEditor("content", $page['content'] );
        	$this->tpl->assign("page", $page);
        }
        
        if( $mode == 'save_page' && $page_id )
        {
        	$Pages->importIntoClass("POST");
        	$Pages->content = $this->getEditorCode("content");
            $Pages->savePage( $page_id );
			$this->redirect( "index.php","msg=page_saved" );
        }	
        
        if ($mode == 'add_page' && $page_id )
        {
        	$path = $Pages->getPagePath( $page_id );
			if( count($path) == 0 || count($path) >= 3 )
				$this->redirect( "index.php","msg=page_level" );
				
        	$this->contentFile = "admin/pages/add_page.tpl.html";
        	$page = $Pages->getPageById( $page_id );
        	$this->initEditor("content");
        	$this->tpl->assign("page", $page);
        }
        
        if( $mode == 'save_new_page' && $page_id )
        {
        	$path = $Pages->getPagePath( $page_id );
			if( count($path) == 0 || count($path) >= 3 )
				$this->redirect( "index.php","msg=page_level" );        	
        	
        	$Pages->importIntoClass("POST");
        	$Pages->content = $this->getEditorCode("content");
            $Pages->saveNewPage( $page_id );
			$this->redirect( "index.php","msg=page_added" );
        }	        
        
        if ( $mode == "visible" && $page_id )
        {
            $Pages->changeVisibility( $page_id );
            $this->redirect("index.php");
        }     
        
        if ( $mode == "in_menu" && $page_id )
        {
            $Pages->changeInMenu( $page_id );
            $this->redirect("index.php");
        }             
        
        if ( $mode == "move_page_up" && $page_id )
        {
        	$Pages->movePageUp( $page_id );
        	$this->redirect("index.php");        	
        }
        
        if ( $mode == "move_page_down" && $page_id )
        {
        	$Pages->movePageDown( $page_id );
        	$this->redirect("index.php");         	
        }      
        
        if( $mode == 'delete_page' && $page_id )
        {
        	$page = $Pages->getPageById( $page_id );
        	if($page['forbid_remove']) 
        		$this->redirect("index.php"); 
        	$Pages->deletePage( $page_id );
        	$this->redirect("index.php", "msg=page_deleted"); 
        }          
        
        $msg = $this->getParam("GET", "msg", "string");

        if ( $msg == "page_saved" )
            $this->showMessage( "Страница сохранена" );   
            
        if ( $msg == "page_added" )
            $this->showMessage( "Страница добавлена" );
            
        if ( $msg == "page_deleted" )
            $this->showMessage( "Страница удалена" );
            
        if ( $msg == "page_level" )
            $this->showMessage( "Нельзя создать страницу на этом уровне" );                        
            
		           

    }
    
    function render()
    {
        $this->tplToDisplay = "admin/main.tpl.html";
        $this->tpl->assign("contentFile", $this->contentFile);
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>