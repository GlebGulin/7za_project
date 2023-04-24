<?PHP 

$query = array
(
    // get all prices
    0 => "
		# query: 0
        SELECT 
            *
        FROM
            #__prices
        ORDER BY
            title
    ",
    
    // add new price
    1 => "
        # query: 1
        INSERT INTO
            #__prices
        SET
            title               = '$this->title',
            price_file_id       = '$this->price_file_id',
            added_time          = '".date("Y-m-d H:i:s")."'
    ",
    
    // get price by ID
    2 => "
        # query: 2
        SELECT
            *
        FROM
            #__prices
        WHERE
            price_id            = '$this->price_id'
    ",
    
    // save price
    3 => "
        # query: 3
        UPDATE
            #__prices
        SET
            title               = '$this->title',
            price_file_id       = '$this->price_file_id',
            added_time          = '".date("Y-m-d H:i:s")."'
        WHERE
            price_id            = '$this->price_id'
    ",
    
    // delete price
    4 => "
        # query: 4
        DELETE FROM
            #__prices
        WHERE
            price_id            = '$this->price_id'
    "
    
);


?>