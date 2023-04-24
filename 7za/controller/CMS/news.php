<?php

	$this->moduleTpl = "CMS/news/index.tpl.html";
//	$this->leftMenuTpl = "left_menu/news.tpl.html";

    $news_id	= $this->getParam("GET", "news_id", "int");
    $page_id	= $this->getParam("GET", "page_id", "int");

    $year		= $this->getParam("GET", "year", "int");
    $month		= $this->getParam("GET", "month", "int");

    $mode           = $this->getParam("POST", "mode", "string");
    $email		    = $this->getParam("POST", "email", "string");
    $fullname       = $this->getParam("POST", "fullname", "string");
    $captcha_code   = $this->getParam("POST", "captcha_code", "string");

    $News =& $this->getClassOf("News");
    $Captcha = $this->getClassOf("utils.image.gd.Captcha");

    $this->tpl->assign("news", $News->getCurrentNewsFrontEnd( $this->language ));
    //$this->loadLanguageFile( $this->language . ".conf" );
    //$archive = $News->getArciveNavFrontEnd();
    //$this->tpl->assign("archive", $archive);

    if ( $year || $month )
    {
        $this->contentFile = "CMS/news/archive.tpl.html";

        if( $year && !$month )
            $this->tpl->assign("news", $News->getNewsForYearFrontEnd( $year, $this->language ));
            //$month = $News->getDefaultMonthFrontEnd( $year );
        else
        {
            if( !$year && !$month )
            {
                $year = date("Y");
                $month = $News->getDefaultMonthFrontEnd( $year );
            }

            $this->tpl->assign("news", $News->getArchNewsFrontEnd( $year, $month , $this->language ));
        }

        $this->tpl->assign( "year" , $year );
        $this->tpl->assign( "month" , $month );
        if ( $month )
            $this->tpl->assign( "month_name" , $this->lang["months"]["L_".$month] );
    }

    if ( $news_id )
	{
		//$this->moduleTpl = "cms/news/news.tpl.html";
		$this->contentFile = "CMS/news/news.tpl.html";
		if ( $news = $News->getNewsFrontEnd( $news_id , $this->language ) )
		{
			$this->tpl->assign( "news" , $news );
			$year = substr( $news['date'], 0, 4 );
			$month = substr( $news['date'], 5, 2 );
			$this->pageTitle = $news['title'];
			$this->pageTitleBig = "Новости";
			#$this->tpl->debugging = true;
			$this->tpl->assign( "last_news" , $News->getLastsForNews( $news_id , $this->language , 10 ) );
		}
		else
			$this->redirect( "/pages/3/" );

	    //$page = ( $Pages->getPageById( $this->language ) );
	    //if( $page )
		  //$this->tpl->assign( "page", $page );
	}

    if ( $mode == 'subscribe' && $email && $fullname && $captcha_code )
    {
    	if( $News->existsEmail( $email ) )
    		$this->redirect( "/news/" , "msg=email_exists");

        if ( !$Captcha->checkCaptcha($captcha_code) )
        {
            $this->passToTemplate($_POST);
            $this->showMessage("Введите код с картинки");
        }
        else
        {
            $News->importIntoClass("POST");
        	$News->subscribe();
        	$Captcha->killCaptcha();
        	$this->redirect( "/news/" , "msg=email_subscribed");
        }
    }

    if ( $mode == 'unsubscribe' && $subscriber )
    {
    	$News->unsubscribeEmail( $subscriber );
    	$this->redirect( "/".$this->lang_link."/news/" , "msg=email_unsubscribed");
    }

    $Captcha->initCaptcha();
    $msg = $this->getParam("GET", "msg", "string");

    if ( $msg == "email_exists" )
        $this->showMessage("Введенный e-mail адрес уже подписан на рассылку");

    if ( $msg == "email_unsubscribed" )
        $this->showMessage("Вы успешно отписаны от рассылки");

    if ( $msg == "email_subscribed" )
        $this->showMessage("Адрес успешно подписан на рассылку");


    //$this->parseLanguagePage("news");

?>