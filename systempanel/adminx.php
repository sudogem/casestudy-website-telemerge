<?php
require_once ( '../web/class.sessions.php' );
$session = new sessions();

if ( $session->isAttributeExist( 'account_sess' ) === false )
{
	//header( 'Location: log.php' );
	//exit ;
}
?>
<?php 
include_once( '../tiles/header.php' );
?>
<div id="container" >
<?php include_once( '../tiles/sys-menu.php' ); ?>	
	<div id="contentpane" >
		<?php 
		
		require_once( '../libraries/class.database.php' );
		require_once( '../libraries/class.articles.php' );
		require_once( '../libraries/class.status.php' );		
		require_once( '../libraries/class.useraccount.php' );
		require_once( '../libraries/class.pager.php' );
		
		global $session ;
		
		$article = new Articles ; 
		
		// load articles written by author
		$data = $session->getAttribute( 'account_sess' );
		$result = $article->getAllArticlesWrittenByAuthor( $data['uid'] );
		// echo '<pre>';
		// print_r( $result );
		$n = count( $result )  ;
		// echo "n=$n";
		if ( isset( $_GET['page'] ) )
		{
			$page = $_GET['page'] ;
		}
		else
		{
			$page = 1 ;
		}
		$p = new Pager ;
		$limit = 10 ;
		$scroll = 1 ;
		$scrollnumber = 2 ;
				
		$paging = ceil( $n / $limit ) ;  
		$start = $page * $limit - ( $limit ) ;
		//echo "s=$start";
		#$data = $article->getArticlesByLimit( $limit ,  $offset );		
		
		#print_r( $data );
		$links = $p->getPagerData( $page , $n , $limit  , $paging , $scroll , $scrollnumber ) ;
		if ( $session->isAttributeExist( 'action_message' )  ) {
		?>
		<div class="confirm-message" >
		<h1><?php echo $session->getAttribute( 'action_message' ); ?></h1>		
		</div>
		<?php
			$session->removeAttribute( 'action_message' ) ;			
		 }
		  ?>
		<form name="adminForm" method="post" onsubmit="return submitForm();" >	
		<table width="100%" border="0" cellspacing="0"  id="datalist" >
		<div id="toolbar" >
		<input type="submit" onClick="javascript: if (document.adminForm.boxchecked.value == 0) { alert('Please select an item from the list to archive. '); }else{  document.pressed = this.name ;  }" value="Delete" name="delete" class="formbutton" >
		</div>
			<tr>
			  	<td width="1%" class="column-title" align="center" >#</td>			
				<td width="3%" align="center" class="column-title" ><input type="checkbox" name="toggle" onClick="checkAll(<?php echo  $n ; ?>);" ></td>

				<td width="20%" class="column-title">Title</td>
				<td width="20%" class="column-title">Author</td>
				<td width="20%" class="column-title" >Date Uploaded</td>
				<td width="20%" class="column-title" >Voice File</td>								
			    <td width="10%" class="column-title" >Transcribed Document</td>
			</tr>
			<?php
				for( $i = $start ; $i < ($start+$limit) ; $i++ ) 			
				{
					if ( isset( $result[$i] ) ) 
					{
				?>
				<tr class="row<?php echo ( $i%2 ); ?>" >
					<td align="center"><?= ($i+1); ?></td>
					<td class="fdata" align="center" ><input type="checkbox" name="cid[]" id="cb<?php echo $i ;?>" value="<?php echo $result[$i]->getArticleId() ; ?>" onclick="ischecked(this.checked)"  /></td>
					<td class="fdata" ><a href="../systempanel/view.php?ID=<?php echo $result[$i]->getArticleId() ;?>" ><?php echo $result[$i]->getArticleTitle() ; ?></a></td>
					<td class="fdata" >&nbsp;</td>
					<td class="fdata" ><?php echo date( 'F d Y' ,$result[$i]->getArticleSubmittedDate() ) ; ?></td>
					<td class="fdata" >
					<?php
					$account = new UserAccount ; 
					$data = $account->getUserAccountData( $result[$i]->getArticleSubmittedBy() );
					echo $data[0]->fullname ;
					?></td>
				    <td class="fdata" >
					<?php 
					$s = new ArticleStatus ;
					$b = $s->getArticleStatusById( $result[$i]->getArticleStatus() );

					switch( strtolower( $b->status ) )
					{
						case 'draft':
							$class = 'article-draft' ;
							break;
						case 'published' :
							$class = 'article-published' ;							
							break ;
						case 'unpublished' :
							$class = 'article-unpublished' ;													
							break ;		
					}
					echo "<span class = $class >" . $b->status . "</span>" ;					
					?> </td>
				</tr>
				<?php
					} //endif
				} // endfor
			 ?>
			<tr >
			  <td colspan="7" align="left" class="pagelinks" ><?php echo $links ; ?></td>
			 </tr>
			<input type="hidden" name="boxchecked" value="0" />
		</table>
		</form>
	</div>
	
<?php 
include_once( '../tiles/footer.php' );
?>