<?php 

/* css3lightbox welcome admin template
 * Author: René Hermenau
 * @since 1.0.5
 * @change 1.0.5
 */ 


/* Quit */
defined('ABSPATH') OR exit;

add_action( 'admin_menu', 'css3lightbox_welcome_menu', '' );

function css3lightbox_welcome_menu() {
	add_menu_page(__('CSS3 Lightbox'), __('CSS3 Lightbox'), 'edit_themes', 'css3lightbox-welcome-core', 'css3lightbox_welcome_conf', ''); 
}

function css3lightbox_welcome_conf() {
	global $css3lightbox_welcome_nonce;	

?>

<div class="wrap rm_wrap">
<h1> CSS3 Lightbox v.<?php echo get_option(CSS3LIGHTBOX_VERSION_KEY);?> says: "Welcome" </h1>
<div class="rm_opts";
<table class="form-table"> 
<tr>
                                        <td valign="top">
										<h2>You´re awesome, You succesfully installed the one and only 100% pure CSS3 Lightbox!</h2>
                                          This lightbox does not need any options page. When you see this screen, it is already working on your site.<br>
										  We made this page to give you a good feeling that everything is fine and to show you our latest 
										  lighbox add-ons;-)</p><p>
										  <strong>The only information you need:</strong><br>
										  if you like to have your images opened in a large version<br>
										  with a beautiful lightbox effect link them to 'media' or 'image url'.
<br>
										<img src="<?php echo plugin_dir_url( __FILE__ );?>../images/how-to-link.png" alt="how to link the images" style="margin-top:20px;">                                            
                  
										</td>
</tr>

</table>
</div>
<div style="float:clear;">
</div>

<div style="clear:both;">
    <?php css3lightbox_add_ons_page(); ?>
<div style="clear:both;">
</div>
<?php 
}
?>