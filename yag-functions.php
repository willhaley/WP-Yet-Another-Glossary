<?php

/**
 * @package yet-another-glossary
 */

/**
 * Adds / Edits the entered word and its definition
 * @param NULL
 * @return sting
 */
function edit_yag()
{
		
		global $wpdb;
		$yags 			= get_option('yags');
		$yag_keyword 	= NULL;
		$yag_content 	= NULL;
		$added			= FALSE;
		
		if ( isset ( $_POST['yag_keyword'] ) )
			$yag_keyword = trim ( $_POST['yag_keyword'] );
		
		if ( isset ( $_POST['yag_content'] ) )
			$yag_content = trim ( $_POST['yag_content'] );
			
		if ( isset ( $_POST['yag_id'] ) )
			$yag_id = trim ( $_POST['yag_id'] );
		
		if ( isset ( $_POST['yag_keywordsubmitnew'] ) ) {
					
			if ( $yag_content && $yag_keyword && $yags )  {

				foreach ( $yags as $id => $yag ) {
		
					if ( $id == (int) $yag_id ) {
		
						$yags[$yag_id]['keyword'] 	= $yag_keyword;
						$yags[$yag_id]['content'] 	= $yag_content;
					}
					else {
						$yags[$yag_id] = array('keyword' => $yag_keyword, 'content' => $yag_content);
					}
				}
				
				update_option ( 'yags' , $yags );
				yag_message ( "YAG?! Word Added." );

			}
			else if ( $yag_content && $yag_keyword ) {

				$yags[] = array ( 'keyword' => $yag_keyword, 'content' => $yag_content );
				update_option ( 'yags' , $yags );
				yag_message ( "YAG?! Word Added." );
			}
			else {
				
				yag_message ( "YAG?! Nothing New?." );
			}
		}
		
		if ( isset ( $_POST['yag_keywordsubmitedit'] ) ) {
			
			if ( $yag_content && $yag_keyword ) {
			    
			#    print '<pre>';
			#    print_r($yags);
			#    print_r($_POST);
			    
				$yags[$yag_id]['keyword'] 	= $yag_keyword;
				$yags[$yag_id]['content'] 	= $yag_content;  
				
			#	print_r($yags);
		#		print '</pre>';
				//die();
				
				
				update_option('yags',$yags);
			}

			yag_message ( "YAG?! Changes Saved." );
			
		}

		else if ( isset ( $_POST['yag_keywordsubmitdelete'] ) ) {
			
			unset ( $yags[$yag_id] );
			update_option ( 'yags' , $yags );
			
			yag_message ( "YAG?! Word Deleted." ) ;
		}
?>

<div style='margin:10px 5px;'> 
	<div style='font-size:22px;'>Add/Edit Glossary Words</div>
</div>
<div id="dashboard-widgets-wrap">
	To create a glossary page, place the tag [YAGlossaryPage] on a page you create. 
	Also, make sure to give the page the url of /glossary so the anchors will work properly
</div>
<div style='clear:both'></div>		
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='handle'>Add To Glossary</h3>
									<div class="inside" >
										<form id="yag_form" name="yag_form" action="" method="POST">
										<table id="yag_table">
											<tr>
												<td width="10%">Word: </td>
												<td width="20%"><input type="text" id="yag_keyword" name="yag_keyword" value=""></td>
												<td width="10%">Defined As:</td>
												<td width="40%"><textarea rows="2" cols="40" name='yag_content'></textarea></td>
												<td width="10%">
													<input type="hidden" id="yag_id" name="yag_id" value="<?php echo rand(100000, 99999999)?>">
													<input type="submit" id="yag_keywordsubmitnew" name="yag_keywordsubmitnew" value="Add Now">
												</td>
											</tr>
										</table>
										<br />
										
										</form>
										<div id="dictionary_word"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>
<?php $yags = get_option('yags'); ?>
<?php if ( count($yags) ):	?>
		<div class="wrap">
			<div id="dashboard-widgets-wrap">
			    <div id="dashboard-widgets" class="metabox-holder">
					<div id="post-body">
						<div id="dashboard-widgets-main-content">
							<div class="postbox-container" style="width:90%;">
								<div class="postbox">
									<h3 class='handle'>Edit Existed Glossary Words</h3>
									<div class="inside">
										<form id="yag_form" name="yag_form" action="" method="POST">
											<table id="yag_table">
											<?php foreach ($yags as $key => $yag): ?>
												<tr>
													<td width="10%">Word:</td>
													<td width="20%">
														<input type="text" id="yag_keyword" name="yag_keyword" value="<?php echo stripslashes(stripslashes($yag['keyword'])); ?>" />
													</td>
													<td width="10%">Defined As:</td>
													<td width="35%">
														<textarea rows="2" cols="35" name='yag_content'><?php echo stripslashes(stripslashes($yag['content'])); ?></textarea></td>
													<td width="12%" style='align:right;text-align:right;padding-left:3px;'>
														<input type="hidden" id="yag_id" name="yag_id" value="<?php echo $key; ?>">
														<input type="submit" class="yag_keywordsubmitedit" name="yag_keywordsubmitedit" value="Update" />										
													</td>
													<td width="13%" style='align:right;text-align:right;'>
														<input type="submit" class="yag_keywordsubmitdelete" name="yag_keywordsubmitdelete" value="Delete" />										
													</td>										
												</tr>
										<?php endforeach; ?>
											</table>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
		    	</div>
			</div>
		</div>
		<div style="clear:both"></div>

<?php endif; ?>			
<?php 

}


/**
 * Wraps the message from the edit_yag() function in html
 * 
 * @see edit_yag
 * @param string $message
 * @return string
 */
function yag_message($message)
{
	echo "<div id='message' class='updated fade'>$message</div>";
}

/**
 * Adds the Glossary Menu item to the admin
 */
function yaggerfy_the_admin()
{
	add_menu_page(__('Glossary','Glossary'), __('Glossary','Glossary'), 10, 'yag-functions.php','edit_yag');
}

/**
 * Creates the glossary page when the tag [YAGlossaryPage] is present in the content.
 * Loops through all of the words and lays out there definition
 * 
 * @param string $content
 * @return string
 */
function yaggerfy_page($content) {

	if (!preg_match('/\[YAGlossaryPage\]/i', $content )) 
		return $content;

	$html = array();
	$yags = get_option('yags');
		
	foreach($yags as $yag)
	{
		$word_list[$yag['keyword']] = '<p class="yag_word_container">';
		$word_list[$yag['keyword']].= '<span class="yag_word"><a name="' . stripslashes ( strtolower($yag['keyword'] ) ) . '">' . stripslashes(ucwords($yag['keyword'])) .':</a></span> ';
		$word_list[$yag['keyword']].= '<span class="yag_definition">' . stripslashes ( $yag['content'] ).'</span></p>';
	}
	ksort($word_list);
	$html = implode("\n", $word_list);
	return preg_replace('/\[YAGlossaryPage\]/', $html, $content, 1);
}

/**
 * Searches the content of post / pages for words in the glossary
 * If found, wraps the word in the needed html and outputs the definition 
 * of the word in a hidden div that will put at the end of the content
 * 
 * @param string $content
 * @return string
 */
function yaggerfy_words($content)
{
	if (preg_match('/\[YAGlossaryPage\]/i', $content ))
		return $content;
	
	if(!$options = get_option('yags'))
		return $content;
	
	$defs = array();
	foreach ($options as $key => $option)
	{
		if ( stripos( $content, $option['keyword'] ) === false)
			continue;
		
		$replace = ' <span id="' . $key . '" class="word_' . $key . ' aYag"><a href="' . site_url() .'/glossary/#' . $option['keyword'] . '">' . stripslashes( $option['keyword'] ). '</a></span> ';
		
		$defs[] = '<div id="definition_' . $key . '" style="display:none;">' . stripslashes ( nl2br ( utf8_encode ( $option['content'] ) ) ) . '</div>';
		
		$content = preg_replace ( "/ ". $option['keyword'] ."/is", $replace ,$content );
	}
		
	return $content . implode ( "\n", $defs );
}

/**
 * Updates the head to include the jQuery (if not already present) and the 
 * qtip js plugin, which handles the tooltip feature of the plgin
 */
function yagged_in_the_hEEd()
{
	if (!is_admin()) {
		wp_enqueue_script('jquery');
		
		wp_register_script( 'jquery-qtip', plugins_url('/js/qtip/jquery.qtip-1.0.0-rc3.min.js', __FILE__));
		wp_enqueue_script( 'jquery-qtip' );
	}
}

/**
 * Builds the JS script that adds the hover event to all of the words
 * that were found in the glossary so the definition will be presented 
 * to the user on hover
 */
function yagger_up_js()
{
?>
	<script type="text/javascript">
	jQuery(document).ready(function() {
			jQuery('.aYag').each(function() {
					jQuery(this).qtip({
							overwrite: false,
							content: jQuery('#definition_' + this.id).html(),
			   				style: { padding: 5, background: '#FBFDFE', color: 'black', textAlign: 'left', border: { color: '#eee' } },
			    			position: { corner: { target: 'rightMiddle', tooltip: 'leftBottom' } }, 
			    			show: { ready: false }
						});
					});
	});
	</script>
<?php 
}

/**
 * @todo: Build out the abilty to mod css of tool tip box
 */
function yagger_up_css()
{
	
}