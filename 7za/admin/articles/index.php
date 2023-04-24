<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController
{
    var $contentFile        = "admin/articles/categories.tpl.html";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	$mode 	    = $this->getParam("GET", "mode", "string");
        $id         = $this->getParam("GET", "id", "int");

        $Articles =& $this->getClassOf("Articles");

        if ( $mode == "edit" && $id )
        {
        	$this->contentFile = "admin/articles/edit.tpl.html";
        	$item = $Articles->getArticleById( $id );
        	$this->initEditor("text", $item['text'] , "editor_code" );
        	$this->tpl->assign( "item", $item );
        }

        if ( $mode == "save" && $id )
        {
        	$Articles->importIntoClass("POST");
        	$Articles->text = $this->getEditorCode("text");
        	$Articles->saveArticle( $id );
        	$this->redirect("index.php" , "mode=articles&id=".$id."&msg=saved");
        }

        if ( $mode == "add" && $id )
        {
        	$this->contentFile = "admin/articles/add.tpl.html";
        	$this->initEditor("text", "" , "editor_code" );
        	$this->tpl->assign("category", $Articles->getCategoryById($id));
        }

        if ( $mode == "save_new" && $id )
        {
        	$Articles->importIntoClass("POST");
        	$Articles->text = $this->getEditorCode("text");
        	$Articles->category_id = $id;
        	$Articles->addArticle();
        	$this->redirect("index.php" , "mode=articles&id=".$id."&msg=added");
        }

        if ( $mode == "visible" && $id )
        {
        	$Articles->visibleArticle( $id );
        	$item = $Articles->getArticleById($id);
        	$this->redirect("index.php", "mode=articles&id=".$item["category_id"]);
        }

        if ( $mode == "delete" && $id )
        {
            $item = $Articles->getArticleById($id);
        	$Articles->deleteArticle( $id );

            $this->redirect("index.php" , "mode=articles&id=".$item["category_id"]."&msg=deleted");
        }

        if ( $mode == "articles" && $id )
        {
            $this->contentFile = "admin/articles/index.tpl.html";
            $this->tpl->assign("articles", $Articles->getArticles($id));
            $this->tpl->assign("category", $Articles->getCategoryById($id));
        }

        if ( $mode == "add_category" )
        {
            $this->contentFile = "admin/articles/add_category.tpl.html";
        }

        if ( $mode == "edit_category" && $id )
        {
            $this->tpl->assign("category", $Articles->getCategoryById($id));
            $this->contentFile = "admin/articles/edit_category.tpl.html";
        }

        if ( $mode == "save_new_category" )
        {
            $Articles->importIntoClass("POST");
            $Articles->addCategory();
            $this->redirect("index.php", "msg=cat_added");
        }

        if ( $mode == "save_category" && $id )
        {
            $Articles->importIntoClass("POST");
            $Articles->saveCategory($id);
            $this->redirect("index.php", "msg=cat_saved");
        }

        if ( $mode == "category_up" && $id )
        {
            $Articles->moveCategoryUp($id);
            $this->redirect("index.php");
        }

        if ( $mode == "category_down" && $id )
        {
            $Articles->moveCategoryDown($id);
            $this->redirect("index.php");
        }
        if ($mode == 'delete_category' && $id) {
            $Articles->deleteCategory($id);
            $this->redirect("index.php");
        }

        $this->tpl->assign("categories", $Articles->getCategories());

        $msg = $this->getParam("GET", "msg", "string");

        if ( $msg == "saved" )
            $this->showMessage( "Статья сохранена" );

        if ( $msg == "added" )
            $this->showMessage( "Статья добавлена" );

        if ( $msg == "deleted" )
            $this->showMessage( "Статья удалена" );

        if ( $msg == "cat_added" )
            $this->showMessage( "Категория добавлена" );

        if ( $msg == "cat_saved" )
            $this->showMessage( "Категория сохранена" );

    }

    function render()
    {
        $this->adminPart = "articles";
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>