<?php /**/ ?><form method="get" id="searchform" action="<?php bloginfo('url'); ?>/search.php">
	<fieldset>
		<legend>Search Diamondback</legend>
		<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" class="text" />
		<input type="submit" class="hide" value="Search" name="searchsubmit"/>
		<input type="image" src="<?php bloginfo('template_url'); ?>/_img/buttons/blank_button.gif" alt="Search" title="Search" class="submit_button" name="searchsubmit" id="searchsubmit"/>		
	</fieldset>
</form>