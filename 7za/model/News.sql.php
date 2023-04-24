<?PHP

$query = array
(
    // get current news
    0 => "
        # query: 0
        SELECT
            n.*,
            n.title_$this->language as title,
            n.text_$this->language as text
        FROM
            #__news n
        WHERE
            1
        $this->condition
        ORDER BY
            n.date DESC
        LIMIT                                   $this->current_quantity
    ",

    // get news by id
    1 => "
        # query: 1
        SELECT
            *
        FROM
            #__news
        WHERE
            news_id                            =  $this->news_id
    ",

    // save news
    2 => "
        # query: 2
        UPDATE
            #__news
        SET
            title_rus                       = '$this->title_rus',
            title_ukr                       = '$this->title_ukr',
            text_rus                        = '$this->text_rus',
            text_ukr                        = '$this->text_ukr',
            visible                         = '$this->visible',
            image_file_id                   = '$this->image_file_id'
        WHERE
            news_id                         =  $this->news_id
    ",

    // add news
    3 => "
        # query: 3
        INSERT INTO
            #__news
        SET
            title_rus                       = '$this->title_rus',
            title_ukr                       = '$this->title_ukr',
            text_rus                        = '$this->text_rus',
            text_ukr                        = '$this->text_ukr',
            date                            = '$this->date',
            visible                         = '$this->visible',
            image_file_id                   = '$this->image_file_id'
    ",

    // set visible for news
    4 => "
        # query: 4
        UPDATE
            #__news
        SET
            visible                          = !visible
        WHERE
            news_id                          =  $this->news_id
    ",

    // remove news
    5 => "
        # query: 5
        DELETE FROM
            #__news
        WHERE
            news_id                            =  $this->news_id
    ",

    // get news years
    6 => "
        # query: 6
        SELECT
            DISTINCT(DATE_FORMAT(date,'%Y')) AS date
        FROM
            #__news
        ORDER BY
            date DESC
    ",

    // get news month for years
    7 => "
        # query: 7
        SELECT
            DISTINCT(DATE_FORMAT(date,'%m')) AS month
        FROM
            #__news
        WHERE
            DATE_FORMAT(date,'%Y')            = '$this->year'
        ORDER BY
            date ASC
    ",

    // get archive news
    8 => "
        # query: 8
        SELECT
            n.*
        FROM
            #__news n
        WHERE
            n.visible                            > 0
        AND
            DATE_FORMAT(n.date,'%Y')            = '$this->year'
        AND
            DATE_FORMAT(n.date,'%m')            = '$this->month'
    ",

    // get current news
    9 => "
        # query: 9
        SELECT
            n.*
        FROM
            #__news n
        WHERE
            n.visible                            > 0
        ORDER BY
            n.date DESC
        LIMIT                                  $this->start_qnt
    ",

    // get news years for front end
    10 => "
        # query: 10
        SELECT
            DISTINCT(DATE_FORMAT(date,'%Y')) AS date
        FROM
            #__news
        WHERE
            visible                            >  0
        ORDER BY
            date DESC
    ",

    // get news month for years for front end
    11 => "
        # query: 11
        SELECT
            DISTINCT(DATE_FORMAT(date,'%m')) AS month
        FROM
            #__news
        WHERE
            DATE_FORMAT(date,'%Y')            = '$this->year'
        AND
            visible                            >  0
        ORDER BY
            date ASC
    ",

    // get subscriber by email
    12 => "
        # query: 12
        SELECT
            *
        FROM
            #__subscribers
        WHERE
            email                            = '$this->email'
    ",

    // add subscriber
    14 => "
        # query: 14
        INSERT INTO
            #__subscribers
        SET
            email                           = '$this->email',
            fullname                        = '$this->fullname'
    ",

    // get subscribers
    15 => "
        # query: 15
        SELECT
            *
        FROM
            #__subscribers
        ORDER BY
            $this->order
    ",

    // remove subscriber
    16 => "
        # query: 16
        DELETE FROM
            #__subscribers
        WHERE
            email                            = '$this->email'
    ",

    // get news rubrics
    17 => "
        # query: 17
        SELECT
            *
        FROM
            #__news_rubrics
    ",

    // get news rubrics
    18 => "
        # query: 18
        SELECT
            *
        FROM
            #__news_rubrics
        WHERE
            rubric_id           = '$this->rubric_id'
    ",

    // add rubric
    19 => "
        # query: 19
        INSERT INTO
            #__news_rubrics
        SET
            title_rus                            = '$this->title_rus',
            title_ukr                            = '$this->title_ukr',
            page_rus                            = '$this->page_rus',
            page_ukr                            = '$this->page_ukr'
    ",

    // update rubric
    20 => "
        # query: 20
        UPDATE
            #__news_rubrics
        SET
            title_rus                            = '$this->title_rus',
            title_ukr                            = '$this->title_ukr',
            page_rus                            = '$this->page_rus',
            page_ukr                            = '$this->page_ukr'
        WHERE
            rubric_id                           = '$this->rubric_id'
    ",

    // get news rubrics
    21 => "
        # query: 21
        DELETE FROM
            #__news_rubrics
        WHERE
            rubric_id                           = '$this->rubric_id'
    ",

    // get news rubric by page_id
    22 => "
        # query: 22
        SELECT
            *, title_$this->language as title
        FROM
            #__news_rubrics
        WHERE
            page_$this->language                = '$this->page_id'
    ",

    // get news for years for front end
    23 => "
        # query: 23
        SELECT
            *
        FROM
            #__news
        WHERE
            DATE_FORMAT(date,'%Y')            = '$this->year'
        AND
            visible                            >  0
        ORDER BY
            date ASC
    ",

    // get subscribers for page
    24 => "
        # query: 24
        SELECT
            *
        FROM
            #__subscribers
        ORDER BY
            $this->order
        $this->smLimitClause
    ",

    // add new subscriber
    25 => "
        # query: 25
        INSERT INTO
            #__subscribers
        SET
            fullname                    = '$this->fullname',
            company                     = '$this->company',
            email                       = '$this->email',
            get_news                    = '$this->get_news'
    ",

    // get subscriber by id
    26 => "
        # query: 26
        SELECT
            *
        FROM
            #__subscribers
        WHERE
            subscriber_id               = '$this->subscriber_id'
    ",

    // save subscriber
    27 => "
        # query: 27
        UPDATE
            #__subscribers
        SET
            fullname                    = '$this->fullname',
            company                     = '$this->company'
        WHERE
            subscriber_id               = '$this->subscriber_id'
    ",

    // delete subscriber by id
    28 => "
        # query: 28
        DELETE FROM
            #__subscribers
        WHERE
            subscriber_id               = '$this->subscriber_id'
    ",

);


?>