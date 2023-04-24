<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController 
{
    var $contentFile        = "admin/prices/index.tpl.html";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	//$this->tpl->debugging = true;
    	//$this->core->showQuery = true;    	
    	
        $mode = $this->getParam("GET", "mode", "string");
        $id   = $this->getParam("GET", "id", "int");
        $msg  = $this->getParam("GET", "msg", "string");
        
        $Prices =& $this->getClassOf("PriceFiles");
        
        if ( $mode == "save_new" )
        {
            $Prices->importIntoClass("POST");
            if ( $Prices->addNewPrice() )
                $this->redirect("index.php", "msg=added");
            else 
                $this->redirect("index.php", "msg=failed");
        }
        
        if ( $mode == "save" && $id )
        {
            $Prices->importIntoClass("POST");
            $Prices->savePrice($id);
            $this->showMessage("Изменения сохранены");
        }
        
        if ( $mode == "delete" && $id )
        {
            if ( $Prices->deletePrice($id) )
                $this->showMessage("Прайс-лист удален");
        }
        
        if ( $mode == "new" )
            $this->contentFile = "admin/prices/new.tpl.html";
            
        if ( $mode == "edit" && $id )
        {
            $this->tpl->assign("price", $Prices->getPriceById($id));
            $this->contentFile = "admin/prices/edit.tpl.html";
        }
        
        if ( $msg == "added" )
            $this->showMessage("Новый прайс добавлен");
            
        if ( $msg == "failed" )
            $this->showMessage("Ошибка при добавлении прайс-листа (возможно неверный тип файла)");
        
        $this->tpl->assign("prices", $Prices->getAllPrices());
    }
    
    function render()
    {
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