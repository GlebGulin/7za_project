<?php
/************************************************************
 *                 Initialization section
 ************************************************************/
require_once("../../controller/AdminBaseController.class.php");

class Controller extends AdminBaseController
{
    var $contentFile        = "admin/news/index.tpl.html";

/************************************************************
 *           Add controller logic in process() method
 ************************************************************/
    function process()
    {
    	$mode 	    = $this->getParam("GET", "mode", "string");
        $news_id	= $this->getParam("GET", "news_id", "int");
        $year		= $this->getParam("GET", "year", "int");
        $month		= $this->getParam("GET", "month", "int");

        $News =& $this->getClassOf("News");
        

        $this->tpl->assign("news", $News->getCurrentNews());

        if ( $mode == "edit_news" && $news_id )
        {
        	$this->contentFile = "admin/news/edit_news.tpl.html";
        	$item = $News->getNewsById( $news_id );
        	$this->initEditor("text_rus", $item['text_rus'] , "editor_code_rus" );
        	$this->tpl->assign( "item", $item );
        }

        if ( $mode == "save_news" && $news_id )
        {
        	$News->importIntoClass("POST");
        	$News->text_rus = $this->getEditorCode("text_rus");
        	$News->saveNews( $news_id );
        	if( !$News->newsIsCurrent( $news_id ) )
        	{
        		$item = $News->getNewsById( $news_id );
        		$this->redirect("index.php" , "msg=news_saved");
        	}
        	$this->redirect("index.php" , "msg=news_saved");
        }

        if ( $mode == "add_news" )
        {
        	$this->contentFile = "admin/news/add_news.tpl.html";
        	$this->initEditor("text_rus", "" , "editor_code_rus" );
        }

        if ( $mode == "save_new_news" )
        {
        	$News->importIntoClass("POST");
        	$News->text_rus = $this->getEditorCode("text_rus");
        	$News->saveNewNews();
        	$this->redirect("index.php" , "msg=news_added");
        }

        if ( $mode == "visible_news" && $news_id )
        {
        	$News->visibleNews( $news_id );
        	if( !$News->newsIsCurrent( $news_id ) )
        	{
        		$item = $News->getNewsById( $news_id );
        		$this->redirect("index.php");
        	}
        	$this->redirect("index.php");
        }

        if ( $mode == "delete_news" && $news_id )
        {
        	$news_is_current = $News->newsIsCurrent( $news_id );

        	if( !$news_is_current )
        	{
        		$item = $News->getNewsById( $news_id );
        	}

        	$News->deleteNews( $news_id );

            $this->redirect("index.php" , "msg=news_deleted");
        }

        $msg = $this->getParam("GET", "msg", "string");

        if ( $msg == "news_saved" )
            $this->showMessage( "Новость сохранена" );

        if ( $msg == "news_added" )
            $this->showMessage( "Новость добавлена" );

        if ( $msg == "news_deleted" )
            $this->showMessage( "Новость удалена" );

    }

    function render()
    {
        $this->adminPart = "news";
        $this->display();
    }
}

/************************************************************
 *                      Executing area
 ************************************************************/
// Next line initializes and executes the controller
require_once( CONTROLLER_DIR . "footer.inc.php" );

?>