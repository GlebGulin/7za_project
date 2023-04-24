<?PHP 

$query = array
(
    // get option value
    0 => "
		# query: 0
        SELECT 
            *
        FROM
            #__registry
        WHERE
            application     = '$this->application'
        AND
            module          = '$this->module'
        AND
            name            = '$this->name'
    ",
    
    // updating option value
    1 => "
        # query: 1
        UPDATE
            #__registry
        SET
            value           = '$this->value'
        WHERE
            application     = '$this->application'
        AND
            module          = '$this->module'
        AND
            name            = '$this->name'
    ",
    
    // inserting new option
    2 => "
        # query: 2
        INSERT INTO
            #__registry
        SET
            application     = '$this->application',
            module          = '$this->module',
            name            = '$this->name',
            value           = '$this->value'
    ",
    
    // get options by module
    3 => "
        # query: 3
        SELECT 
            *
        FROM
            #__registry
        WHERE
            application     = '$this->application'
        AND
            module          = '$this->module'
    ",
    
    // delete value from registry
    4 => "
        # query: 4
        DELETE FROM
            #__registry
        WHERE
            application     = '$this->application'
        AND
            module          = '$this->module'
        AND
            name            = '$this->name'
    "
    
);


?>