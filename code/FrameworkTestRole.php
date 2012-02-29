<?php

class FrameworkTestRole extends DataObjectDecorator {
	function extraStatics() {
		return array(
			'has_one' => array(
				'FavouritePage' => 'SiteTree',
			),
		);
	}
	
	function updateCMSFields($fields) {
		$fields->push(new TreeDropdownField("FavouritePageID", "Favourite page", "SiteTree"));
	}
	
}

?>