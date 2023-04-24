<?PHP

class Articles extends wrapper
{
/****************************************************************************
 *                      Member variables                                    *
 ****************************************************************************/

    var $article_id                         = 0;
    var $title                              = "";
    var $text                               = "";
    var $added_time                         = "";
    var $image_file_id                      = 0;
    var $start_qnt                          = 3;
    var $limit                              = 0;

    var $category_id                        = 0;
    var $name                               = "";
    var $position                           = 0;

    var $imageWidth                         = 250;
    var $imageHeight                        = 200;

    var $articlesPerPage                    = 20;

    var $page_rus                           = 0;
    var $page_ukr                           = 0;
    var $page_id                            = 0;

    var $condition                          = "";

/****************************************************************************
 *                      Initialization                                      *
 ****************************************************************************/

    /**
     * constructor
     */
    function Articles()
    {
        parent::wrapper();
    }

/****************************************************************************
 *                      Developer's methods area                            *
 ****************************************************************************/

    /**
     * Returns all articles for admin
     *
     * @param   int     $category_id
     * @return  array
     */
    function getArticles( $category_id )
    {
        $this->category_id = $category_id;
        return Articles::runQuery( 0, "getIndexArray", __FILE__.":".__LINE__ );
    }

    /**
     * Returns article by its id
     *
     * @param int $article_id
     * @return array
     */
    function getArticleById( $article_id )
    {
        $this->article_id = $article_id;
        return Articles::runQuery( 1, "getArray", __FILE__.":".__LINE__ );
    }

    /**
     * Save article
     *
     * @param int $article_id
     */
    function saveArticle( $article_id )
    {
        $item = $this->getArticleById($article_id);

        $MM = $this->getClassOf("Modules.MediaManager");
        $MM->setImageSize($this->imageWidth, $this->imageHeight);

        if ( $this->image_file_id = $MM->addImageResized("image_file") )
            $MM->deleteFile($item["image_file_id"]);
        else
            $this->image_file_id = $item["image_file_id"];

        $this->article_id = $article_id;
        Articles::runQuery( 2, "none", __FILE__.":".__LINE__ );
    }

    /**
     * Save new article
     *
     */
    function addArticle()
    {
        $MM = $this->getClassOf("Modules.MediaManager");
        $MM->setImageSize($this->imageWidth, $this->imageHeight);
        $this->image_file_id = $MM->addImageResized("image_file");

        $this->added_time = date("Y-m-d H:i:s");
        Articles::runQuery( 3, "none", __FILE__.":".__LINE__ );
        return $this->lastInsertId();
    }

    /**
     * Change visible for article
     *
     * @param int $article_id
     */
    function visibleArticle( $article_id )
    {
        $this->article_id = $article_id;
        Articles::runQuery( 4, "none", __FILE__.":".__LINE__ );
    }

    /**
     * Remove article
     *
     * @param int $article_id
     */
    function deleteArticle( $article_id )
    {
        $item = $this->getArticleById($article_id);
        $MM = $this->getClassOf("Modules.MediaManager");
        $MM->deleteFile($item["image_file_id"]);

        $this->article_id = $article_id;
        Articles::runQuery( 5, "none", __FILE__.":".__LINE__ );
    }

    function getArticlesForFrontend( $article_id = 0 )
    {
        if ( $article_id )
            $this->condition = " AND article_id <> '" . $article_id . "'";
        return Articles::runQuery( 6, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    function getArticlesForFrontendPage( $page, $category_id )
    {
        $this->smLimitClause = "";
        $this->category_id = $category_id;
        $num = Articles::runQuery( 7, "getNumRows", __FILE__ . ':' . __LINE__ );
        $this->initSplitMenu($page, $this->articlesPerPage, $num);
        return Articles::runQuery( 7, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    function getCategories()
    {
        return Articles::runQuery( 8, "getIndexArray", __FILE__ . ':' . __LINE__ );
    }

    function addCategory()
    {
        $this->position = $this->getNextPosition("#__articles_categories");
        Articles::runQuery( 9, "none", __FILE__ . ':' . __LINE__ );
        return $this->lastInsertId();
    }

    function moveCategoryUp( $category_id )
    {
        $this->moveItemUp($category_id, "#__articles_categories");
    }

    function moveCategoryDown( $category_id )
    {
        $this->moveItemDown($category_id, "#__articles_categories");
    }

    function saveCategory( $category_id )
    {
        $this->category_id = $category_id;
        Articles::runQuery( 10, "none", __FILE__ . ':' . __LINE__ );
    }

    function getCategoryById( $category_id )
    {
        $this->category_id = $category_id;
        return Articles::runQuery( 11, "getArray", __FILE__ . ':' . __LINE__ );
    }

    function deleteCategory( $category_id )
    {
        $articles = $this->getArticles($category_id);
        for ( $i = 0; $i < count($articles); $i++ )
            $this->deleteArticle($articles[$i]["article_id"]);

        $this->category_id = $category_id;
        Articles::runQuery( 12, "none", __FILE__ . ':' . __LINE__ );
    }

    function getLastArticles($limit = 3)
    {
        $this->limit = $limit;
        return Articles::runQuery( 14, "getIndexArray", __FILE__ . ':' . __LINE__ );
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