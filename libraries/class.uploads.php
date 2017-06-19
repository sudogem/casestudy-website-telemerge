<?php
/**
 * @author		Arman Ortega <brainwired@gmail.com> 
 * @copyright	copyright 2006 primary offshore solutions
 * @date		oct 30 2006
 */

// note: free the result from query ,, then unset the variables ....
class uploads extends database {
	var $tablename = 'uploads';
	
	function uploads() {
		// nothing here ....
	}
	
	function getAllUserUploads( $offset = 0 , $limit = 0 , $uid = 0 ) {
		$sql = " select * from $this->tablename where 1=1 ";
		if ( $uid != 0 ) $sql .= " and userID = '$uid' ";
		$sql .= " order by uploaddate desc  ";		
		if ( $offset != 0 || $limit != 0 ) $sql .= " limit $offset , $limit ";
		$data = array();
		//echo "s=$sql";
		$this->query( $sql );
		while( $data[] = $this->fetchobject() );
		return $data;
	}
	
	function getUploadDetails( $id , $uid = 0 , $selectdata = array() ) {
		if ( count( $selectdata ) > 0 )
		{
			$fields = implode( ', ' , $selectdata );
		}
		else
		{
			$fields = '*';
		}
		$sql = " select $fields from $this->tablename where 1=1 ";
		$sql .= " and uploadID = " . intval( $id );
		if ( $uid != 0 ) $sql .= " and userID = " . intval( $uid ) ;
		// echo "s=$sql";
		$data = array();		
		$this->query( $sql );
		while( $data[] = $this->fetchobject() );
		return $data;
	}
	
	function saveData(  $postdata = array() ) {
		$fields = array(
			"userID" => "integer" ,
			"uploaddesc" => "string" ,
			"uploadfilename" => "string" ,
			"uploaddate" => "integer" ,
			"priority" => "integer" 
		);
		
		$fieldlist = implode( ' , ' , array_keys( $fields ) );
		
		$myts =& textSanitizer::getInstance();
		
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
		
		$sql = " insert into $this->tablename ( $fieldlist ) ";
		$sql .= " values ( $insertvalues ) ";
		//echo "s=$sql";
		$result = $this->query( $sql );
		if ( !$result ) return false;
		return true;
	}
	
	function updateData( $postdata , $whereparams ) {
		$fields = array(
			"uploadID" => "integer" ,
			"userID" => "integer" ,
			"uploaddesc" => "string" ,
			"uploadfilename" => "string" ,
			"uploaddate" => "integer" ,
			"priority" => "integer" 
			
		);	

		$myts =& textSanitizer::getInstance();
		
		$fieldlist = implode( ', ' , array_keys ( $postdata ) );
		foreach( $postdata as $key => $value ) {
			if ( in_array( $key , array_keys( $fields ) ) ) {
				$fieldtype = $fields[$key]; 
				if ( !strcmp( $fieldtype , "string" )  ) {
					$postdata[$key] =& $this->quote( $myts->htmlspecialchars ( $postdata[$key] ) ) ;
				}
				if ( !strcmp( $fieldtype , "integer" ) ) {
					$postdata[$key] = ( int ) $postdata[$key] ; // cast the data into integer-type					
				} 
				$updatelist[] = $key . '=' . $postdata[$key];
			}
		}
		$updatevalues = implode( " , " , $updatelist );	
		$sql = " update $this->tablename " ;
		$sql .= " set $updatevalues " ;
		$sql .= " where $whereparams " ;
		// echo "s=$sql";
		$result = $this->query( $sql );
		if ( !$result ) return false;
		return true;
	}
	
	function removeUploadedVoiceFile( $id ) 
	{
		$sql = " delete from $this->tablename ";
		$sql .= " where uploadID = " . intval( $id ); 
		$result = $this->query( $sql );
		if ( !$result ) return false;
		return true;		
	}
	
	function removeVoiceFileOnServer( $id )
	{
		$sql = " select uploadfilename , uploadID from $this->tablename ";
		$sql .= " where uploadID = " . intval( $id );
		$data = array();		
		$result = $this->query( $sql );
		$data[] = $this->fetchobject() ;
		$thisfile = $data[0]->uploadfilename ;
		$thisfile = '../uploads/' . $thisfile ;
		if ( file_exists( $thisfile ) )
		{
			$result = @unlink( $thisfile );
		} 
		return $result ;
	}
}
?>