<?php
/************************************************************
 *                 Initialization section
 ************************************************************/

require_once("./controller/PublicBaseController.class.php");

class Controller extends PublicBaseController
{
	var $moduleTpl							= "";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	$mode = $this->getParam("GET", "mode", "string");
        $page_id = $this->getParam("GET", "page_id", "int");
        if ( $page_id == 1 || !$page_id )
        	$this->redirect( URL_ROOT . "/index.php");
               
        $Pages =& $this->getClassOf("Pages");
        $page = $Pages->getPageById( $page_id );
        
        if ( !$page['visible'] ) 
        	$this->redirect( "/index.php" );
        
        $this->tpl->assign( "page", $page );
        $this->tpl->assign( "path", $Pages->getPagePath( $page_id ) );
        $this->pageTitle = $page['title'];
        
        $this->contentFile = "CMS/index.tpl.html";
        
    	$Products = $this->getClassOf("Products");
    	$this->tpl->assign( "catnav" , $Products->getCategoriesForStartPage() );         
        
  		if ( $mode == 'print' )	
  			 $this->tplToDisplay = "cms/print.tpl.html";        
        
        if ( $page['include_module'] != "" )
     		$ini = parse_ini_file( "./lib/CMS/".$page['include_module'].".ini" );
     		
  		if( isset( $ini['controller']) )
  			include_once( "./controller/CMS/".$ini['controller'] );
    }

    function render()
    {
    	$this->tpl->assign( "moduleTpl",$this->moduleTpl );
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>