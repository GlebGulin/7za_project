<?PHP

$query = array
(
    // get cities
    0 => "
		# query: 0
        SELECT
            *
        FROM
            #__cities
        ORDER BY
            position
    ",

    //
    1 => "
		# query: 1
        INSERT INTO
            #__orders
        SET
            surname             = '$this->surname',
            firstname           = '$this->firstname',
            lastname            = '$this->lastname',
            email               = '$this->email',
			password            = '$this->password',
            phone               = '$this->phone',
            fax                 = '$this->fax',
            ind               	= '$this->ind',
            region              = '$this->region',
            district            = '$this->district',
            city                = '$this->city',
            street              = '$this->street',
            number              = '$this->number',
            building            = '$this->building',
            office              = '$this->office',
            entrance            = '$this->entrance',
            code                = '$this->code',
            floor               = '$this->floor',
            added_time			= '$this->added_time',
            comment             = '$this->comment',
            company             = '$this->company',
            legal_address       = '$this->legal_address',
            postal_address      = '$this->postal_address',
            inn             	= '$this->inn',
            kpp             	= '$this->kpp',
            okpo             	= '$this->okpo',
            bank_name           = '$this->bank_name',
			settl_account       = '$this->settl_account',
			corr_account        = '$this->corr_account',
			bik             	= '$this->bik',
            ssnumber            = '$this->ssnumber'
    ",

    //
    2 => "
		# query: 2
        INSERT INTO
            #__order_products
        SET
            order_id             = '$this->order_id',
            product_id           = '$this->product_id',
            product_price        = '$this->product_price',
            product_qnt        	 = '$this->product_qnt'
    ",

    //
    3 => "
		# query: 3
        SELECT
        	*
        FROM
            #__order_products
        WHERE
            order_id             = '$this->order_id'
    ",

    //
    4 => "
		# query: 4
        SELECT
        	o.*, o.city as city_name, s.status_name
        FROM
            #__orders o LEFT JOIN #__order_status s ON o.status_id = s.status_id
        WHERE
            order_id             = '$this->order_id'
    ",

    5 => "
		# query: 5
        SELECT
        	*
        FROM
            #__orders o LEFT JOIN #__order_status s ON o.status_id = s.status_id
        WHERE
            o.status_id           != 4
        AND
        	o.status_id           != 3
        ORDER BY
        	o.added_time DESC
    ",

    6 => "
		# query: 6
        UPDATE
            #__orders
        SET
        	status_id			 = '$this->status_id'
        WHERE
            order_id             = '$this->order_id'
    ",

    7 => "
    	# query: 7
        SELECT
        	*
        FROM
            #__orders o LEFT JOIN #__order_status s ON o.status_id = s.status_id
        WHERE
            o.status_id           != 1
        AND
        	o.status_id           != 2
        $this->smLimitClause
    	",

    8 => "
		# query: 8
        UPDATE
            #__orders
        SET
        	status_id			 = status_id + 1
        WHERE
            order_id             = '$this->order_id'
    ",

    9 => "
    	# query: 9
        SELECT
        	*
        FROM
            #__orders
        WHERE
            email				= '$this->email'
        AND
        	password			= '$this->password'
        ORDER BY
        	added_time DESC

    	",

);


?>