<?php $languages = icl_get_languages('skip_missing=0&orderby=code'); ?>

<div class="header-language">
    <ul class="menu">
        <li class="has-dropdown">
            <i class="fa fa-angle-down"></i>
            <a href="#"><?php echo ICL_LANGUAGE_CODE; ?></a>
            <ul>	
	            <?php
	            	if(!( empty($languages) )){
	            	    foreach($languages as $l){
	            	        echo '<li><a href="'.$l['url'].'">'.$l['native_name'].'</a></li>';
	            	    }
	            	}
	            ?>
            </ul>
        </li>
    </ul>
</div>