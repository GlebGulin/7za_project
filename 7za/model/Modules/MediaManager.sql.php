<?PHP 

$query = array
(
    // add new file record
    0 => "
		# query: 0
        INSERT INTO
            #__mm_files
        SET
            file_name       = '$this->file_name',
            file_type       = '$this->file_type',
            file_url        = '$this->file_url',
            file_path       = '$this->file_path',
            title           = '$this->title',
            name            = '$this->name',
            description     = '$this->description',
            attributes      = '$this->attributes',
            type            = '$this->type',
            user_id         = '$this->user_id',
            mtt_id          = '$this->mtt_id',
            `group`           = '$this->group',
            added_time      = NOW()
    ",
    
    // get file record by file id
    1 => "
        # query: 1
        SELECT
            *
        FROM
            #__mm_files
        WHERE
            file_id = '$this->file_id'
    ",
    
    // delete file record
    2 => "
        # query: 2
        DELETE FROM
            #__mm_files
        WHERE
            file_id = '$this->file_id'
    ",
    
    // get files for time interval
    3 => "
        # query: 3
        SELECT
            *
        FROM
            #__mm_files
        WHERE
            added_time  >= '$this->start_date'
        AND
            added_time  <= '$this->end_date'
    ",
    
    // get files of specified user
    4 => "
        # query: 4
        SELECT
            *
        FROM
            #__mm_files
        WHERE
            user_id = '$this->user_id'
    ",
    
    // get files of specified mtt_id
    5 => "
        # query: 5
        SELECT
            *
        FROM
            #__mm_files
        WHERE
            mtt_id = '$this->mtt_id'
    ",
    
    // get files of specified group
    6 => "
        # query: 6
        SELECT
            *
        FROM
            #__mm_files
        WHERE
            group = '$this->group'
    ",
    
    // update file info
    7 => "
        # query: 7
        UPDATE
            #__mm_files
        SET
            title       = '$this->title',
            description = '$this->description'
        WHERE
            file_id     = '$this->file_id'
    ",
    
    // update file_name
    8 => "
        # query: 8
        UPDATE
            #__mm_files
        SET
            file_name   = '$this->file_name'
        WHERE
            file_id     = '$this->file_id'
    "
);


?>