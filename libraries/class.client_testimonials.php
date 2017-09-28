<?php
/**
 * @author		Arman Ortega <arman.ortega@yahoo.com> 
 * @copyright	Telemerge Corporation
 * @created		Jan 07 2006
 */

class clientTestimonials extends database 
{
	var $table_testimonial = 'client_testimonial' ;
	
	function clientTestimonials()
	{
		// nothing here
	}
	
	function addTestimonial( $postdata = array() )
	{
		$fields = array(
			'message' =>  'string' ,
			'datecreated' => 'string' ,
			'status' => 'integer' , 
			'userID' => 'integer' ,
		);
		$myts =& textsanitizer::getInstance( );		
		
		$fieldlist = implode( " ," , array_keys( $fields ) );
		while( list( $fieldname , $fieldtype ) = each( $fields ) ) {
			if ( !strcmp( $fieldtype , "string" ) ) 
			{
				$valuelist[] = $this->quote($myts->htmlspecialchars( $postdata[$fieldname] )); 
			}
			else {
				$valuelist[] = $postdata[$fieldname];
			}
		}	

		$insertvalues = implode( " , " , $valuelist );	
		$sql = " insert into $this->table_testimonial ( $fieldlist ) " ;			
		$sql .= " values( $insertvalues ) ";
		//  echo "s=$sql";
		$result = $this->query( $sql );
		return $result ;
		
	}
	
	function editTestimonial( $postdata = array() , $id )
	{
		$fields = array (
			'testimonialID' => 'integer' , 
			'message' =>  'string' ,
			'datecreated' => 'string' ,
			'status' => 'integer' , 
			'userID' => 'integer' ,
		);
		
		$sanitizer =& textsanitizer::getInstance( );
		
		$fieldlist = implode( " ," , array_keys( $fields ) );
		foreach( $postdata as $key => $value ) {
			if ( in_array( $key , array_keys( $fields ) ) ) {
				$fieldtype = $fields[$key]; 
				if ( !strcmp( $fieldtype , "string" )  ) 
				{
					$value = $this->quote( $sanitizer->htmlspecialchars( $postdata[$key] ) );
					$updatelist[] = $key . '=' . $value ;				
				}
				
				if ( !strcmp( $fieldtype , "integer" )  ) 
				{
					$value = ( int ) $postdata[$key];	
					$updatelist[] = $key . '=' . $value ; 			
				}
			}
		}
		$updatevalues = implode( " , " , $updatelist );		
		$sql = " update $this->table_testimonial "; 
		$sql .= " set $updatevalues ";
		$sql .= " where testimonialID = " . intval( $id );
		// echo $sql ;
		$result = $this->query( $sql );
		return $result ; 
	}
	
	function approveTestimonial()
	{
	
	}
	
	function readTestimonial( $id )
	{
		$sql = " update $this->table_testimonial ";
		$sql .= " set isread = 'Read' ";
		$sql .= " where testimonialID = " . intval( $id );
		$result = $this->query( $sql );
		if ( !$result ) return false;
		return true;		
	}
	
	function removeTestimonial( $id )
	{
		$sql = " delete from $this->table_testimonial ";
		$sql .= " where testimonialID = " . intval( $id ); 
		$result = $this->query( $sql );
		if ( !$result ) return false;
		return true;		
	}
	
	function getAllClientTestimonials()
	{
		$sql = " select * from $this->table_testimonial " ;
		//$sql .= " where status = 2 ";		
		$sql .= " order by datecreated desc " ;

		$testidata = array( );
		$testidata = $this->buffered_query( $sql );		
		return $testidata ; 		
	}
	
	function getPublishedClientTestimonials($conn, $num = 0 )
	{
		$sql = " select * from $this->table_testimonial " ;
		$sql .= " where status = 2 ";		
		$sql .= " order by datecreated desc " ;
		if ( $num != 0 ) $sql .= " limit $num ";		

		$testidata = array( );
		$testidata = $this->buffered_query($conn, $sql );		
		return $testidata ; 		
	}
	function getTestimonialsByLimit( $limit , $offset )
	{
		$sql = " select * from $this->table_testimonial ";
		$sql .= " order by datecreated desc limit $limit , $offset ";
		//echo $sql ;
		// $result = $this->query( $sql );
		$testidata = array( );
		$testidata = $this->buffered_query( $sql );		
		// while( $row = $this->fetchobject() ) $testidata[] = $row ;
		return $testidata ; 
	}
	
	function getTestimonialsById( $id )
	{
		$sql = " select * from $this->table_testimonial " ;
		$sql .= " where testimonialID = " . intval( $id ) ;
		$testidata = array( );
		$testidata = $this->buffered_query( $sql );		
		return $testidata ; 			
	}
	
	function recentTestimonialSubmitted()
	{
		$sql = " select * from $this->table_testimonial " ;
		$sql .= " where isread = 'Unread' ";
		$testidata = array( );
		$testidata = $this->buffered_query( $sql );		
		return $testidata ; 			
	}
	
}
?>