<?php

?>
<form method="get" class="searchform uk-position-relative" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="text" class="field uk-input inputbox search-query uk-margin-remove-vertical" name="s" placeholder="<?php esc_attr_e( 'Search...', 'travelami');?>" />
    <button type="submit" class="submit searchsubmit has-button-icon uk-position-right" name="submit" data-uk-icon="search"></button>
</form>