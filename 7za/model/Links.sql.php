<?PHP 

$query = array
(
    // save new links item
    
    0 => "
		# query: 0
        INSERT INTO
            #__links
        SET
            title           = '$this->title',
            href            = '$this->href',
            language        = '$this->language',
            description     = '$this->description',
            position        = '$this->position',
            shown           = '$this->shown'
    ",
    // get all links items
    1 => "
        # query: 1
        SELECT
            *
        FROM
            #__links
        ORDER BY
            position ASC
    ",
    
    // hide links item
    2 => "
        # query: 2
        UPDATE
            #__links
        SET
            shown = '$this->shown'
        WHERE
            link_id ='$this->link_id'
    ",
    //get links item by id
    3 => "
        # query: 3
        SELECT
            *
        FROM
            #__links
        WHERE
            link_id = '$this->link_id'
    ",
    // delete links item
    4 => "
        # query: 4
        DELETE FROM
            #__links
        WHERE
            link_id = '$this->link_id'
    ",
    // save links item
    5 => "
        # query: 5
        UPDATE
            #__links
        SET
            title           = '$this->title',
            href            = '$this->href',
            language        = '$this->language',
            description     = '$this->description',
            shown           = '$this->shown'
        WHERE
            link_id         = '$this->link_id'
    ",
    
    // get link with less position
    6 => "
        # query: 6
        SELECT
            *
        FROM
            #__links
        WHERE
            position        < $this->position
        ORDER BY
            position DESC
    ",
    // get link with more position
    7 => "
         # query: 6
        SELECT
            *
        FROM
            #__links
        WHERE
            position        > $this->position
        ORDER BY
            position ASC
    ",
    // update position of the link
    8 => "
        # query: 8
        UPDATE
            #__links
        SET
            position        = '$this->position'
        WHERE
            link_id         = '$this->link_id'
    ",
    // get max position for new link
    9 => "
        # query: 8
        SELECT 
            MAX(position)
        FROM
            #__links
    ",
    // get visible links for language
    10 => "
        # query: 1
        SELECT
            *
        FROM
            #__links
        WHERE
            shown > 0
        AND 
        	language = '$this->language'
        ORDER BY
            position ASC
    "
    
);


?>