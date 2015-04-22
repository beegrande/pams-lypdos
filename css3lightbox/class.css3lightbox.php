<?php


add_filter ( 'the_content' , 'css3', 10000);
	
//global $content;
function css3 ( $content ) {
if (is_single() or is_page() or is_singular()){
		        //$master_pattern = '%<a[^>]+><img([^>])+></a>%'; // for regular images and for urls which only link to images and no websites
                //$master_pattern = '%<a * href= *([^>]+\.(png|jpg|gif)"><img([^>])+></a>)%'; // for regular images and for urls which only link to images
                  $master_pattern = '%<a.+href= *([^>]+\.(png|jpg|gif)"(|.+)><img([^>])+><\/a>)%';
		if ( preg_match_all ( $master_pattern , $content , $links ) ) {
			$counter = 0;
			foreach ( $links[0] as $link ) {
				$counter +=1;
				$img_thumbnail_src = preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $link, $matchesthumb);
				$img_fullimage_src = preg_match('/href=["\']?([^"\'>]+)["\']?/', $link, $matchesfull);
				$img_class_src = preg_match('/class=["\']?([^"\'>]+)["\']?/', $link, $imgclass);
				$alt_name_src = preg_match('/alt=["\']?([^"\'>]+)["\']?/', $link, $altname);
				
				  $replacestring = '<a name="imageclose-' . $counter . '"><div class="lb-album"><a href="#image-'.$counter.'"><img src="'.$matchesthumb[1].'" '.$altname[0].' ' . $imgclass[0]. '><span></span></a></div>
                   <a href="#imageclose-' . $counter . '" class="close">
				   <div class="lb-overlay" id="image-'.$counter.'">
                   <img src="'.$matchesfull[1].'" alt="image-'.$counter.'">
                   </div></a>';
				
					  $content = str_replace ( $link, $replacestring, $content); 
				
			}
		  }
		}

		//return $content;
		return apply_filters( 'css3lightbox_content', $content);
	}
	


function buffer_end() { 
ob_end_flush(); 
}

	function buffer_start() { 
	ob_start("css3"); 
	}


?>