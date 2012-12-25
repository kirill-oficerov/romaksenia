<?php 
/**
 * Plugin By Jabin Kadel (Web Programmer and WpSmartApps.com Founder)
 *
 * Holds necessary functions and variables
 */
class WSA_LIC_ReadersFromRss2Blog {


	var $rfr2b_options_table       = 'rfr2b_options';
	var $rfr2b_target_rss_table    = 'rfr2b_target';
	
	
	var	$rfr2b_control_options = array(
									'rfr2b_include_pages' => '',
									'displayINpageID' => array(),
									'rfr2b_display_post_tags' => 1,
									'display_x_comments' => 1, 
									'related_post' => 5,
									'noOfComments2display' => 3,
									'rfr2b_display_latest_post_comments' => 1,
								);
								
	/**
	 * Creates Optin options table
	 */
	function __rfr2b_options_table() {
		$chk_exist_optintable = mysql_query("SHOW TABLES LIKE '$this->rfr2b_options_table'");
		$exists = mysql_fetch_row($chk_exist_optintable);
		if ( !$exists ) {
			$create_rfr2b_options_table = "CREATE TABLE ".$this->rfr2b_options_table." (                                  
										   `option_name` varchar(250) collate utf8_general_ci NOT NULL,  
										   `option_value` text collate utf8_general_ci,                  
											PRIMARY KEY  (`option_name`)                                    
											);
										   ";
			mysql_query($create_rfr2b_options_table);
			return true;
		}
		return false;
	}
	
	
	/**
	 * Create auto table
	 */
	function __rfr2b_target_rss_table() {
		$db_table = mysql_query("SHOW TABLES LIKE '$this->rfr2b_target_rss_table'");
		$exists = mysql_fetch_row($db_table);
		if ( !$exists ) {
		$create_targer_rss_table = "CREATE TABLE ".$this->rfr2b_target_rss_table." (                                                
										 `id` int(11) NOT NULL auto_increment,                                               
										 `rss_content` text collate utf8_general_ci NOT NULL,                     
										 `rss_ad_campaign_name` varchar(100) collate utf8_general_ci NOT NULL,                   
										 `optin_fields` text collate utf8_general_ci NOT NULL,                      
										 `rss_extra` text collate utf8_general_ci NOT NULL,                      
										 `flag_ad_campaign` enum('0','1') collate utf8_general_ci NOT NULL default '0',            
										 PRIMARY KEY  (`id`)                                                          
										); 
										";
			mysql_query($create_targer_rss_table);
			return true;
		}
		return false;
	}
	
	
	/**
	 * Adds default optin data to DB table
	 */
	function __rfr2b_DefaultOptinData() {
		$rfr2b_DefaultData = array(
					'rfr2b_affiliate_options'  => '',
					'rfr2b_no_Comments'        => '0 (Zero),  Be the first to leave a reply!',
					'rfr2b_one_Comments'       => '1 (One) on this item',
					'rfr2b_more_Comments'      => '% comments on this item',
					'rfr2b_randompost_title'   => 'You might be interested in this:',
					'rfr2b_social_links'       => stripslashes('<a href="http://del.icio.us/post?url=%post-url%&title=%post-title%">del.icio.us</a>&nbsp;|&nbsp; <a href="http://www.facebook.com/share.php?u=%post-url%" >Share on Facebook</a> &nbsp;|&nbsp; <a href="http://twitthis.com/twit?url=%post-url%&title=%post-title%">Twitter</a>&nbsp;|&nbsp; <a href="http://digg.com/submit?phase=2&url=%post-url%&title=%post-title%" >Digg</a>&nbsp;|&nbsp; <a href="http://www.stumbleupon.com/submit?url=%post-url%&title=%post-title%" >StumbleUpon</a>'),
					'rfr2b_copyright_notice'   => 'Copyright &copy;&nbsp;<a href="%blog-url%">%blog-name%</a> [<a href="%post-url%">%post-title%</a>], All Right Reserved. %year%.',
					'rfr2b_control_options'    => serialize($this->rfr2b_control_options),  
							);
		foreach( $rfr2b_DefaultData as $key => $val ) {
			$db_insert_DefaultData = "INSERT INTO $this->rfr2b_options_table (option_name, option_value) VALUES ('$key', '$val')";	
			mysql_query($db_insert_DefaultData);				
		}									
	}
	
	
	/**
	 * Get options from option table
	 */
	function __rfr2b_fetch_Options( $option_name = '' ) {
		$sql = "SELECT option_name, option_value FROM $this->rfr2b_options_table";
		if ( $option_name != '' ) $sql .= " WHERE option_name='$option_name'";
		$rs = mysql_query($sql) or die("Invalid query: ".mysql_errno().': '.mysql_error());
		while ( $row = mysql_fetch_assoc($rs) ) {
			if ( $row['option_name'] == 'rfr2b_affiliate_options' ) $this->fetch_rfr2b_affiliateOptions = unserialize($row['option_value']);
			if ( $row['option_name'] == 'rfr2b_no_Comments' ) $this->fetch_rfr2b_no_Comments = $row['option_value'];
			if ( $row['option_name'] == 'rfr2b_one_Comments' ) $this->fetch_rfr2b_one_Comments = $row['option_value'];
			if ( $row['option_name'] == 'rfr2b_more_Comments' ) $this->fetch_rfr2b_more_Comments = $row['option_value'];
			if ( $row['option_name'] == 'rfr2b_social_links' ) $this->fetch_rfr2b_social_links = $row['option_value'];
			if ( $row['option_name'] == 'rfr2b_randompost_title' ) $this->fetch_rfr2b_randompost_title = $row['option_value'];
			if ( $row['option_name'] == 'rfr2b_copyright_notice' ) $this->fetch_copyright_notice = $row['option_value'];
			if ( $row['option_name'] == 'rfr2b_control_options' ) $this->fetch_rfr2b_control_options = unserialize($row['option_value']);
		}
	}	

	/**
	 * Displays Readers From RSS 2 Blog: Header
	 */
	function __rfr2b_header() {
		// Define page call
		$rfr2b_wp_pg_vars = 'page='.$_GET['page'].'&';
		// Define header css call
		if( $_GET['rfr2bpg'] == 'ug' ) $rfr2b_css_active_ug = 'active';
		else if( $_GET['rfr2bpg'] == 'target' ) $rfr2b_css_active_target = 'active';
		else if( $_GET['rfr2bpg'] == '' ) $rfr2b_css_active_global = 'active';
		
		// Header Option menus
		echo '<link rel="stylesheet" type="text/css" media="all" href="'.RFR2B_LIBPATH.'admin-pg/css/style.css" />';
		echo '<script type="text/javascript" src="'.RFR2B_FULLPATH.'/wpsmartapps-lic/js/global.js"></script>';
		echo '<h2 style="color:#1C2A47;font-size:19px;padding-bottom:10px; font-weight:bold; ">'.$this->rfr2b_img_logo.'</h2>';
		echo '<div class="rfr2b_headermenu">';
		echo '<span class="'.$rfr2b_css_active_global.'"><b>&nbsp;<a href="'.$this->rfr2b_plugin_page.'?'.$rfr2b_wp_pg_vars.'">Global RSS Campaign </a></b></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<span class="'.$rfr2b_css_active_target.'"><b>&nbsp;<a href="'.$this->rfr2b_plugin_page.'?'.$rfr2b_wp_pg_vars.'rfr2bpg=target">Targeted RSS Ad Campaign</a></b></a></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '</div>';
		
		
		if( $_GET['rssmsg'] == 1 ) {
			$this->rfr2b_process_msg = '<strong>Selected \'Targeted RSS Ad Campaign\' Update Successfully. </strong>';
		}
		
		if ( trim($this->rfr2b_process_msg) != '' ) {
			echo '<div id="global_rfr2b_msg" style="font-size:14px; width:775px; background:#FCF9E7; font-weight:bold;border:1px solid #FFAD33; padding:10px 10px 10px 10px;font-family:  Tahoma, Geneva, sans-serif;"><div style="float:left">';
			echo $this->rfr2b_img_edit.'&nbsp;&nbsp;'.$this->rfr2b_process_msg; 
			echo '</div><div>&nbsp;</div></div>';
		?>
			<script>
				  jQuery(document).ready(function(){
					 jQuery("#global_rfr2b_msg").fadeOut(6000); //animation	
				  });	
			</script>
		<?php
		}
	}
	
	
	/**
	 * Process global and target pages.
	 */
	function __rfr2b_processPg() {
	
		$this->rfr2b_postrequest = $_POST['rfr2b'];
		$process_global_rss_campaign = $this->rfr2b_postrequest['rss_global_data_submit'];
		$process_affiliateData = $this->rfr2b_postrequest['SaveAffiliateData'];
		
		if( $process_global_rss_campaign == 'Save Global Changes' ) {
		
			foreach ( (array) $this->rfr2b_postrequest as $key => $val ) {
				if ( $key == 'rfr2b_no_Comments' ) $process_no_comment = trim($val);
				else if ( $key == 'rfr2b_one_Comments' ) $process_one_comment = trim($val);
				else if ( $key == 'rfr2b_more_Comments' ) $process_more_comment = trim($val);
				else if ( $key == 'rfr2b_social_links' ) $process_social_links = trim($val);
				else if ( $key == 'rfr2b_copyright_notice' ) $process_copyright_notice = trim($val);
				else if ( $key == 'rfr2b_randompost_title' ) $process_ranrom_post_title = trim($val);
				else if ( $key != 'rfr2b_control_options' ) $process_control_options[$key] = $val;
			}
			
			$process_control_options = serialize($process_control_options);
			$rfr2b_global_tempData = array(
									'rfr2b_no_Comments' => $process_no_comment,
									'rfr2b_one_Comments' => $process_one_comment,
									'rfr2b_more_Comments' => $process_more_comment,
									'rfr2b_social_links' => $process_social_links,
									'rfr2b_randompost_title' => $process_ranrom_post_title,
									'rfr2b_copyright_notice' => $process_copyright_notice,
									'rfr2b_control_options' => $process_control_options,
									 );	
			foreach($rfr2b_global_tempData as $key => $val) {
				$db_globalRss_sql = "UPDATE $this->rfr2b_options_table SET option_value='$val' WHERE option_name='$key'";
				mysql_query($db_globalRss_sql);				
			}	
			$this->rfr2b_process_msg = '<strong>Global RSS Campaign Saved Successfully. </strong>';
		
		
		} else if( $process_affiliateData == 'Submit' ) {
		
			foreach ( (array) $this->rfr2b_postrequest as $key => $val ) {
				if ( $key != 'affiliate_next_step' ) $process_affiliate_options[$key] = trim($val);
			}
			$process_affiliate_options = serialize($process_affiliate_options);
			$rfr2b_affiliate_tempData = array(
									'rfr2b_affiliate_options' => $process_affiliate_options,
									 );	
			foreach($rfr2b_affiliate_tempData as $key => $val) {
				$db_globalRss_sql = "UPDATE $this->rfr2b_options_table SET option_value='$val' WHERE option_name='$key'";
				mysql_query($db_globalRss_sql);				
			}	
			$this->rfr2b_process_msg = '<strong>Affiliate Program Saved Successfully. </strong>';
		
		}
	
		return $this->rfr2b_process_msg;
	}


	/**
	 * Displays the plugins options
	 */
	function __rfr2b_displayDashboardPg() {
		// Define pages according to page call
		if ( $_GET['rfr2bpg'] == 'target' )	$display_page = 'admin-pg/target.php';
		else if( $_GET['rfr2bpg'] == 'ug' ) $display_page = 'admin-pg/upgrade.php';
		else 						        $display_page = 'admin-pg/manage-rss.php';
		// Call
		$this->__rfr2b_fetch_Options();
		
		// Affiliate
		if( $this->fetch_rfr2b_affiliateOptions['no_pwd_by'] == 1 ) $no_poweredby_chk = 'checked';
		
		// Social Icons
		if( $this->fetch_rfr2b_control_options['rfr2b_social_del'] == 1 ) $social_del_check = 'checked';
		if( $this->fetch_rfr2b_control_options['rfr2b_social_facebook'] == 2 ) $social_facebook_check = 'checked';
		if( $this->fetch_rfr2b_control_options['rfr2b_social_tweet'] == 3 ) $social_tweet_check = 'checked';
		if( $this->fetch_rfr2b_control_options['rfr2b_social_digg'] == 4 ) $social_digg_check = 'checked';
		if( $this->fetch_rfr2b_control_options['rfr2b_social_stumble'] == 5 ) $social_stumble_check = 'checked';
		
		// Include Pages
		if( $this->fetch_rfr2b_control_options['rfr2b_include_pages'] == 1 ) {
			$rssIncludePages_chk = 'checked';
			$rssIncludePages_chk_display = 'block';
		} 
		
		// Latest Comments
		if( $this->fetch_rfr2b_control_options['rfr2b_display_latest_post_comments'] == 1 ) {
			$display_latestComments = 'checked';
		}		
		
		if( $this->fetch_rfr2b_control_options['display_x_comments'] == 1 ) { 
			$display_x_comment_chk = 'checked';
			$display_x_comment_chk_display = 'block';
		}
		
		if( $this->fetch_rfr2b_control_options['rfr2b_display_post_tags'] == 1 ) $rfr2b_display_post_tags_chk = 'checked';	

		// Call header
		$this->__rfr2b_header(); 
		// Display pages according to the page call.	
		require_once($display_page);
	}
	
	/**
	 * RSS Ad Campaign 
	 */
	function __rfr2b_display_Feed( $post_content, $post_id, $post_title, $noof_comments, $tags ) {
		$this->__rfr2b_fetch_Options();
		
		// Display Post Tag
		if( $this->fetch_rfr2b_control_options['rfr2b_display_post_tags'] == 1 ) {
			$post_content .= '<br><br><img src="'.RFR2B_LIBPATH.'images/ico-tag.png" border="0" align="absmiddle"> Tags:&nbsp;&nbsp;'.$tags;
		}
		
		// Social Links
			$displaySocialIcons = '<br><br><div style="width:80%"><table align="left" width="50%" cellspacing="0" cellpadding="0" bgcolor="#f1f1f1"  border="0px;">
				<tbody>
				<tr bgcolor="#ffffff">';
			
			if( $this->fetch_rfr2b_control_options['rfr2b_social_del'] != 1 ) {	
				$displaySocialIcons .= '<td align="center" width="17%" valign="top">
						<span class="sb_title">Del.icio.us</span><br>
						<a href="http://del.icio.us/post?url=%post-url%&title=%post-title%">
						<img src="'.RFR2B_LIBPATH.'images/delicious.gif" border="0" align="absmiddle">
						</a>  
						</td>';
			}
			
			if( $this->fetch_rfr2b_control_options['rfr2b_social_facebook'] != 2 ) {	
				$displaySocialIcons .= '<td align="center" width="17%" valign="top">
						<span class="sb_title">Facebook</span><br>
						<a href="http://www.facebook.com/share.php?u=%post-url%"><img src="'.RFR2B_LIBPATH.'images/facebook_icon.png" border="0" align="absmiddle"></a>  
						</td>';
			}		
			
			if( $this->fetch_rfr2b_control_options['rfr2b_social_tweet'] != 3 ) {	
				$displaySocialIcons .= '<td align="center" width="17%" valign="top">
						<span class="sb_title">TweetThis</span><br>
						<a href="http://twitthis.com/twit?url=%post-url%&title=%post-title%"><img src="'.RFR2B_LIBPATH.'images/tweet.png" border="0" align="absmiddle"></a>  					</td>';
			}		
					
			if( $this->fetch_rfr2b_control_options['rfr2b_social_digg'] != 4 ) {	
				$displaySocialIcons .= '<td align="center" width="17%" valign="top">
						<span class="sb_title">Digg</span><br>
						<a href="http://digg.com/submit?phase=2&url=%post-url%&title=%post-title%"><img src="'.RFR2B_LIBPATH.'images/digg.png" border="0" align="absmiddle"></a>  
						</td>';
			}		
					
			if( $this->fetch_rfr2b_control_options['rfr2b_social_stumble'] != 5 ) {	
				$displaySocialIcons .= '<td align="center" width="17%" valign="top">
						<span class="sb_title">StumbleUpon</span><br>
						<a href="http://www.stumbleupon.com/submit?url=%post-url%&title=%post-title%"><img src="'.RFR2B_LIBPATH.'images/stumble.gif" border="0" align="absmiddle"></a>  
						</td>';
			}		
					
					
		$displaySocialIcons .= '</tr>
				</tbody></table></div>';
			$newSocialIcons = str_replace('%post-url%', $this->post_url, $displaySocialIcons);
			$displayNewSocialIcons = str_replace('%post-title%', $this->postTitle, $newSocialIcons);
			$post_content = $post_content.$displayNewSocialIcons;
		
		// Feed Content Start
		$post_content .= '<br><div style="background:#EEEEEE; padding:0px 0px 0px 15px; margin:10px 0px 0px 0px;">';
		
		// Display Comments
		if( $this->fetch_rfr2b_control_options['display_x_comments'] == 1 ) {
			if ( $noof_comments == 0 ) {
				$One_comment_text = $this->fetch_rfr2b_no_Comments;
				$comment_text .= '<a href="'.$this->post_url.'#respond">';
				$comment_text .= $One_comment_text;
				$comment_text .= '</a>';
			} else if ( $noof_comments == 1 ) {
				$Two_comment_text = $this->fetch_rfr2b_one_Comments;
				$comment_text .= '<a href="'.$this->post_url.'#comments">';
				$comment_text .= $Two_comment_text;
				$comment_text .= '</a>';
			} else if ( $noof_comments  == 2 || $noof_comments  > 2 ) {
				$More_comment_text = $this->fetch_rfr2b_more_Comments;
				$comment_text .= '<a href="'.$this->post_url.'#comments">';
				$comment_text .= $More_comment_text;
				$comment_text .= '</a>';
			}
			$comment_text = str_replace('%', $noof_comments, $comment_text);
			$rss_comment_text = '<div style="padding:5px 0px 5px 0px;">';
			$rss_comment_text .= '<b>Comments:</b>&nbsp;&nbsp;'.$comment_text;
			$rss_comment_text .= '</div>';
			$post_content = $post_content.$rss_comment_text;
		}
		
		// Random Post
		if( $this->fetch_rfr2b_control_options['related_post'] > 0 ) {
			$rss_random_post_heading = '<div style="padding:13px 0px 5px 0px;"><span style="border-bottom:1px dashed #003399;padding-bottom:4px;"><strong>'.$this->fetch_rfr2b_randompost_title.'</strong></span>&nbsp;&nbsp;<br>';
			list($noof_random_posts,$fetch_random_posts) = $this->rfr2b_ramdom_post($this->fetch_rfr2b_control_options['related_post'], $this->postID);
			$the_random_posts .= $rss_random_post_heading.$fetch_random_posts.'</div>';
			$post_content = $post_content.$the_random_posts;
		}
		
		// Seprator
		$post_content .= '</div>';
		
		// Seprator
		$post_content .= '<hr style="color:#EBEBEB" />';
		
		// Copyright Notice   
		if( isset($this->fetch_copyright_notice) &&  !$this->fetch_copyright_notice == '' ) {
			$CopyrightNotice = $this->fetch_copyright_notice;
			$newCopyrightNotice = str_replace('%blog-url%', $this->blogurl, $CopyrightNotice);
			$newCopyrightNotice = str_replace('%blog-name%', $this->blog_name, $newCopyrightNotice);
			$newCopyrightNotice = str_replace('%year%', $this->year, $newCopyrightNotice);
			$newCopyrightNotice = str_replace('%post-url%', $this->post_url, $newCopyrightNotice);
			$newCopyrightNotice = str_replace('%post-title%', $this->postTitle, $newCopyrightNotice);
			$displayCopyrightNotice .= '<small>'.$newCopyrightNotice.'</small><br>';
			if( $this->fetch_rfr2b_affiliateOptions['no_pwd_by'] == 1 ) { 
			$displayCopyrightNotice .= '&nbsp;';
			}
			$post_content = $post_content.$displayCopyrightNotice;
		}
		
		if( $this->fetch_rfr2b_affiliateOptions['cbid'] == '' ) {
			$ckb_affiliate = '';
		} else {
			$ckb_affiliate = $this->fetch_rfr2b_affiliateOptions['cbid'];
		}
		
		if( $this->fetch_rfr2b_affiliateOptions['no_pwd_by'] == 1 ) { 
			$poweredByNotice = '<small>Powered by <a href="http://www.wpsmartapps.com/go.php?offer='.$ckb_affiliate.'&pid=6">Readers From RSS 2 Blog</small><br><br><br>';
			$post_content = $post_content.$poweredByNotice;
		}
		
		$post_content = $post_content;
		
		return $post_content;
	}
	

} // Eof Class

$WSA_LIC_ReadersFromRss2Blog = new WSA_LIC_ReadersFromRss2Blog();
?>