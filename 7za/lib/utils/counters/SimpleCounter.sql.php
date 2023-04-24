<?PHP 

$query = array
(
    // get all table names from DB
    0 => "
		# query: 0
        SHOW TABLES
    ",
    // create stats table
    1 => "
        # query: 1
        CREATE TABLE $this->tableStatsName (
            area varchar(150) NOT NULL default '',
            unique_hits_this_month bigint(20) unsigned NOT NULL default '0',
            hits_this_month bigint(20) unsigned NOT NULL default '0',
            unique_hits_last_month bigint(20) unsigned NOT NULL default '0',
            hits_last_month bigint(20) unsigned NOT NULL default '0',
            unique_hits_total bigint(20) unsigned NOT NULL default '0',
            hits_total bigint(20) unsigned NOT NULL default '0',
            last_hit_date date NOT NULL default '0000-00-00',
            PRIMARY KEY  (area)
        ) TYPE=MyISAM COMMENT='For storing stats per area'
    ",
    // get last hit time for the area
    2 => "
        # query: 2
        SELECT
            last_hit_date
        FROM
            $this->tableStatsName
        WHERE
            area = '".addslashes($this->area)."'
    ",
    // increase counter for total and current month
    3 => "
        # query: 3
        UPDATE
            $this->tableStatsName
        SET
            hits_this_month=hits_this_month+1,
            hits_total=hits_total+1,
            last_hit_date='".date("Y-m-d")."'
        WHERE
            area='".addslashes($this->area)."'
    ",
    // insert new record for the area
    4 => "
        # query: 4
        INSERT INTO
            $this->tableStatsName
        SET
            area='".addslashes($this->area)."'
    ",
    // put current month hits on a place of last month
    5 => "
        # query: 5
        UPDATE
            $this->tableStatsName
        SET
            hits_last_month=hits_this_month,
            unique_hits_last_month=unique_hits_this_month,
            hits_this_month=0,
            unique_hits_this_month=0
        WHERE
            area='".addslashes($this->area)."'
    ",
    // put zeros on places of current and last monthes
    6 => "
        # query: 6
        UPDATE
            $this->tableStatsName
        SET
            hits_this_month=0,
            unique_hits_this_month=0,
            hits_last_month=0,
            unique_hits_last_month=0
        WHERE
            area='".addslashes($this->area)."'
    ",
    // get total stats
    7 => "
        # query: 7
        SELECT
            sum(hits_total) as total,
            sum(unique_hits_total) as unique_total,
            sum(hits_this_month) as total_this_month,
            sum(unique_hits_this_month) as unique_total_this_month,
            sum(hits_last_month) as total_last_month,
            sum(unique_hits_last_month) as unique_total_last_month
        FROM
            $this->tableStatsName
    ",
    // get stats per area
    8 => "
        # query: 8
        SELECT
            *
        FROM
            $this->tableStatsName
        ORDER BY
            area
    ",
    // increase unique counter for total and current month
    9 => "
        # query: 9
        UPDATE
            $this->tableStatsName
        SET
            unique_hits_this_month=unique_hits_this_month+1,
            unique_hits_total=unique_hits_total+1
        WHERE
            area='".addslashes($this->area)."'
    "
    
);


?>