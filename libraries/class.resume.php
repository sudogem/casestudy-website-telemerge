<?php
/**
 * @author		Arman Ortega <arman.ortega@yahoo.com> 
 * @copyright	Telemerge Corporation	
 * @created		Jan 27 2006
 */

class applicant_resume extends database
{
	var $table_resume = "applicant_resume";
	
	function applicant_resume()
	{
		
	}
	
	function addResume( $postdata = array() )
	{
		$fields = array(
			'name' =>  'string' ,
			'email' => 'string' ,
			'position_desired' => 'string' , 
			'coverletter' => 'string' ,
			'resume' => 'string' ,
			'datesubmitted' =>  'integer'
		);
		$myts =& textsanitizer::getInstance( );		
		
		$fieldlist = implode( ", " , array_keys( $fields ) );
		while( list( $fieldname , $fieldtype ) = each( $fields ) ) {
			if ( !strcmp( $fieldtype , "string" ) ) 
			{
				$valuelist[] = $this->quote($myts->htmlspecialchars( $postdata[$fieldname] )); 
			}
			else 
			{
				$valuelist[] = (int) $postdata[$fieldname];
			}
		}	

		$insertvalues = implode( ", " , $valuelist );	
		$sql = " insert into $this->table_resume ( $fieldlist ) " ;			
		$sql .= " values( $insertvalues ) ";
		//  echo "s=$sql";
		$result = $this->query( $sql ) ;
		return $result ;
	}
	
	function removeResume( $id )
	{
		$sql = " delete from $this->table_resume ";
		$sql .= " where resumeID = " . intval( $id ); 
  		//echo "s=$sql";		
		$result = $this->query( $sql );
		if ( !$result ) return false;
		return true;		
	}
	
	function getAllSubmittedResume( $start = 0 , $limit = 0 )
	{
		$sql = " select * from $this->table_resume ";	
		if ( $offset != 0 || $limit != 0 ) $sql .= " limit $start , $limit ";
		$result = $this->buffered_query( $sql );
		return $result ;
	}
	
	function getApplicantResumeById( $id )
	{
		$sql = " select * from $this->table_resume ";
		$sql .= " where resumeID = " . intval( $id );
		$result = $this->buffered_query( $sql );
		return $result ;
	}
}
?>