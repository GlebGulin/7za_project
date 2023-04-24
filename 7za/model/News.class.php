<?PHP

class News extends wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    var $current_quantity                   =  10;
    var $news_id                            =  0;
    var $title_rus                          = "";
    var $title_ukr                          = "";
    var $text_rus                           = "";
    var $text_ukr                           = "";
    var $date                               = "";
    var $year                               = 0;
    var $month                              = 0;
    var $start_qnt                          = 3;
    var $language                           = "rus";
    var $visible                            = 0;
    var $image_file_id                      = 0;

    var $imageWidth                         = 250;
    var $imageHeight                        = 200;

    var $rubric_id                           = 0;
    var $page_rus                            = 0;
    var $page_ukr                            = 0;
    var $page_id                             = 0;

    var $subscriber_id                      = 0;
    var $email                              = "";
    var $fullname                           = "";
    var $company                            = "";
    var $get_news                           = 0;
    var $send                               = 0;
    var $order                              = "subscriber_id";
    var $subject                            = "Рассылка новостей с сайта \"ВИЧЕ Консалтинг\"";
    var $crypt_key                          = "fxnsicretki";
    var $subscribersPerPage                 = 20;

    var $condition                          = "";

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     * each contructor within this framework must at least look like this one
     */
    function News()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/

    /**
     * Returns current news for admin
     *
     * @return array
     */
    function getCurrentNews()
    {
        return News::runQuery( 0, "getIndexArray", __FILE__.":".__LINE__ );
    }

    /**
     * Returns current news for front end
     *
     * @param string $lng
     */
    function getCurrentNewsFrontEnd( $lng = 'rus' )
    {
        $this->condition = "AND n.visible > 0";
        $news = News::runQuery( 0, "getIndexArray", __FILE__.":".__LINE__ );
        if ( !$news )
            return array();

        foreach ( $news as $key => $value )
        {
            $news[$key]['title'] = $value['title_'.$lng];
            unset($news[$key]['title_rus']);
            unset($news[$key]['title_ukr']);
            $news[$key]['text'] = $value['text_'.$lng];
            unset($news[$key]['text_rus']);
            unset($news[$key]['text_ukr']);
        }
        return $news;
    }

    /**
     * Returns news by its id
     *
     * @param int $news_id
     * @return array
     */
    function getNewsById( $news_id )
    {
        $this->news_id = $news_id;
        return News::runQuery( 1, "getArray", __FILE__.":".__LINE__ );
    }

    /**
     * Save news item
     *
     * @param int $news_id
     */
    function saveNews( $news_id )
    {
        $item = $this->getNewsById($news_id);

        $MM = $this->getClassOf("Modules.MediaManager");
        $MM->setImageSize($this->imageWidth, $this->imageHeight);

        if ( $this->image_file_id = $MM->addImageResized("image_file") )
            $MM->deleteFile($item["image_file_id"]);
        else
            $this->image_file_id = $item["image_file_id"];

        $this->news_id = $news_id;
        News::runQuery( 2, "none", __FILE__.":".__LINE__ );
    }

    /**
     * Save new news item
     *
     */
    function saveNewNews()
    {
        $MM = $this->getClassOf("Modules.MediaManager");
        $MM->setImageSize($this->imageWidth, $this->imageHeight);
        $this->image_file_id = $MM->addImageResized("image_file");

        $this->date = date("Y-m-d H:i:s");
        News::runQuery( 3, "none", __FILE__.":".__LINE__ );

        if ( $this->send )
        {
            $Distributions = $this->getClassOf("Distributions");
            $Distributions->addDistribution($this->title_rus, $this->text_rus);
        }
    }

    function sendNews( $news_id )
    {
        $emails = $this->getSubscribers();

        $this->passToTemplate( $this->getNewsById( $news_id ) );


//        $crypt =& $this->getClassOf("utils.crypt.micaCrypt");

        if ( !count($emails) ) return false;

        foreach ( $emails as $key => $value )
        {
//            $hash = $crypt->encrypt( $value['email'] , $this->crypt_key ) ;
//            $this->tpl->assign( 'hash' , $hash );
            $this->passToTemplate( $this->getNewsById( $news_id ) );

/*
            $mailer =& $this->getClassOf("utils.mail.MailLauncher");
            $mailer->setCharset("windows-1251");
            $mailer->init( $value['email'] , $this->subject, "admin@".$_SERVER['HTTP_HOST']);
            $mailer->setBody($this->tpl->fetch("mails/news.tpl.html"));
            $mailer->send();
*/

            $mailer = $GLOBALS['smtp_mail'];
            $headers['From']    = sprintf("\"=?windows-1251?B?%s?=\" <%s>", base64_encode('Тренинговая компания TBT-Ukraine'), FROM_EMAIL);
            $headers['MIME-Version'] = '1.0';
            $headers['Content-Type'] = 'text/html; charset="windows-1251"';
            $headers['Content-Transfer-Encoding'] = '8bit';
            $recipients = $value['email'];
            $headers['To'] = $recipients;
            $headers['Subject'] = $this->subject;
            if (preg_match("/[\x80-\xFF]/", $headers['Subject'])) $headers['Subject'] = sprintf("=?windows-1251?B?%s?=", base64_encode($headers['Subject']));
            $body = $this->tpl->fetch("mails/news.tpl.html");
            $send = $mailer->send($recipients, $headers, $body);

        }
    }

    function getSubscribers()
    {
        return News::runQuery( 15, "getIndexArray", __FILE__.":".__LINE__ );
    }

    /**
     * Change visible for news
     *
     * @param int $news_id
     */
    function visibleNews( $news_id )
    {
        $this->news_id = $news_id;
        News::runQuery( 4, "none", __FILE__.":".__LINE__ );
    }

    /**
     * Remove news item from db
     *
     * @param int $news_id
     */
    function deleteNews( $news_id )
    {
        $this->news_id = $news_id;
        News::runQuery( 5, "none", __FILE__.":".__LINE__ );
    }

    /**
     * Returns archive navigation bar for admin
     *
     * @return array
     */
    function getArciveNav()
    {
        $years = News::runQuery( 6, "getIndexArray", __FILE__.":".__LINE__ );
        foreach( $years as $key => $value )
        {
            $this->year = $value['date'];
            $months = News::runQuery( 7, "getIndexArray", __FILE__.":".__LINE__ );
            foreach( $months as $month )
                $arch[$value['date']][$month['month']] = strftime("%B", mktime(0, 0, 0, $month['month'], 1, 2000));
        }
        return isset($arch)?$arch:array();
    }

    /**
     * Returns archive navigation bar for front end
     *
     * @return array
     */
    function getArciveNavFrontEnd()
    {
        $years = News::runQuery( 10, "getIndexArray", __FILE__.":".__LINE__ );
        foreach( $years as $key => $value )
        {
            $this->year = $value['date'];
            $months = News::runQuery( 11, "getIndexArray", __FILE__.":".__LINE__ );
            foreach( $months as $month )
            {
                #$arch[$value['date']][$month['month']] = strftime("%B", mktime(0, 0, 0, $month['month'], 1, 2000));
                $arch[$value['date']][$month['month']] = $this->lang['months']['L_'.$month['month']];
            }
        }
        return isset($arch)?$arch:array();
    }

    /**
     * Returns default month for selected year for admin
     *
     * @param int $year
     * @return int
     */
    function getDefaultMonth( $year )
    {
           $this->year = $year;
           $months = News::runQuery( 7, "getIndexArray", __FILE__.":".__LINE__ );
        return $months[0]['month'];
    }

    /**
     * Returns default month for selected year for frontend
     *
     * @param int $year
     * @return int
     */
    function getDefaultMonthFrontEnd( $year )
    {
        $this->year = $year;
        $months = News::runQuery( 11, "getIndexArray", __FILE__.":".__LINE__ );
        return isset($months[0]['month'])?$months[0]['month']:false;
    }

    function getNewsForYearFrontEnd( $year, $lng )
    {
        $this->language = $lng;
        $this->year = $year;
        $news = News::runQuery( 23, "getIndexArray", __FILE__.":".__LINE__ );
        foreach ( $news as $key => $value )
        {
            if ( !$value['visible'] )
            {
                unset($news[$key]);
                continue;
            }
            $news[$key]['title'] = $value['title_'.$lng];
            unset($news[$key]['title_rus']);
            unset($news[$key]['title_ukr']);
            $news[$key]['text'] = $value['text_'.$lng];
            unset($news[$key]['text_rus']);
            unset($news[$key]['text_ukr']);
        }
        return $news;
    }


    /**
     * Returns news from archive for admin
     *
     * @param int $year
     * @param int $month
     * @return array
     */
    function getArchNews( $year, $month )
    {
        $this->year = $year;
        $this->month = $month;
        return News::runQuery( 8, "getIndexArray", __FILE__.":".__LINE__ );
    }

    /**
     * Returns archive news for frontend
     *
     * @param int $year
     * @param int $month
     * @param string $lng
     * @return array
     */
    function getArchNewsFrontEnd( $year, $month , $lng )
    {
        $this->language = $lng;
        $this->year = $year;
        $this->month = $month;
        $news =  News::runQuery( 8, "getIndexArray", __FILE__.":".__LINE__ );
        foreach ( $news as $key => $value )
        {
            if ( !$value['visible'] )
            {
                unset($news[$key]);
                continue;
            }
            $news[$key]['title'] = $value['title_'.$lng];
            unset($news[$key]['title_rus']);
            unset($news[$key]['title_ukr']);
            $news[$key]['text'] = $value['text_'.$lng];
            unset($news[$key]['text_rus']);
            unset($news[$key]['text_ukr']);
        }
        return $news;
    }

    /**
     * Returns news for frontend
     *
     * @param int $news_id
     * @param string $lng
     * @return array
     */
    function getNewsFrontEnd( $news_id, $lng = 'rus' )
    {
        $news = $this->getNewsById( $news_id );
        if ( !$news['visible'])
            return array();

        $news['title'] = $news['title_'.$lng];
        unset($news['title_rus']);
        unset($news['title_ukr']);
        $news['text'] = $news['text_'.$lng];
        unset($news['text_rus']);
        unset($news['text_ukr']);

        $news['is_current']    = $this->newsIsCurrent( $news_id );

        return $news;
    }

    /**
     * Returns news status
     *
     * @param int $news_id
     * @return bool
     */
    function newsIsCurrent( $news_id )
    {
        $item = $this->getNewsById( $news_id );
        $current_news = $this->getCurrentNews();
        if( isset($current_news[$this->current_quantity-1]['date']) && $current_news[$this->current_quantity-1]['date'] > $item['date'] )
            return false;
        return true;
    }

    /**
     * Returns news for startpage
     *
     * @param string $language
     * @return array
     */
    function getNewsForStartPage( $language = 'rus' )
    {
        $this->language = $language;
        $list = News::runQuery( 9, "getIndexArray", __FILE__.":".__LINE__ );
        if (is_array($list)) {
            foreach ($list as $key => $value ) {
                $list[$key]["title"] = $value["title_".$language];
                $list[$key]["text"] = $value["text_".$language];
                unset( $list[$key]["title_rus"] );
                unset( $list[$key]["title_ukr"] );
                unset( $list[$key]["text_rus"] );
                unset( $list[$key]["text_ukr"] );
            }
        }
        return $list;
    }

    /**
     * Returns exists email in db
     *
     * @param string $email
     * @return bool
     */
    function existsEmail( $email )
    {
        $this->email = $email;
        return News::runQuery( 12, "getNumRows", __FILE__.":".__LINE__ );
    }

    /**
     * add email
     *
     * @param string $email
     */
    function subscribeEmail( $email )
    {
        $this->email = $email;
        News::runQuery( 14, "none", __FILE__.":".__LINE__ );
    }

    function subscribe()
    {
        News::runQuery( 14, "none", __FILE__ . ':' . __LINE__ );
        return $this->lastInsertId();
    }

    /**
     * remove email by crypt code
     *
     * @param unknown_type $email
     */
    function unsubscribeEmail( $email )
    {
        $crypt =& $this->getClassOf("utils.crypt.micaCrypt");
        $this->email = $crypt->decrypt( $email , $this->crypt_key ) ;
        News::runQuery( 16, "none", __FILE__.":".__LINE__ );
    }

    function getRubrics()
    {
        return News::runQuery( 17, "getIndexArray", __FILE__.":".__LINE__ );
    }

    function getRubricById( $rubric_id )
    {
        $this->rubric_id = $rubric_id;
        return News::runQuery( 18, "getArray", __FILE__.":".__LINE__ );
    }

    function saveNewRubric()
    {
        News::runQuery( 19, "none", __FILE__.":".__LINE__ );
    }

    function saveRubric( $rubric_id )
    {
        $this->rubric_id = $rubric_id;
        News::runQuery( 20, "none", __FILE__.":".__LINE__ );
    }

    function deleteRubric( $rubric_id )
    {
        $this->rubric_id = $rubric_id;
        News::runQuery( 21, "none", __FILE__.":".__LINE__ );
    }

    function getRubricByPageId( $page_id )
    {
        $this->page_id = $page_id;
        $Pages = $this->getClassOf("Pages");
        $page = $Pages->getPageById( $page_id );
        $this->language = $page['language'];
        return News::runQuery( 22, "getArray", __FILE__.":".__LINE__ );
    }

    function getLastsForNews( $news_id , $language , $quantity )
    {
        $this->news_id = $news_id;
        $this->language = $language;
        $this->current_quantity = $quantity;
        $item = $this->getNewsById( $news_id );
        $this->condition = " AND n.news_id != $news_id AND n.visible > 0";
        return News::runQuery( 0, "getIndexArray", __FILE__.":".__LINE__ );
    }

    function getSubscribersForPage( $page, $order = "", $params = "" )
    {
        $this->smLimitClause = "";
        $this->order = $order ? $order : "subscriber_id";
        $num = News::runQuery( 24, "getNumRows", __FILE__ . ':' . __LINE__ );
        $this->initSplitMenu( $page, $this->subscribersPerPage, $num, "order=".$order);
        return News::runQuery( 24, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    function saveNewSubscriber()
    {
        News::runQuery( 25, "none", __FILE__ . ':' . __LINE__ );
        return $this->lastInsertId();
    }

    function getSubscriberById( $subscriber_id )
    {
        $this->subscriber_id = $subscriber_id;
        return News::runQuery( 26, "getArray", __FILE__ . ':' . __LINE__ );
    }

    function saveSubscriber( $subscriber_id )
    {
        $this->subscriber_id = $subscriber_id;
        News::runQuery( 27, "none", __FILE__ . ':' . __LINE__ );
    }

    function deleteSubscriber( $subscriber_id )
    {
        $this->subscriber_id = $subscriber_id;
        News::runQuery( 28, "none", __FILE__ . ':' . __LINE__ );
    }

/****************************************************************************
 *                      Helper functions                                    *
 ****************************************************************************/

    /**
     * wrapper around the runQuery method in dbHandler.class.php
     *
     * requires the appropiate query file for this class and
     * passes the query to dbHandler::runQuery()
     * returns an array or a string in accordance to the wanted result
     * The requirement for query file: it must have filename
     * <classname>.sql.php
     *
     * @author  Ralf Kramer, Alex Koshel
     * @param   int  query_id ( array index of the query within the
     *                          required query file )
     * @param   string result ( specifies the type of the expected
     *          result set
     *          e.g. "getArray", "getIndexArray", "getSingleValue" etc. )
     * @param   msq_id ( a hint that is thrown by the system when an error occurs )
     *
     * @return  mixed
     */
    function runQuery( $query_id, $result, $msg_id )
    {
        $queryFName = str_replace( ".class.php", ".sql.php", __FILE__ );
        require( $queryFName );
        return $this->core->runQuery( $query[$query_id], $result, $msg_id );
    }
}
?>