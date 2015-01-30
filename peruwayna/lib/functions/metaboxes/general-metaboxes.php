<div class="reedwan_metabox">
<?php
$this->text(	'page_sidebar',
				'Custom Sidebar',
				''
			);
$this->text(	'background_page',
				'Background Image (url)',
				''
			);
$this->select(	'featured_image',
				'Show Featured Image',
				array(
					'Yes' => 'Yes',
					'No' => 'No'
				),
				''
			);
$this->select(	'comments_type',
				'Comments Type',
				array(
					'WP' => 'WP',
					'Facebook' => 'Facebook',
					'Both' => 'Both',
					'None' => 'None'
				),
				''
			);
$this->select(	'user_rating',
				'Show User Rating',
				array(
					'Yes' => 'Yes',
					'No' => 'No'
				),
				''
			);
$this->select(	'show_review',
				'Show Review',
				array(
					'Yes' => 'Yes',
					'No' => 'No'
				),
				''
			);

?>
</div>