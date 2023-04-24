<?PHP

$query = array
(
    // get comments for item
    0 => "
		# query: 0
        SELECT
            *
        FROM
            #__comments
        WHERE
            item_id                 = '$this->item_id'
        ORDER BY
            added_time
    ",

    // add comment for item
    1 => "
		# query: 1
        INSERT INTO
            #__comments
        SET
            item_id                 = '$this->item_id',
            author                  = '$this->author',
            author_ip               = '$this->author_ip',
            comment_text            = '$this->comment_text',
            added_time              = '$this->added_time'
    ",

    // get comments for specified date and IP
    2 => "
        # query: 2
        SELECT
            *
        FROM
            #__comments
        WHERE
            author_ip               = '$this->author_ip'
        AND
            added_time              LIKE '$this->added_time'
    ",

    // get last comments
    3 => "
        # query: 3
        SELECT
            c.*, p.product_name
        FROM
            #__comments c LEFT JOIN #__product p ON c.item_id=p.product_id
        ORDER BY
            c.added_time DESC
        LIMIT
            $this->limit
    ",

    // get comment by id
    4 => "
        # query: 4
        SELECT
            *
        FROM
            #__comments
        WHERE
            comment_id              = '$this->comment_id'
    ",

    // delete comment
    5 => "
        # query: 5
        DELETE FROM
            #__comments
        WHERE
            comment_id              = '$this->comment_id'
    ",

    // save comment
    6 => "
        # query: 6
        UPDATE
            #__comments
        SET
            author                  = '$this->author',
            comment_text            = '$this->comment_text'
        WHERE
            comment_id              = '$this->comment_id'
    "

);


?>