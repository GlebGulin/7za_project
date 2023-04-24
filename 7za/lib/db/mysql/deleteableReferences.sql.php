<?PHP 

$query = array
(
    // get all table names from DB
    0 => "
		# query: 0
        SHOW TABLES
    ",
    
    1 => "
		# query: 1
        SELECT
            *
        FROM
            #__deletable_references
        WHERE
            trigger = '$this->trigger'
    ",    
    
    2 => "
		# query: 2
        DELETE FROM
            `$this->table`
        WHERE
            $this->field = '$this->value'
    ",     
    
    // update fields of records with broken FK
    3 => "
        # query: 3
        UPDATE
            `$this->table`
        SET
            `$this->field` = '$this->new_value'
        WHERE
            `$this->field` = '$this->value'
    "
);


?>