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
					'No' => 'No',
					'Yes' => 'Yes'
					
				),
				''
			);
$this->select(	'comments_type',
				'Comments Type',
				array(
					'None' => 'None',
					'WP' => 'WP',
					'Facebook' => 'Facebook',
					'Both' => 'Both'
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

?>
</div>