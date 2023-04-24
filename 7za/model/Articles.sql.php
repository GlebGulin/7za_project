<?PHP

$query = array
(
    // get all articles
    0 => "
        # query: 0
        SELECT
            *
        FROM
            #__articles
        WHERE
            category_id             = '$this->category_id'
        ORDER BY
            added_time DESC
    ",

    // get article by id
    1 => "
        # query: 1
        SELECT
            *
        FROM
            #__articles
        WHERE
            article_id                  =  '$this->article_id'
    ",

    // save article
    2 => "
        # query: 2
        UPDATE
            #__articles
        SET
            title                       = '$this->title',
            text                        = '$this->text',
            image_file_id               = '$this->image_file_id'
        WHERE
            article_id                  = '$this->article_id'
    ",

    // add article
    3 => "
        # query: 3
        INSERT INTO
            #__articles
        SET
            title                       = '$this->title',
            text                        = '$this->text',
            image_file_id               = '$this->image_file_id',
            category_id                 = '$this->category_id',
            added_time                  = '$this->added_time',
            visible                     = '1'
    ",

    // set visible for article
    4 => "
        # query: 4
        UPDATE
            #__articles
        SET
            visible                          = !visible
        WHERE
            article_id                       =  $this->article_id
    ",

    // remove article
    5 => "
        # query: 5
        DELETE FROM
            #__articles
        WHERE
            article_id                       =  $this->article_id
    ",

    // get articles for frontend
    6 => "
        # query: 6
        SELECT
            *
        FROM
            #__articles
        WHERE
            visible             = 1
            $this->condition
        ORDER BY
            added_time DESC
        LIMIT
            $this->articlesPerPage
    ",

    // get articles for page
    7 => "
        # query: 7
        SELECT
            *
        FROM
            #__articles
        WHERE
            visible             = 1
        AND category_id = $this->category_id
        ORDER BY
            added_time DESC
        $this->smLimitClause
    ",

    // get all categories
    8 => "
        # query: 8
        SELECT
            *
        FROM
            #__articles_categories
        ORDER BY
            position
    ",

    // add new category
    9 => "
        # query: 9
        INSERT INTO
            #__articles_categories
        SET
            name                = '$this->name',
            position            = '$this->position'
    ",

    // save category
    10 => "
        # query: 10
        UPDATE
            #__articles_categories
        SET
            name                = '$this->name'
        WHERE
            category_id         = '$this->category_id'
    ",

    // get category by id
    11 => "
        # query: 11
        SELECT
            *
        FROM
            #__articles_categories
        WHERE
            category_id         = '$this->category_id'
    ",

    // delete category
    12 => "
        # query: 12
        DELETE FROM
            #__articles_categories
        WHERE
            category_id         = '$this->category_id'
    ",

    // get last articles
    14 => "
        # query: 14
        SELECT
            *
        FROM
            #__articles WHERE visible='1'
        ORDER BY
            added_time DESC
        LIMIT
            $this->limit
    ",
);


?>