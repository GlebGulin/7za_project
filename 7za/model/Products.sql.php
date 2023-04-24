<?PHP

$query = array
(
    // get product categories
    0 => "
		# query: 0
        SELECT
            *
        FROM
            #__product_categories
        ORDER BY
            position
    ",

    // add new category
    1 => "
        # query: 1
        INSERT INTO
            #__product_categories
        SET
            category_name           = '$this->category_name',
            position                = '$this->position'
    ",

    // get max position of a category
    2 => "
        # query: 2
        SELECT
            MAX(position)
        FROM
            #__product_categories
    ",

    // get category by id
    3 => "
        # query: 3
        SELECT
            *
        FROM
            #__product_categories
        WHERE
            category_id             = '$this->category_id'
    ",

    // get subcategories
    4 => "
        # query: 4
        SELECT
            *
        FROM
            #__product_subcategories
        WHERE
            category_id             = '$this->category_id'
            $this->condition
        ORDER BY
            position
    ",

    // add new subcategory
    5 => "
        # query: 5
        INSERT INTO
            #__product_subcategories
        SET
            subcategory_name        = '$this->subcategory_name',
            category_id             = '$this->category_id',
            position                = '$this->position',
            group_id                = '$this->group_id',
            image_file_id           = '$this->image_file_id',
            marked                  = '$this->marked',
            hidden                  = '$this->hidden'
    ",

    // get max position of a subcategory
    6 => "
        # query: 6
        SELECT
            MAX(position)
        FROM
            #__product_subcategories
        WHERE
            category_id             = '$this->category_id'
    ",

    // get subcategory by id
    7 => "
        # query: 7
        SELECT
            *
        FROM
            #__product_subcategories
        WHERE
            subcategory_id             = '$this->subcategory_id'
    ",

    // get products by subcategory_id
    8 => "
        # query: 8
        SELECT
            p.*,
            IF(p.linked_to_product,p2.product_name,p.product_name) as product_name,
            IF(p.linked_to_product,p2.description,p.description) as description,
            IF(p.linked_to_product,p2.image_file_id,p.image_file_id) as image_file_id,
            IF(p.linked_to_product,p2.price,p.price) as price
        FROM
            #__product p LEFT JOIN #__product p2 ON p.linked_to_product=p2.product_id
        WHERE
            p.subcategory_id           = '$this->subcategory_id'
        ORDER BY
            p.position ASC
    ",

    // get product by product_id
    9 => "
        # query: 9
        SELECT
            p.*, IFNULL(p2.product_name,p.product_name) as product_name
        FROM
            #__product p LEFT JOIN #__product p2 ON p.linked_to_product=p2.product_id
        WHERE
            p.product_id           = '$this->product_id'
    ",

    // save a product
    /* added_time          = '".date("Y-m-d H:i:s")."', */
    10 => "
        # query: 10
        UPDATE
            #__product
        SET
            product_name        = '$this->product_name',
            description         = '$this->description',
            image_file_id       = '$this->image_file_id',
            add_photos          = '$this->add_photos',
            price               = '$this->price',
            conn_goods			= '$this->conn_goods',
            view				= '$this->view',
            discount			= '$this->discount',
            discount_start		= '$this->discount_start',
			discount_finish		= '$this->discount_finish',
            shown               = '$this->shown',
            linked_to_product   = '$this->linked_to_product',
            absent              = '$this->absent',
            special_offer       = '$this->special_offer',
            recommended         = '$this->recommended'
        WHERE
            product_id          = '$this->product_id'
    ",

    // hide product item
    11 => "
        # query: 11
        UPDATE
            #__product
        SET
            shown               = '$this->shown'
        WHERE
            product_id          = '$this->product_id'
        OR
            linked_to_product   = '$this->product_id'
    ",

    // delete product item
    12 => "
        # query: 12
        DELETE FROM
            #__product
        WHERE
            product_id          = '$this->product_id'
        OR
            linked_to_product   = '$this->product_id'
    ",

    // save new product item
    13 => "
        # query: 13
        INSERT INTO
            #__product
        SET
            subcategory_id      = '$this->subcategory_id',
            product_name        = '$this->product_name',
            description         = '$this->description',
            image_file_id       = '$this->image_file_id',
            add_photos          = '$this->add_photos',
            added_time          = '".date("Y-m-d H:i:s")."',
            price               = '$this->price',
            conn_goods			= '$this->conn_goods',
            shown               = '$this->shown',
            view				= '$this->view',
            discount			= '$this->discount',
            discount_start		= '$this->discount_start',
			discount_finish		= '$this->discount_finish',
            position            = '$this->position',
            linked_to_product   = '$this->linked_to_product',
            absent              = '$this->absent',
            special_offer       = '$this->special_offer',
            recommended         = '$this->recommended'
    ",

    // get max product position
    14 => "
        # query: 14
        SELECT
            MAX(position)
        FROM
            #__product
        WHERE
            subcategory_id     = '$this->subcategory_id'
    ",

    // get product with less position
    15 => "
        # query: 15
        SELECT
            *
        FROM
            #__product
        WHERE
            position           < $this->position
        AND
            subcategory_id     = $this->subcategory_id
        ORDER BY
            position DESC
    ",

    // get product with more position
    16 => "
         # query: 16
        SELECT
            *
        FROM
            #__product
        WHERE
            position           > $this->position
        AND
            subcategory_id     = $this->subcategory_id
        ORDER BY
            position ASC
    ",

    // update position of the product
    17 => "
        # query: 17
        UPDATE
            #__product
        SET
            position           = '$this->position'
        WHERE
            product_id         = '$this->product_id'
    ",

    // get category with less position
    18 => "
        # query: 18
        SELECT
            *
        FROM
            #__product_categories
        WHERE
            position           < $this->position
        ORDER BY
            position DESC
    ",

    // get category with more position
    19 => "
         # query: 19
        SELECT
            *
        FROM
            #__product_categories
        WHERE
            position           > $this->position
        ORDER BY
            position ASC
    ",

    // update position of the category
    20 => "
        # query: 20
        UPDATE
            #__product_categories
        SET
            position           = $this->position
        WHERE
            category_id        = $this->category_id
    ",

    // get subcategory with less position
    21 => "
        # query: 21
        SELECT
            *
        FROM
            #__product_subcategories
        WHERE
            position           < $this->position
        AND
            category_id        = $this->category_id
        ORDER BY
            position DESC
    ",

    // get subcategories with more position
    22 => "
         # query: 22
        SELECT
            *
        FROM
            #__product_subcategories
        WHERE
            position           > $this->position
        AND
            category_id        = $this->category_id
        ORDER BY
            position ASC
    ",

    // update position of the subcategories
    23 => "
        # query: 23
        UPDATE
            #__product_subcategories
        SET
            position           = $this->position
        WHERE
            subcategory_id     = $this->subcategory_id
    ",

    // delete subcategory
    24 => "
        # query: 24
        DELETE FROM
            #__product_subcategories
        WHERE
            subcategory_id     = $this->subcategory_id
    ",

    // delete category
    25 => "
        # query: 25
        DELETE FROM
            #__product_categories
        WHERE
            category_id        = $this->category_id
    ",

    // save category
    26 => "
        # query: 26
        UPDATE
            #__product_categories
        SET
            category_name           = '$this->category_name'
        WHERE
            category_id             = '$this->category_id'

    ",

    // save subcategory
    27 => "
        # query: 27
        UPDATE
            #__product_subcategories
        SET
            subcategory_name        = '$this->subcategory_name',
            image_file_id           = '$this->image_file_id',
            group_id                = '$this->group_id',
            marked                  = '$this->marked',
            hidden                  = '$this->hidden'
        WHERE
            subcategory_id          = '$this->subcategory_id'

    ",
    // get products for page
    28 => "
        # query: 28
        SELECT
            p.*,
            IF(p.linked_to_product,p2.product_id,p.product_id) AS product_id,
            IF(p.linked_to_product,p2.product_name,p.product_name) AS product_name,
            IF(p.linked_to_product,p2.description,p.description) AS description,
            IF(p.linked_to_product,p2.image_file_id,p.image_file_id) AS image_file_id,
            IF(p.linked_to_product,p2.price,p.price) AS price,
            IF(p.linked_to_product,p2.discount,p.discount) AS discount,
            IF(p.linked_to_product,p2.discount_start,p.discount_start) AS discount_start,
            IF(p.linked_to_product,p2.discount_finish,p.discount_finish) AS discount_finish,
            IFNULL(p2.absent,p.absent) as absent
        FROM
            #__product p LEFT JOIN #__product p2 ON p.linked_to_product=p2.product_id
        WHERE
            p.subcategory_id           = '$this->subcategory_id'
        AND
            p.shown                    = 1
        AND
            p.special_offer            = 0
        $this->condition
        ORDER BY
            $this->field  $this->direction
        $this->smLimitClause
    ",

    // increase count for a product
    29 => "
        # query: 29
        UPDATE
            #__product
        SET
        	view						=  view + 1
        WHERE
             product_id             	= '$this->product_id'

    ",

    // get top products
    30 => "
        # query: 30
        SELECT
            *
        FROM
            #__product
        WHERE
            shown                       = '1'
        AND
            linked_to_product           = 0
        ORDER BY
        	`view` DESC
        LIMIT
        	$this->leaders_count
    ",

    // get products for sales
    31 => "
        # query: 31
        SELECT
            *
        FROM
            #__product
        WHERE
            shown 		                 = '1'
        AND
        	discount_start				<= '".date("Y-m-d")."'
        AND
        	discount_finish				>= '".date("Y-m-d")."'
        ORDER BY
        	position
    ",

    // get products for page
    32 => "
		# query: 32
        SELECT
        	*
        FROM
        	#__product
        WHERE
        	shown		> 0
        $this->condition
        $this->smLimitClause
    ",

    // get new products for page
    33 => "
		# query: 33
        SELECT
        	p.*,
        	IFNULL(p2.product_id,p.product_id) as product_id,
        	IFNULL(p2.product_name,p.product_name) as product_name,
        	IFNULL(p2.description,p.description) as description,
        	IFNULL(p2.image_file_id,p.image_file_id) as image_file_id,
        	IFNULL(p2.price,p.price) as price
        FROM
        	#__product p LEFT JOIN #__product p2 ON p.linked_to_product=p2.product_id
        WHERE
            p.shown     > 0
        AND
            p.linked_to_product     = 0
        AND
            p.special_offer         = 0
        ORDER BY
        	p.added_time DESC
        LIMIT $this->new_items_qnt
    ",

    // get top viewed products
    34 => "
        # query: 34
        SELECT
            *
        FROM
            #__product
        ORDER BY
            `view` DESC
        LIMIT
            $this->leaders_count
    ",

    // reset all counters to 0
    35 => "
        # query: 35
        UPDATE
            #__product
        SET
            `view`      = 0
    ",

    // set view counter
    36 => "
        # query: 36
        UPDATE
            #__product
        SET
            `view`      = 1
        WHERE
            product_id  = '$this->product_id'
    ",

    // get all products
    37 => "
        # query: 37
        SELECT
            p.*,
            s.subcategory_name, c.category_name, c.category_id
        FROM
            #__product p
            LEFT JOIN #__product_subcategories s ON p.subcategory_id=s.subcategory_id
            LEFT JOIN #__product_categories c ON s.category_id=c.category_id
        WHERE
            p.linked_to_product     = 0
        ORDER BY
            s.category_id, p.subcategory_id, p.position
    ",

    // get all visible products
    38 => "
        # query: 38
        SELECT
            *
        FROM
            #__product
        WHERE
            shown       = '1'
        ORDER BY
            subcategory_id
    ",

    // get all visible products of subcategory
    39 => "
        # query: 39
        SELECT
            p.*, IFNULL(p2.product_id,p.product_id) as product_id,
            p.product_id as new_product_id,
            IFNULL(p2.product_name,p.product_name) as product_name,
            IFNULL(p2.description,p.description) as description,
            IFNULL(p2.image_file_id,p.image_file_id) as image_file_id,
            IFNULL(p2.price,p.price) as price
        FROM
            #__product p LEFT JOIN #__product p2 ON p.linked_to_product=p2.product_id
        WHERE
            p.subcategory_id    = '$this->subcategory_id'
        AND
            p.shown             = 1
        AND
            IFNULL(p2.price,p.price) > 0
        ORDER BY
            p.position
    ",

    // get products with condition
    40 => "
        # query: 40
        SELECT
            *
        FROM
            #__product
        WHERE
            0
            $this->condition
        ORDER BY
            view DESC
    ",

    // set absent flag for a product
    41 => "
        # query: 41
        UPDATE
            #__product
        SET
            absent              = '$this->absent'
        WHERE
            product_id          = '$this->product_id'
        OR
            linked_to_product   = '$this->product_id'
    ",

    // update hidden flag of a subcategory
    42 => "
        # query: 42
        UPDATE
            #__product_subcategories
        SET
            hidden              = '$this->hidden'
        WHERE
            subcategory_id      = '$this->subcategory_id'
    ",

    // search products for admin
    43 => "
		# query: 43
        SELECT
        	*
        FROM
        	#__product
        WHERE
            linked_to_product   = 0
        $this->condition
        ORDER BY
            product_id
    ",

    // get most popular products of a category
    44 => "
        # query: 44
        SELECT DISTINCT
            p.*,
            IF(p.linked_to_product,p2.product_id,p.product_id) AS product_id,
            IF(p.linked_to_product,p2.product_name,p.product_name) AS product_name,
            IF(p.linked_to_product,p2.description,p.description) AS description,
            IF(p.linked_to_product,p2.image_file_id,p.image_file_id) AS image_file_id,
            IF(p.linked_to_product,p2.price,p.price) AS price,
            IF(p.linked_to_product,p2.discount,p.discount) AS discount,
            IF(p.linked_to_product,p2.discount_start,p.discount_start) AS discount_start,
            IF(p.linked_to_product,p2.discount_finish,p.discount_finish) AS discount_finish,
            IFNULL(p2.absent,p.absent) as absent
        FROM
            #__product p LEFT JOIN #__product p2 ON p.linked_to_product=p2.product_id
            LEFT JOIN #__product_subcategories sc ON p.subcategory_id = sc.subcategory_id
        WHERE
            sc.category_id          = '$this->category_id'
        AND
            p.shown                    = 1
        AND
            p.special_offer            = 0
        $this->condition
        ORDER BY
            $this->field  $this->direction
        $this->smLimitClause
    ",
/*
    44 => "
        # query: 44
        SELECT
            p.*
        FROM
            #__product p LEFT JOIN #__product_subcategories sc ON p.subcategory_id = sc.subcategory_id
        WHERE
            sc.category_id          = '$this->category_id'
        AND
            p.shown
        AND
            p.linked_to_product     = 0
        ORDER BY
            $this->field $this->direction
        $this->smLimitClause
    ",
*/
    // get special offers
    45 => "
        # query: 45
        SELECT
            *
        FROM
            #__product
        WHERE
            special_offer           = 1
        AND
            shown
    ",

    // scripts for parameters
    46 => "
        # query: 46
        SELECT
            *
        FROM
            #__parameters_groups
    ",

    47 => "
        # query: 47
        SELECT
            *
        FROM
            #__parameters_groups
        WHERE
        	group_id								= '$this->group_id'
    ",

    48 => "
        # query: 48
        UPDATE
            #__parameters_groups
        SET
        	group_name								= '$this->group_name'
        WHERE
        	group_id								= '$this->group_id'
    ",

    49 => "
        # query: 49
        INSERT INTO
            #__parameters_groups
        SET
        	group_name								= '$this->group_name'
    ",

    50 => "
        # query: 50
        DELETE FROM
            #__parameters_groups
        WHERE
        	group_id								= '$this->group_id'
    ",

    51 => "
        # query: 51
        SELECT
            *
        FROM
            #__parameters
        WHERE
        	group_id								= '$this->group_id'
        ORDER BY
        	position
    ",

    52 => "
        # query: 52
        SELECT
            *
        FROM
            #__parameters
        WHERE
        	parameter_id								= '$this->parameter_id'
    ",

    53 => "
        # query: 53
		UPDATE
            #__parameters
        SET
        	parameter_name								= '$this->parameter_name',
        	unit										= '$this->unit',
        	is_header                                   = '$this->is_header',
        	use_in_search								= '$this->use_in_search'
        WHERE
        	parameter_id								= '$this->parameter_id'
    ",

    54 => "
        # query: 54
		INSERT INTO
            #__parameters
        SET
        	parameter_name								= '$this->parameter_name',
        	unit										= '$this->unit',
        	use_in_search								= '$this->use_in_search',
        	is_header                                   = '$this->is_header',
        	group_id									= '$this->group_id',
        	position									= '$this->position'

    ",

    55 => "
        # query: 55
		DELETE FROM
            #__parameters
        WHERE
        	parameter_id								= '$this->parameter_id'
    ",

    // get parameter with less position
    56 => "
        # query: 56
        SELECT
            *
        FROM
            #__parameters
        WHERE
            position           							<  $this->position
        AND
        	group_id									= '$this->group_id'
        ORDER BY
            position DESC
    ",

    // get parameter with more position
    57 => "
         # query: 57
        SELECT
            *
        FROM
            #__parameters
        WHERE
            position           							>  $this->position
        AND
        	group_id									= '$this->group_id'
        ORDER BY
            position ASC
    ",


    // update position of the parameter
    58 => "
        # query: 58
        UPDATE
            #__parameters
        SET
            position           							=  $this->position
        WHERE
            parameter_id        						=  $this->parameter_id
    ",

    59 => "
        # query: 59
        SELECT
            MAX( position )
        FROM
            #__parameters
        WHERE
        	group_id									= '$this->group_id'
    ",

    60 => "
        # query: 60
		DELETE FROM
            #__parameters
        WHERE
        	group_id									= '$this->group_id'
    ",

    61 => "
        # query: 61
		DELETE FROM
            #__parameters_values
        WHERE
        	product_id									= '$this->product_id'
    ",

    62 => "
        # query: 62
		INSERT INTO
            #__parameters_values
        SET
        	product_id									= '$this->product_id',
        	parameter_id								= '$this->parameter_id',
        	value										= '$this->value'
    ",

    63 => "
        # query: 63
		SELECT
			value
		FROM
			#__parameters_values
        WHERE
        	product_id									= '$this->product_id'
        AND
        	parameter_id								= '$this->parameter_id'
    ",

    // get recommended products
    64 => "
        # query: 64
        SELECT
            *
        FROM
            #__product
        WHERE
            recommended           = 1
        AND
            shown 
        $this->limit
    ",

    // update add_photos field for a product
    65 => "
        # query: 65
        UPDATE
            #__product
        SET
            add_photos                                  = '$this->add_photos'
        WHERE
            product_id                                  = '$this->product_id'
    ",

);


?>