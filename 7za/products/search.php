<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../controller/PublicBaseController.class.php");

class Controller extends PublicBaseController
{

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	$this->contentFile = "products/search.tpl.html";

        $Products = $this->getClassOf("Products");

	    $mode       	= $this->getParam("GET", "mode", "string");
        $word       	= $this->getParam("GET", "word", "string");
        $smIndex 	   	= $this->getParam( "GET", "smIndex", "int" );

        $this->tpl->assign( "catnav" , $Products->getCategoriesForStartPage() );

        if( $mode == "search" && $word )
        {
        	$Products->importIntoClass("GET");
     		$this->tpl->assign("products", $Products->getSearchProducts( $word, "search.php","mode=search&word=$word" ));
     		$this->tpl->assign("search_result_qnt" , $Products->search_result_qnt );
			$this->sm->setCssClass("sm");
			$this->sm->setCssSelectedClass("sm_sel");
     		$this->tpl->assign("splitMenu", $Products->sm->makeLinkMenu());
     		$Products->setSearchRedirect( $smIndex, $mode, $word );
     		$this->tpl->assign("path" , $Products->getNavPathForSearch() );
        }
        elseif ( $mode == 'back' )
        {
        	$this->redirect( "/products/search.php?" . $Products->getSearchRedirect() );
        }
        else
        	$this->redirect( "/" );

        $this->tpl->assign("word", $word);

    }

    function render()
    {
        $this->display();
    }
}


/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>