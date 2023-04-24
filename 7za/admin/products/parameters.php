<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController 
{
    var $contentFile        = "admin/products/parameters_groups.tpl.html";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	//$this->tpl->debugging = true;
    	//$this->core->showQuery = true;
    	
    	$mode 		 = $this->getParam("GET", "mode", "string");
        $group_id 	 = $this->getParam("GET", "group_id", "int") ;
        $parameter_id  = $this->getParam("GET", "parameter_id", "int");
        
        $Products =& $this->getClassOf("Products");
        
        $this->tpl->assign("groups",$Products->getParametersGroups());
        
       
        if ( $mode == 'edit_group' && $group_id ) 
        {
        	$this->contentFile = "admin/products/edit_parametrs_group.tpl.html";
        	$this->tpl->assign("group",$Products->getParametersGroupById( $group_id ));
        	$this->tpl->assign("parameters",$Products->getParametersByGroup( $group_id ));
        }
        
        if ( $mode == 'save_group' && $group_id ) 
        {
        	$Products->importIntoClass("POST");
            $Products->saveGroup( $group_id );
        	$this->redirect( "parameters.php" , "msg=group_saved");
        }      
        
        if ( $mode == 'add_group' )
        {
			$this->contentFile = "admin/products/add_parametrs_group.tpl.html";
        }        
        
        if ( $mode == 'save_new_group' ) 
        {
        	$Products->importIntoClass("POST");
            $Products->saveNewGroup();
        	$this->redirect( "parameters.php" , "msg=group_added" );
        }   
        
		if ( $mode == "delete_group" && $group_id )
		{   
			$Products->deleteGroup( $group_id );
        	$this->redirect( "parameters.php" , "msg=group_deleted" ); 			
		}
		
        if ( $mode == 'edit_parameter' && $parameter_id ) 
        {
            $this->tpl->assign("parameter",$Products->getParameterById( $parameter_id ));
        	$this->contentFile = "admin/products/edit_parameter.tpl.html";
        }	
        
        if ( $mode == 'save_parameter' && $parameter_id ) 
        {
        	$Products->importIntoClass("POST");
            $Products->saveParameter( $parameter_id );
        	$item = $Products->getParameterById( $parameter_id );
			$this->redirect( "parameters.php" , "mode=edit_group&group_id=".$item['group_id']."&msg=parameter_saved ");
        }     
        
        if ( $mode == 'add_parameter' && $group_id ) 
        {
        	$this->tpl->assign("group",$Products->getParametersGroupById( $group_id ));
        	$this->contentFile = "admin/products/add_parameter.tpl.html";
        }	        
        
        if ( $mode == 'save_new_parameter' && $group_id ) 
        {
        	$Products->importIntoClass("POST");
            $Products->saveNewParameter( $group_id );
			$this->redirect( "parameters.php" , "mode=edit_group&group_id=$group_id&msg=parameter_added" );
        }    
        
        if ( $mode == 'delete_parameter' && $parameter_id ) 
        {
        	$item = $Products->getParameterById( $parameter_id );
            $Products->deleteParameter( $parameter_id );
			$this->redirect( "parameters.php" , "mode=edit_group&group_id=".$item['group_id']."&msg=parameter_deleted" );
        }             

        if ( $mode == "move_parameter_up" && $parameter_id )
        {
        	$Products->moveParameterUp( $parameter_id );
			$item = $Products->getParameterById( $parameter_id );
        	$this->redirect( "parameters.php" , "mode=edit_group&group_id=".$item['group_id'] );        	
        }
        
        if ( $mode == "move_parameter_down" && $parameter_id )
        {
        	$Products->moveParameterDown( $parameter_id );
			$item = $Products->getParameterById( $parameter_id );
        	$this->redirect( "parameters.php" , "mode=edit_group&group_id=".$item['group_id'] );        	
        }               

        $msg = $this->getParam("GET", "msg", "string");
        
        if ( $msg == "parameter_saved" )
            $this->showMessage( "Параметр сохранен" );        
        
        if ( $msg == "parameter_added" )
        	$this->showMessage( "Параметр добавлен" ); 	
        	
        if ( $msg == "parameter_deleted" )
        	$this->showMessage( "Параметр удален" );         	
        	
        if ( $msg == "group_added" )
        	$this->showMessage( "Группа параметров добавлена" ); 
        	
        if ( $msg == "group_deleted" )
        	$this->showMessage( "Группа параметров удалена" );    
        	
        if ( $msg == "group_saved" )
        	$this->showMessage( "Группа параметров сохранена" );          	    	
 
        	        	       	
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