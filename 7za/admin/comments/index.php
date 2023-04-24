<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController
{

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
        $Comments = $this->getClassOf("Comments");
        $Products = $this->getClassOf("Products");

        $mode = $this->getParam( "GET", "mode", "string" );
        $id   = $this->getParam( "GET", "id", "int" );

        $this->contentFile = "admin/comments/index.tpl.html";

        if ( $mode == "delete" && $id )
        {
            $Comments->deleteComment($id);
            $this->showMessage("Комментарий удален");
        }

        if ( $mode == "save" && $id )
        {
            $Comments->importIntoClass("POST");
            $Comments->saveComment($id);
            $this->showMessage("Комментарий сохранен");
        }

        if ( $mode == "edit" && $id )
        {
            $this->contentFile = "admin/comments/edit.tpl.html";
            $comment = $Comments->getCommentById($id);
            $comment["item"] = $Products->getProductById($comment["item_id"]);
            $this->tpl->assign("comment", $comment);
        }

        $comments = $Comments->getLastComments(30);
        $this->tpl->assign("comments", $comments);

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