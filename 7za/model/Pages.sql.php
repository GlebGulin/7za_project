<?PHP

$query = array
(
    // get pages by parent_id, language
    0 => "
		# query: 0
        SELECT
            *
        FROM
            #__pages
        WHERE 
        	page_parent_id 							= '$this->page_parent_id'
        ORDER BY
        	position
    ",
    
    // get page by page_id
    1 => "
		# query: 1
        SELECT
            *
        FROM
            #__pages
        WHERE 
        	page_id 								= '$this->page_id'
    ",   
     
    // update page 
    2 => "
		# query: 2
        UPDATE
            #__pages
        SET 
        	title									= '$this->title',
			content									= '$this->content',
			link									= '$this->link'			        	
        WHERE 
        	page_id 								= '$this->page_id'
    ",     
    
    // add page 
    3 => "
		# query: 3
        INSERT INTO
            #__pages
        SET 
        	title									= '$this->title',
			content									= '$this->content',
			link									= '$this->link',			        	
        	page_parent_id 							= '$this->page_parent_id',
        	position								= '$this->position'
    ", 

    // get max position for page 
    4 => "
		# query: 4
        SELECT 
        	MAX(position)
        FROM
            #__pages
        WHERE 
        	page_parent_id 							= '$this->page_parent_id'
    ",   

    // update visibility for page
    5 => "
		# query: 5
		UPDATE
            #__pages
        SET 
        	visible									= '$this->visible'
        WHERE 
        	page_id	 								= '$this->page_id'
    ",        
    
    // get page with less position
    6 => "
        # query: 6
        SELECT
            *
        FROM
            #__pages
        WHERE
            position           						<  $this->position
        AND 
        	page_parent_id	             			=  $this->page_parent_id	
        ORDER BY
            position DESC
    ",   
    
    // get page with more position
    7 => "
         # query: 7
        SELECT
            *
        FROM
            #__pages
        WHERE
            position           						>  $this->position
        AND 
        	page_parent_id             				=  $this->page_parent_id            
        ORDER BY
            position ASC
    ",
         

    // update position of the page
    8 => "
        # query: 8
        UPDATE
            #__pages
        SET
            position           						=  $this->position
        WHERE
            page_id        							=  $this->page_id  
    ",     
    
    // get pages by parent_id
    9 => "
		# query: 9
        SELECT
            *
        FROM
            #__pages
        WHERE 
        	page_parent_id 							= '$this->page_parent_id'
        ORDER BY
        	position
    ",    
    
    // delete page
    10 => "
		# query: 10
        DELETE FROM
            #__pages
        WHERE 
        	page_id 								= '$this->page_id'
    ",  
        
);


?>