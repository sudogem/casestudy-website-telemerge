<?php
/**
 * @author		Arman Ortega <arman.ortega@yahoo.com> 
 * @copyright	Telemerge Corporation
 * @created		jan 10 2006
 */

class transcribedDocs extends database {
	var $tablename = 'transcribedocs';
	
	function transcribedDocs () {
		// nothing here ...
	}
	
	function saveData ( $postdata = array() ) {
		$fields = array(
			'uploadID' => 'integer' , 
			'docfilename' => 'string'
		);	
		
		$fieldlist = implode( ' , ' , array_keys( $fields ) );
	
		while( list( $fieldname , $fieldtype ) = each( $fields ) ) {
			if ( !strcmp( $fieldtype , "string" ) ) 
			{
				$valuelist[] = $this->quote(addslashes( $postdata[$fieldname] )); 
			}
			else {
				$valuelist[] = ( int ) $postdata[$fieldname] ;
			}
		}
		
		$insertvalues = implode( " , " , $valuelist );

		$sql = " insert into $this->tablename ( $fieldlist ) " ;
		$sql .= " values ( $insertvalues ) " ;
		// echo "s=$sql";
		$result = $this->query( $sql );
		if ( !$result ) return false;
		return true;
	}	
	
	function updateData( $postdata , $whereparams ) {
		$fields = array(
			'uploadID' => 'integer' , 
			'docfilename' => 'string'
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
	
	function getTranscribedDocumentOfVoiceFile( $voicefileID ) {
	
		$sql = " select * from $this->tablename ";
		$sql .= " where uploadID = " . intval( $voicefileID );
		//echo "s=$sql";
		$result = $this->query( $sql );
		$data = array();
		while ( $data[] = $this->fetchobject() );
		$this->freeresult();
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
	
}

?>