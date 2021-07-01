<?php
ob_flush();
add_action( 'wp_enqueue_scripts', 'unicollege_child_styles', 18 );
function unicollege_child_styles() {
	wp_enqueue_style( 'child-style', get_stylesheet_uri() );
	wp_enqueue_style(
		'unicollege-child',
		get_stylesheet_directory_uri() . '/custom.css'
	);
}

add_action( 'after_setup_theme', 'unicollege_child_theme_setup' );
function unicollege_child_theme_setup() {
	load_child_theme_textdomain( 'unicollege', get_stylesheet_directory() . '/languages' );
}



function study_field()
{
	$args = array(
		'post_type' => 'unicollege_courses',
		'taxonomy' => 'study_field',
		'hide_empty' => 0,
		'orderby' => 'date',
		'order' => 'ASC',
	);
	$cats = get_categories($args);
	?>
	<h3 class="widgettitle" style="color: #f5f5f5;">Study Fields</h3>
	<?php
	foreach($cats as $cat) 
	{
		?>
		<a href="<?php echo get_category_link( $cat->term_id ) ?>">
			<?php echo $cat->name; ?><br>
		</a>
		<?php
	}
}
add_shortcode( 'footer_study_field', 'study_field' ); 






function hexagon_search()
{
	$categories = get_terms( array(
		'post_type'      => 'unicollege_courses',
		'taxonomy' => 'study_field',
		'hide_empty' => false,
		'order' => 'DESC'
	) );
	$result='';
	$result .= '<div class="col-sm-7 custom_class">
	<form id="search_form" action="'.site_url().'/wp-admin/admin-ajax.php" class="form-inline wordpress-ajax-form"  method="post">
	<table align="center">
	<div>
	<div class="learning_method_title">LEARNING METHOD</div>
	<div>
	<select name="learning"  class="search_box" id="method">
	<option>Select One</option>
	<option value="full_time">Full Time</option>
	<option value="part_time">Part Time</option>
	<option value="online">Online</option>
	<option value="workshops">Workshops</option>
	</select> 
	</div>
	</div>
	<div>
	<div class="learning_method_title field">FIELD OF STUDY</div>
	<div>
	<select name="show_data" class="search_box2" id="study_field">
	<option>Select One</option>';
	foreach ($categories as $key => $cat) 
	{
		$result .= '<option value="'.$cat->slug.'">'.$cat->name.'</option>';
	}                        
	$result .= '</select>
	</div>
	</div>
	<input type="hidden" name="action" value="custom_action">
	<input type="hidden" name="page" value="1">
	<button class="btn btn-default search_button">SEARCH</button>

	</table>
	</form></div>';
	$result .= '<div id="custom_div" class="col-sm-5 custom_class"></div>';  
	return $result;
}
add_shortcode( 'course_search', 'hexagon_search' ); 



add_action( 'wp_ajax_custom_action', 'hexagon_custom_action' );
add_action('wp_ajax_nopriv_custom_action', 'hexagon_custom_action');


function hexagon_custom_action()
{
	if($_POST['learning'] == 'full_time')
	{
		$learning_method_data = array(
			"key" => "learning_method",
			"value" => 'full_time',
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning'] == 'part_time')
	{
		$learning_method_data = array(
			"key" => "learning_method",
			"value" => 'part_time', 
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning'] == 'online')
	{
		$learning_method_data = array(
			"key" => "learning_method",
			"value" => 'online',
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning'] == 'workshops')
	{
		$learning_method_data = array(
			"key" => "learning_method",
			"value" => 'workshops',
			"compare" => 'LIKE'
		);
	}
	if($_POST['show_data'] != '')
	{
		$category_data = array(
			"key" => "course_faculty",
			"value" => $_POST['show_data'],
			"compare" => 'LIKE'
		);
	}
	$args = array(
		'post_type'      => 'unicollege_courses',
		'publish_status' => 'published',
		'order'          => 'ASC',
		"meta_query" => array(
			"relation" => "AND",
			$category_data,
			$learning_method_data,
		)
	);
	$query = new WP_Query($args);
	?>
	<div style="color: #3b3b3b; font-weight: 700; font-size: 16px; margin-bottom: 15px;">Your Course Options</div>
	<?php
	if($query->have_posts()) 
	{
		while($query->have_posts())
		{
			$query->the_post();
			?>
			<a class="learning_method_title_search" href="<?php the_permalink();?>">
				<?php the_title();?><br>
			</a>
			<?php
		}
		wp_die();
	}
	else
	{
		echo '<div id="custom" class="class="col-sm-5 custom_class"">
		No Course found</div>';
		wp_die();
		wp_reset_postdata();
	}
	?>
	<?php
}




function latest_news() 
{
	?>
	<div class="main_title">Latest UniCollege News</div>
	<?php
	$args = array(
		'posts_per_page' => 2,
		'offset' => 0,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_type' => 'post',
		'post_status' => 'publish'
	);
	$query = new WP_Query($args);
	if ($query->have_posts()) :
		while ($query->have_posts()) : 
			$query->the_post();
			?>
			<div class="right_sidebar_latest_news">
				<a href="<?php the_permalink(); ?>">
					<div class="home_page_title">
						<?php 
						the_title(); 
						?>
					</div><span class="home_page_news">
						<?php
						$content = get_the_content(); 
						echo mb_strimwidth($content, 0, 200, '...');
					?></span>
				</a>
			</div>
			<?php
		endwhile;
		?>
		<a class="see_all_upcoming" href="<?php echo site_url();?>/news-reviews">View All ></a>
		<?php
	endif;
}
add_shortcode('latest_news_home', 'latest_news');





function latest_post() 
{
	?>
	<div class="main_title">Latest UniCollege News</div>
	<?php
	$args = array(
		'posts_per_page' => 3,
		'offset' => 0,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_type' => 'post',
		'post_status' => 'publish'
	);
	$query = new WP_Query($args);
	if ($query->have_posts()) :
		while ($query->have_posts()) : 
			$query->the_post();
			?>
			<div class="right_sidebar_latest_news">
				<a href="<?php the_permalink(); ?>">
					<div class="right_sidebar_image"><?php echo get_the_post_thumbnail( get_the_ID(),'thumbnail' );?>
				</div>
				<div class="right_sidebar_title">
					<?php 
					the_title(); 
					?>
				</div><span class="right_sidebar_expert">
					<?php
					$content = get_the_content(); 
					echo mb_strimwidth($content, 0, 130, '...');
				?></span>
			</a>
		</div>
		<?php
	endwhile;
endif;
}
add_shortcode('latest_news', 'latest_post');

function hexagon_full_time()
{
	$args = array(
		'post_type' => 'unicollege_courses',
		'publish_status' => 'published',
		'meta_query' => array(    
			array(
				'key'   => 'learning_method', 
				'value' => 'full_time',
				'compare'   => 'like',
			),

		)
	);
	$loop = new WP_Query($args);
	if($loop->have_posts())
	{
		while($loop->have_posts())
		{
			$loop->the_post();?>
			<a class="learning_method_wise_title" href="<?php the_permalink();?>"><?php the_title();?><br></a><?php
		}
	}
	else
	{
		?>  
		<span class="learning_method_wise_title">There is no course avaiable</span>
		<?php     
	}
	wp_reset_query();
}
add_shortcode('full_time','hexagon_full_time');

function hexagon_part_time()
{
	$args = array(
		'post_type' => 'unicollege_courses',
		'publish_status' => 'published',
		'meta_query' => array(    
			array(
				'key'   => 'learning_method', 
				'value' => 'part_time',
				'compare'   => 'like',
			),

		)
	);
	$loop = new WP_Query($args);
	if($loop->have_posts())
	{
		while($loop->have_posts())
		{
			$loop->the_post();?>
			<a class="learning_method_wise_title" href="<?php the_permalink();?>"><?php the_title();?><br></a><?php
		}
	}
	else
	{
		?>  
		<span class="learning_method_wise_title">There is no course avaiable</span>
		<?php     
	}
	wp_reset_query();
}
add_shortcode('part_time','hexagon_part_time');

function hexagon_online()
{
	$args = array(
		'post_type' => 'unicollege_courses',
		'publish_status' => 'published',
		'meta_query' => array(    
			array(
				'key'   => 'learning_method', 
				'value' => 'online',
				'compare'   => 'like',
			),

		)
	);
	$loop = new WP_Query($args);
	if($loop->have_posts())
	{
		while($loop->have_posts())
		{
			$loop->the_post();?>
			<a class="learning_method_wise_title" href="<?php the_permalink();?>"><?php the_title();?><br></a><?php
		}
	}
	else
	{
		?>  
		<span class="learning_method_wise_title">There is no course avaiable</span>
		<?php     
	}
	wp_reset_query();
}
add_shortcode('online','hexagon_online');

function hexagon_workshops()
{
	$args = array(
		'post_type' => 'unicollege_courses',
		'publish_status' => 'published',
		'meta_query' => array(    
			array(
				'key'   => 'learning_method', 
				'value' => 'workshops',
				'compare'   => 'like',
			),

		)
	);
	$loop = new WP_Query($args);
	if($loop->have_posts())
	{
		while($loop->have_posts())
		{
			$loop->the_post();?>
			<a class="learning_method_wise_title" href="<?php the_permalink();?>"><?php the_title();?><br></a><?php
		}
	}
	else
	{
		?>  
		<span class="learning_method_wise_title">There is no course avaiable</span>
		<?php     
	}
	wp_reset_query();
}
add_shortcode('workshops','hexagon_workshops');


function get_study_fields() 
{
	$args = array(
		'post_type' => 'unicollege_courses',
		'taxonomy' => 'study_field',
		'hide_empty' => 0,
		'orderby' => 'date',
		'order' => 'ASC',
	);

	$cats = get_categories($args);

	?>
	<div class="vc_row wpb_row vc_row-fluid vc_column-gap-35">
		<?php
		foreach($cats as $cat) {
			$image = get_field('study_field_image', 'category_'.$cat->term_id);
			?>

			<div class="wpb_column vc_column_container vc_col-sm-6 div_height" style="padding: 17.5px;">
				<div class="vc_column-inner">
					<div class="wpb_wrapper">
						<div class="wpb_text_column wpb_content_element">
							<div class="wpb_wrapper">
								<h3>
									<a href="<?php echo get_category_link( $cat->term_id ) ?>" class="archive_study_page">
										<img class="study_image" loading="lazy" class="alignleft wp-image-2772" src="<?php echo $image; ?>">
										<?php echo $cat->name; ?>
									</a>
								</h3>

							</div>
						</div>
						<div class="vc_empty_space" style="height: 32px"><span class="vc_empty_space_inner"></span></div>
					</div>
				</div>
			</div>    

			<?php
		}
		?>
	</div>
	<?php
}
add_shortcode('study_fields', 'get_study_fields');





function hexagon_upcoming_courses() 
{
	?>
	<div class="main_title">Upcoming Courses</div>
	<?php
	$result='';
	$result .= '<form id="upcoming_course_search_form" action="'.site_url().'/wp-admin/admin-ajax.php" class="form-inline wordpress-ajax-form"  method="post" style="display: inline-flex;margin-top:40px;">
	<table align="center">

	<select name="learning"  class="search_box" id="method">
	<option value="select_one">Part Time</option>
	<option value="full_time">Full Time</option>
	<option value="online">Online</option>
	<option value="workshops">Workshops</option>
	</select>
	<input type="hidden" name="action" value="custom_upcoming_action">
	<input type="hidden" name="page" value="1">
	<button class="btn btn-default search_button_upcoming_course">Search</button>
	</table>
	</form>';
	$result .= '<div id="custom_upcoming_course_div"></div>';
	return $result;
}
add_shortcode('upcoming_course', 'hexagon_upcoming_courses');

add_action( 'wp_ajax_custom_upcoming_action', 'hexagon_upcoming_custom_action' );
add_action('wp_ajax_nopriv_custom_upcoming_action', 'hexagon_upcoming_custom_action');

function hexagon_upcoming_custom_action()
{
	global $post;
	//$date = date('Ymd', strtotime('+3 month'));
	$current_date = date('Ymd',strtotime(date('Y-m-d')));
	if($_POST['learning'] == 'full_time')
	{
		$category_data = array(
			"key" => "learning_method",
			"value" => 'full_time',
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning'] == 'part_time')
	{
		$category_data = array(
			"key" => "learning_method",
			"value" => 'part_time',
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning'] == 'online')
	{
		$category_data = array(
			"key" => "learning_method",
			"value" => 'online',
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning'] == 'workshops')
	{
		$category_data = array(
			"key" => "learning_method",
			"value" => 'workshops',
			"compare" => 'LIKE'
		);
	}
	$args = array(
		'post_type'      => 'unicollege_courses',
		'publish_status' => 'published',
		'order'          => 'ASC',
		'posts_per_page' => 15,
		"meta_query" => array(
			$category_data,
		)
	);
	$query = new WP_Query($args);
	$res_html = '';
	if($query->have_posts()) 
	{
		$res_html .= '<div id="result_data">';
		while($query->have_posts())
		{
			$query->the_post();
			$post_id = $post->ID;
			$permalink = get_permalink($post_id);
			$post_title = get_the_title($post_id);
			$upcoming_courses = get_post_meta($post_id);
			$upcoming_learning_method = $upcoming_courses['learning_method'][0];
			$learning_method = unserialize($upcoming_learning_method);
			if($_POST['learning'] == 'select_one')
			{
				$upcoming_part_time_course_start_date = date('Y-m-d',strtotime($upcoming_courses['part_time_course_start_date'][0]));
				if($learning_method[0] == "part_time" && get_post_meta($post_id,'part_time_course_start_date',true) > $current_date)
				{
					$important_array_part_time[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'part_time_course_start_date' => $upcoming_part_time_course_start_date,
						'posts_per_page' => '15',
					);
				}
				if($learning_method[1] == "part_time" && get_post_meta($post_id,'part_time_course_start_date',true) > $current_date )
				{
					$important_array_part_time[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'part_time_course_start_date' => $upcoming_part_time_course_start_date,
						'posts_per_page' => '15',
					);
				}
			}
			if($_POST['learning'] == 'full_time')
			{
				if ($learning_method[0] == "full_time" && get_post_meta($post_id,'full_time_course_start_date',true) > $current_date )
				{
					$upcoming_full_time_course_start_date = date('Y-m-d',strtotime($upcoming_courses['full_time_course_start_date'][0]));
					$important_array_full_time[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'full_time_course_start_date' => $upcoming_full_time_course_start_date,
						'posts_per_page' => '15',
					);
				}
			}
			if($_POST['learning'] == 'online')
			{
				$upcoming_online_course_start_date = date('Y-m-d',strtotime($upcoming_courses['online_course_start_date'][0]));
				if($learning_method[0] == "online" && get_post_meta($post_id,'online_course_start_date',true) > $current_date)
				{
					$important_array_online[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'online_course_start_date' => $upcoming_online_course_start_date,
						'posts_per_page' => '15',
					);
				}
				if($learning_method[1] == "online" && get_post_meta($post_id,'online_course_start_date',true) > $current_date )
				{
					$important_array_online[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'online_course_start_date' => $upcoming_online_course_start_date,
						'posts_per_page' => '15',
					);
				}
				if($learning_method[2] == "online" && get_post_meta($post_id,'online_course_start_date',true) > $current_date )
				{
					$important_array_online[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'online_course_start_date' => $upcoming_online_course_start_date,
						'posts_per_page' => '15',
					);
				}
			}
			if($_POST['learning'] == 'workshops')
			{
				$upcoming_workshop_course_start_date = date('Y-m-d',strtotime($upcoming_courses['workshop_course_start_date'][0]));
				if ($learning_method[0] == "workshops" && get_post_meta($post_id,'workshop_course_start_date',true) > $current_date )
				{
					$important_array_workshop[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'workshop_course_start_date' => $upcoming_workshop_course_start_date,
						'posts_per_page' => '15',
					);
				}
				if($learning_method[1] == "workshops" && get_post_meta($post_id,'workshop_course_start_date',true) > $current_date )
				{
					$important_array_workshop[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'workshop_course_start_date' => $upcoming_workshop_course_start_date,
						'posts_per_page' => '15',
					);
				}
				if($learning_method[2] == "workshops" && get_post_meta($post_id,'workshop_course_start_date',true) > $current_date )
				{
					$important_array_workshop[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'workshop_course_start_date' => $upcoming_workshop_course_start_date,
						'posts_per_page' => '15',
					);
				}
				if($learning_method[3] == "workshops" && get_post_meta($post_id,'workshop_course_start_date',true) > $current_date )
				{
					$important_array_workshop[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'workshop_course_start_date' => $upcoming_workshop_course_start_date,
						'posts_per_page' => '15',
					);
				}
			}
		}
		array_multisort(array_column($important_array_full_time, 'full_time_course_start_date'), $important_array_full_time);
		array_multisort(array_column($important_array_part_time, 'part_time_course_start_date'), $important_array_part_time);
		array_multisort(array_column($important_array_online, 'online_course_start_date'), $important_array_online);
		array_multisort(array_column($important_array_workshop, 'workshop_course_start_date'), $important_array_workshop);
		foreach($important_array_full_time as $value)
		{
			$covert_date = $value['full_time_course_start_date'];
			$convert = date('j M Y',strtotime($covert_date));
			$res_html .= '<a href="'.$value['permalink'].'">
			<div class="col-lg-9 upcoming_course_title">'.$value['post_title'].'</div>
			<div class="col-lg-3 upcoming_course_date">'.$convert.'</div><br>
			</a>';
		}
		foreach($important_array_part_time as $value)
		{
			$covert_date = $value['part_time_course_start_date'];
			$convert = date('j M Y',strtotime($covert_date));
			$res_html .= '<a href="'.$value['permalink'].'">
			<div class="col-lg-9 upcoming_course_title">'.$value['post_title'].'</div>
			<div class="col-lg-3 upcoming_course_date">'.$convert.'</div><br>
			</a>';
		}
		foreach($important_array_online as $value)
		{
			$covert_date = $value['online_course_start_date'];
			$convert = date('j M Y',strtotime($covert_date));
			$res_html .= '<a href="'.$value['permalink'].'">
			<div class="col-lg-9 upcoming_course_title">'.$value['post_title'].'</div>
			<div class="col-lg-3 upcoming_course_date">'.$convert.'</div><br>
			</a>';
		}
		foreach($important_array_workshop as $value)
		{
			$covert_date = $value['workshop_course_start_date'];
			$convert = date('j M Y',strtotime($covert_date));
			$res_html .= '<a href="'.$value['permalink'].'">
			<div class="col-lg-9 upcoming_course_title">'.$value['post_title'].'</div>
			<div class="col-lg-3 upcoming_course_date">'.$convert.'</div><br>
			</a>';
		}
		$res_html .= '</div><br>';
		echo '<div>' .$res_html. '</div>';
		?>
		<a class="see_all_upcoming" href="<?php echo site_url();?>/upcoming-courses">See all our upcoming courses</a>
		<?php
		wp_die();
		wp_reset_postdata();   
		return $res_html;
	}
	else
	{
		?>
		<div id="custom">
			No Course found
		</div>
		<?php
		wp_reset_postdata();
	}
	wp_die();
}


if ( ! function_exists ( 'upcoming_course_page_using_code' ) )
{
	function upcoming_course_page_using_code()
	{
		$course_result ='';
		$course_result .='<div class="learning_method_title" style="margin-top: 15px;margin-right: 10px;">Choose a Learning Method</div>
		<form id="upcoming_course_page_search_form" action="'.site_url().'/wp-admin/admin-ajax.php" class="form-inline wordpress-ajax-form"  method="post">
		<table align="center">
		<select name="learning"  class="search_box" id="method" style="font-weight: 700; border-color: #666;">
		<option value="part_time">PART TIME</option>
		<option value="full_time">FULL TIME</option>
		<option value="online">ONLINE</option>
		<option value="workshops">WORKSHOPS</option>
		</select>
		<input type="hidden" name="action" value="custom_upcoming_course_action">
		<input type="hidden" name="page" value="1">
		<button class="btn btn-default search_button_upcoming_course">Search</button>
		</table>
		</form>';
		$course_result .= '<div id="custom_upcoming_course_page"></div>';
		return $course_result;
	}
}
add_shortcode('upcoming_course_page', 'upcoming_course_page_using_code');

add_action( 'wp_ajax_custom_upcoming_course_action', 'hexagon_upcoming_course_custom_action' );
add_action('wp_ajax_nopriv_custom_upcoming_course_action', 'hexagon_upcoming_course_custom_action');
function hexagon_upcoming_course_custom_action()
{
	global $post;
	//$date = date('Ymd', strtotime('+3 month'));
	$current_date = date('Ymd',strtotime(date('Y-m-d')));
	if($_POST['learning'] == 'full_time')
	{
		$category_data = array(
			"key" => "learning_method",
			"value" => 'full_time',
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning'] == 'part_time')
	{
		$category_data = array(
			"key" => "learning_method",
			"value" => 'part_time',
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning'] == 'online')
	{
		$category_data = array(
			"key" => "learning_method",
			"value" => 'online',
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning'] == 'workshops')
	{
		$category_data = array(
			"key" => "learning_method",
			"value" => 'workshops',
			"compare" => 'LIKE'
		);
	}
	$args = array(
		'post_type'      => 'unicollege_courses',
		'publish_status' => 'published',
		'order'          => 'ASC',
		"meta_query" => array(
			$category_data,
		)
	);
	$query = new WP_Query($args);
	$course_html = '';
	if($query->have_posts()) 
	{
		$course_html .= '<div id="course_data">
		<div style="overflow-x:auto;">
		<table class="custom_table">
		<tbody>
		<tr class="table_heading">
		<th>COURSE</th>
		<th>LEARNING METHOD&nbsp;</th>
		<th class="upcoming_courses_class">DURATION</th>
		<th>START DATE</th>
		<th class="upcoming_courses_class">CLASS TIMES</th>
		</tr>';
		while($query->have_posts())
		{
			$query->the_post();
			$post_id = $post->ID;
			$upcoming_courses = get_post_meta($post_id);
			$permalink = get_permalink($post_id);
			$upcoming_learning_method = $upcoming_courses['learning_method'][0];
			$learning_method = unserialize($upcoming_learning_method);
			$upcoming_full_time_class_times = unserialize($upcoming_courses['full_time_class_times'][0]);
			$upcoming_part_time_class_times = unserialize($upcoming_courses['part_time_class_times'][0]);
			if ($_POST['learning'] == 'select_one')
			{
				if ($learning_method[0] == "part_time" && get_post_meta($post_id,'part_time_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'PART TIME';
					$course_html_upcoming1 = '';
					if($upcoming_courses['part_time_course_duration_years'][0] != '')
					{
						$course_html_upcoming1 .= $upcoming_courses['part_time_course_duration_years'][0].' Years ';
					}
					if($upcoming_courses['part_time_course_duration_months'][0] != '')
					{
						$course_html_upcoming1 .= $upcoming_courses['part_time_course_duration_months'][0].' Months ';
					}
					if($upcoming_courses['part_time_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming1 .= $upcoming_courses['part_time_course_duration_weeks'][0].' Weeks';
					}
					$upcoming_part_time_course_start_date = date('Y-m-d',strtotime($upcoming_courses['part_time_course_start_date'][0]));
					$upcoming_course_part_time_class_times =$upcoming_part_time_class_times[0];
					$important_array_part_time[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming1,
						'part_time_course_start_date' => $upcoming_part_time_course_start_date,
						'part_time_class_times' => $upcoming_course_part_time_class_times
					);
				}
				if ($learning_method[1] == "part_time" && get_post_meta($post_id,'part_time_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'PART TIME';
					$course_html_upcoming2 = '';
					if($upcoming_courses['part_time_course_duration_years'][0] != '')
					{
						$course_html_upcoming2 .= $upcoming_courses['part_time_course_duration_years'][0].' Years ';
					}
					if($upcoming_courses['part_time_course_duration_months'][0] != '')
					{
						$course_html_upcoming2 .= $upcoming_courses['part_time_course_duration_months'][0].' Months ';
					}
					if($upcoming_courses['part_time_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming2 .= $upcoming_courses['part_time_course_duration_weeks'][0].' Weeks';
					}
					$upcoming_part_time_course_start_date = date('Y-m-d',strtotime($upcoming_courses['part_time_course_start_date'][0]));
					$upcoming_course_part_time_class_times =$upcoming_part_time_class_times[0];
					$important_array_part_time[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming2,
						'part_time_course_start_date' => $upcoming_part_time_course_start_date,
						'part_time_class_times' => $upcoming_course_part_time_class_times
					);
				}
			}
			if ($_POST['learning'] == 'full_time')
			{
				if ($learning_method[0] == "full_time" && get_post_meta($post_id,'full_time_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'FULL TIME';
					$course_html_upcoming = '';
					if($upcoming_courses['full_time_course_duration_years'][0] != '')
					{
						$course_html_upcoming .= $upcoming_courses['full_time_course_duration_years'][0].' Years ';
					}
					if($upcoming_courses['full_time_course_duration_months'][0] != '')
					{
						$course_html_upcoming .= $upcoming_courses['full_time_course_duration_months'][0].' Months ';
					}
					if($upcoming_courses['full_time_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming .= $upcoming_courses['full_time_course_duration_weeks'][0].' Weeks';
					}
					$upcoming_full_time_course_start_date = date('Y-m-d',strtotime($upcoming_courses['full_time_course_start_date'][0]));
					$upcoming_course_full_time_class_times =$upcoming_full_time_class_times[0];
					$important_array_full_time[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming,
						'full_time_course_start_date' => $upcoming_full_time_course_start_date,
						'full_time_class_times' => $upcoming_course_full_time_class_times
					);
				}
			}
			if ($_POST['learning'] == 'part_time')
			{
				if ($learning_method[0] == "part_time" && get_post_meta($post_id,'part_time_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'PART TIME';
					$course_html_upcoming1 = '';
					if($upcoming_courses['part_time_course_duration_years'][0] != '')
					{
						$course_html_upcoming1 .= $upcoming_courses['part_time_course_duration_years'][0].' Years ';
					}
					if($upcoming_courses['part_time_course_duration_months'][0] != '')
					{
						$course_html_upcoming1 .= $upcoming_courses['part_time_course_duration_months'][0].' Months ';
					}
					if($upcoming_courses['part_time_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming1 .= $upcoming_courses['part_time_course_duration_weeks'][0].' Weeks';
					}
					$upcoming_part_time_course_start_date = date('Y-m-d',strtotime($upcoming_courses['part_time_course_start_date'][0]));
					$upcoming_course_part_time_class_times =$upcoming_part_time_class_times[0];
					$important_array_part_time[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming1,
						'part_time_course_start_date' => $upcoming_part_time_course_start_date,
						'part_time_class_times' => $upcoming_course_part_time_class_times
					);
				}
				if ($learning_method[1] == "part_time" && get_post_meta($post_id,'part_time_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'PART TIME';
					$course_html_upcoming2 = '';
					if($upcoming_courses['part_time_course_duration_years'][0] != '')
					{
						$course_html_upcoming2 .= $upcoming_courses['part_time_course_duration_years'][0].' Years ';
					}
					if($upcoming_courses['part_time_course_duration_months'][0] != '')
					{
						$course_html_upcoming2 .= $upcoming_courses['part_time_course_duration_months'][0].' Months ';
					}
					if($upcoming_courses['part_time_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming2 .= $upcoming_courses['part_time_course_duration_weeks'][0].' Weeks';
					}
					$upcoming_part_time_course_start_date = date('Y-m-d',strtotime($upcoming_courses['part_time_course_start_date'][0]));
					$upcoming_course_part_time_class_times =$upcoming_part_time_class_times[0];
					$important_array_part_time[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming2,
						'part_time_course_start_date' => $upcoming_part_time_course_start_date,
						'part_time_class_times' => $upcoming_course_part_time_class_times
					);
				}
			}
			if($_POST['learning'] == 'online')
			{
				if ($learning_method[0] == "online" && get_post_meta($post_id,'online_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'ONLINE';
					$course_html_upcoming3 = '';
					if($upcoming_courses['online_course_duration_years'][0] != '')
					{
						$course_html_upcoming3 .= $upcoming_courses['online_course_duration_years'][0].' Years ';
					}
					if($upcoming_courses['online_course_duration_months'][0] != '')
					{
						$course_html_upcoming3 .= $upcoming_courses['online_course_duration_months'][0].' Months ';
					}
					if($upcoming_courses['online_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming3 .= $upcoming_courses['online_course_duration_weeks'][0].' Weeks';
					}
					$upcoming_online_course_start_date = date('Y-m-d',strtotime($upcoming_courses['online_course_start_date'][0]));
					$important_array_online[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming3,
						'online_course_start_date' => $upcoming_online_course_start_date,
					);
				}
				if ($learning_method[1] == "online" && get_post_meta($post_id,'online_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'ONLINE';
					$course_html_upcoming4 = '';
					if($upcoming_courses['online_course_duration_years'][0] != '')
					{
						$course_html_upcoming4 .= $upcoming_courses['online_course_duration_years'][0].' Years ';
					}
					if($upcoming_courses['online_course_duration_months'][0] != '')
					{
						$course_html_upcoming4 .= $upcoming_courses['online_course_duration_months'][0].' Months ';
					}
					if($upcoming_courses['online_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming4 .= $upcoming_courses['online_course_duration_weeks'][0].' Weeks';
					}
					$upcoming_online_course_start_date = date('Y-m-d',strtotime($upcoming_courses['online_course_start_date'][0]));
					$important_array_online[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming4,
						'online_course_start_date' => $upcoming_online_course_start_date,
					);
				}
				if ($learning_method[2] == "online" && get_post_meta($post_id,'online_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'ONLINE';
					$course_html_upcoming5 = '';
					if($upcoming_courses['online_course_duration_years'][0] != '')
					{
						$course_html_upcoming5 .= $upcoming_courses['online_course_duration_years'][0].' Years ';
					}
					if($upcoming_courses['online_course_duration_months'][0] != '')
					{
						$course_html_upcoming5 .= $upcoming_courses['online_course_duration_months'][0].' Months ';
					}
					if($upcoming_courses['online_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming5 .= $upcoming_courses['online_course_duration_weeks'][0].' Weeks';
					}
					$upcoming_online_course_start_date = date('Y-m-d',strtotime($upcoming_courses['online_course_start_date'][0]));
					$important_array_online[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming5,
						'online_course_start_date' => $upcoming_online_course_start_date,
					);
				}
			}
			if($_POST['learning'] == 'workshops')
			{
				if ($learning_method[0] == "workshops" && get_post_meta($post_id,'workshop_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'WORKSHOPS';
					$course_html_upcoming6 = '';
					if($upcoming_courses['workshop_course_duration_months'][0] != '')
					{
						$course_html_upcoming6 .= $upcoming_courses['workshop_course_duration_months'][0].' Half Day';
					}
					if($upcoming_courses['workshop_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming6 .= $upcoming_courses['workshop_course_duration_weeks'][0].' Day';
					}
					$upcoming_workshop_course_start_date = date('Y-m-d',strtotime($upcoming_courses['workshop_course_start_date'][0]));
					$important_array_workshop[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming6,
						'workshop_course_start_date' => $upcoming_workshop_course_start_date,
					);
				} 
				if ($learning_method[1] == "workshops" && get_post_meta($post_id,'workshop_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'WORKSHOPS';
					$course_html_upcoming7 = '';
					if($upcoming_courses['workshop_course_duration_months'][0] != '')
					{
						$course_html_upcoming7 .= $upcoming_courses['workshop_course_duration_months'][0].' Half Day';
					}
					if($upcoming_courses['workshop_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming7 .= $upcoming_courses['workshop_course_duration_weeks'][0].' Day';
					}
					$upcoming_workshop_course_start_date = date('Y-m-d',strtotime($upcoming_courses['workshop_course_start_date'][0]));
					$important_array_workshop[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming7,
						'workshop_course_start_date' => $upcoming_workshop_course_start_date,
					);
				}
				if ($learning_method[2] == "workshops" && get_post_meta($post_id,'workshop_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'WORKSHOPS';
					$course_html_upcoming8 = '';
					if($upcoming_courses['workshop_course_duration_months'][0] != '')
					{
						$course_html_upcoming8 .= $upcoming_courses['workshop_course_duration_months'][0].' Half Day';
					}
					if($upcoming_courses['workshop_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming8 .= $upcoming_courses['workshop_course_duration_weeks'][0].' Day';
					}
					$upcoming_workshop_course_start_date = date('Y-m-d',strtotime($upcoming_courses['workshop_course_start_date'][0]));
					$important_array_workshop[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming8,
						'workshop_course_start_date' => $upcoming_workshop_course_start_date,
					);
				}
				if ($learning_method[3] == "workshops" && get_post_meta($post_id,'workshop_course_start_date',true) > $current_date)
				{
					$post_title = get_the_title($post_id);
					$learning_method_array = 'WORKSHOPS';
					$course_html_upcoming9 = '';
					if($upcoming_courses['workshop_course_duration_months'][0] != '')
					{
						$course_html_upcoming9 .= $upcoming_courses['workshop_course_duration_months'][0].' Half Day';
					}
					if($upcoming_courses['workshop_course_duration_weeks'][0] != '')
					{
						$course_html_upcoming9 .= $upcoming_courses['workshop_course_duration_weeks'][0].' Day';
					}
					$upcoming_workshop_course_start_date = date('Y-m-d',strtotime($upcoming_courses['workshop_course_start_date'][0]));
					$important_array_workshop[] = array(
						'permalink' => $permalink,
						'post_title' => $post_title,
						'learning_method' => $learning_method_array,
						'duration' => $course_html_upcoming9,
						'workshop_course_start_date' => $upcoming_workshop_course_start_date,
					);
				}
			}
		} 
		array_multisort(array_column($important_array_part_time, 'part_time_course_start_date'), $important_array_part_time);
		array_multisort(array_column($important_array_full_time, 'full_time_course_start_date'), $important_array_full_time);
		array_multisort(array_column($important_array_online, 'online_course_start_date'), $important_array_online);
		array_multisort(array_column($important_array_workshop, 'workshop_course_start_date'), $important_array_workshop);
		foreach($important_array_part_time as $value)
		{
			$covert_date = $value['part_time_course_start_date'];
			$convert = date('j M Y',strtotime($covert_date));
			$course_html .= '<tr class="clickable-row">
			<td><a href ="'.$value['permalink'].'">'.$value['post_title'].'</a></td>
			<td><a href ="'.$value['permalink'].'"><span class="part_time">'.$value['learning_method'].'</span></a></td>
			<td class="upcoming_courses_class"><a href ="'.$value['permalink'].'">'.$value['duration'].'</a></td>
			<td><a href ="'.$value['permalink'].'">'.$convert.'</a></td>
			<td class="upcoming_courses_class"><a href ="'.$value['permalink'].'">'.$value['part_time_class_times'].'</a></td>
			</tr>';
		}
		foreach($important_array_full_time as $value)
		{
			$covert_date = $value['full_time_course_start_date'];
			$convert = date('j M Y',strtotime($covert_date));
			$course_html .= '<tr class="clickable-row">
			<td><a href ="'.$value['permalink'].'">'.$value['post_title'].'</a></td>
			<td><a href ="'.$value['permalink'].'"><span class="full_time">'.$value['learning_method'].'</span></a></td>
			<td class="upcoming_courses_class"><a href ="'.$value['permalink'].'">'.$value['duration'].'</a></td>
			<td><a href ="'.$value['permalink'].'">'.$convert.'</a></td>
			<td class="upcoming_courses_class"><a href ="'.$value['permalink'].'">'.$value['full_time_class_times'].'</a></td>
			</tr>';
		}
		foreach($important_array_online as $value)
		{
			$covert_date = $value['online_course_start_date'];
			$convert = date('j M Y',strtotime($covert_date));
			$course_html .= '<tr class="clickable-row">
			<td><a href ="'.$value['permalink'].'">'.$value['post_title'].'</a></td>
			<td><a href ="'.$value['permalink'].'"><span class="online">'.$value['learning_method'].'</span></a></td>
			<td class="upcoming_courses_class"><a href ="'.$value['permalink'].'">'.$value['duration'].'</a></td>
			<td><a href ="'.$value['permalink'].'">'.$convert.'</a></td>
			<td class="upcoming_courses_class"></td>
			</tr>';
		}
		foreach($important_array_workshop as $value)
		{
			$covert_date = $value['workshop_course_start_date'];
			$convert = date('j M Y',strtotime($covert_date));
			$course_html .= '<tr class="clickable-row">
			<td><a href ="'.$value['permalink'].'">'.$value['post_title'].'</a></td>
			<td><a href ="'.$value['permalink'].'"><span class="workshop">'.$value['learning_method'].'</span></a></td>
			<td class="upcoming_courses_class"><a href ="'.$value['permalink'].'">'.$value['duration'].'</a></td>
			<td><a href ="'.$value['permalink'].'">'.$convert.'</a></td>
			<td class="upcoming_courses_class"></td>
			</tr>';
		}
		$course_html .='</tbody>
		</table>
		</div>
		</div><br>';
		echo '<div>'.$course_html. '</div>';
		wp_die();
		wp_reset_postdata();   
		return $course_html;
	}
	else
	{
		?>
		<div id="custom">
			No Course found
		</div>
		<?php
		wp_reset_postdata();
	}
	wp_die();
}

add_action( 'wp_ajax_get_cources_by_learning_method', 'hexagon_get_cources_by_learning_method' );
add_action('wp_ajax_nopriv_get_cources_by_learning_method', 'hexagon_get_cources_by_learning_method');

function hexagon_get_cources_by_learning_method()
{
	global $post;
	if($_POST['learning_method'] == 'full_time')
	{
		$learning_method_data = array(
			"key" => "learning_method",
			"value" => 'full_time',
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning_method'] == 'part_time')
	{
		$learning_method_data = array(
			"key" => "learning_method",
			"value" => 'part_time', 
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning_method'] == 'online')
	{
		$learning_method_data = array(
			"key" => "learning_method",
			"value" => 'online',
			"compare" => 'LIKE'
		);
	}
	elseif($_POST['learning_method'] == 'workshops')
	{
		$learning_method_data = array(
			"key" => "learning_method",
			"value" => 'workshops',
			"compare" => 'LIKE'
		);
	}
	
	$args = array(
		'post_type'      => 'unicollege_courses',
		'publish_status' => 'published',
		'order'          => 'ASC',
		"meta_query" => array(	            
			$learning_method_data,
		)
	);
	$query = new WP_Query($args);

	$course_html = '';
	if($query->have_posts()) 
	{
		$course_html .= '<select name="course" id="course" class="wpcf7-form-control" onchange="get_date()">
													<option>Select One</option>';	
												
		while($query->have_posts())
		{
			$query->the_post();
			$post_id = $post->ID;
			$courses = get_post_meta($post_id);
			$course_learning_method = $courses['learning_method'][0];
			$learning_method = unserialize($course_learning_method);
			$current_date = date('Ymd',strtotime(date('Y-m-d')));
			$full_time_course_start_date = get_post_meta($post_id,'full_time_course_start_date',true);
			$part_time_course_start_date = get_post_meta($post_id,'part_time_course_start_date',true);
			$online_course_start_date = get_post_meta($post_id,'online_course_start_date',true);
			$workshops_course_start_date = get_post_meta($post_id,'workshop_course_start_date',true);


			if($learning_method[0] == 'full_time' && $full_time_course_start_date > $current_date)
			{
				$convert = date('j M Y',strtotime($full_time_course_start_date));
				$full_time_registration_fee = str_replace(" ","",get_post_meta($post_id,'full_time_registration_fee')[0]);
				$full_time_cash_fee = str_replace(" ","",get_post_meta($post_id,'full_time_cash_fee')[0]);
				$full_time_deposit = str_replace(" ","",get_post_meta($post_id,'full_time_deposit')[0]);
				$full_time_registation_cash_fee = $full_time_registration_fee + $full_time_cash_fee;
				$full_time_registation_deposit = $full_time_registration_fee + $full_time_deposit;
				$matric_certificate = get_post_meta($post_id,'matric_certificate_required')[0];

				$full_time_title = $post->post_title;
				
				$course_html .= '<option data-from-dependent="'.$learning_method[0].'" data-matric = "'. $matric_certificate[0].'" data-fee = "'.$full_time_registration_fee.'" data-date= "'. $convert.'" data-cash = "'.$full_time_registation_cash_fee.'" data-deposit = "'.$full_time_registation_deposit.'" data-group ="'.$learning_method[0].'" data-title = "'. $full_time_title.'" value="'.$full_time_title.'">'.$full_time_title.'</option>';
				
			}
			else if($learning_method[0] == 'part_time' && $part_time_course_start_date > $current_date)
			{
				$convert = date('j M Y',strtotime($part_time_course_start_date));
				$part_time_registration_fee = str_replace(" ","",get_post_meta($post_id,'part_time_registration_fee')[0]);
				$part_time_cash_fee = str_replace(" ","",get_post_meta($post_id,'part_time_cash_fee')[0]);
				$part_time_deposit = str_replace(" ","",get_post_meta($post_id,'part_time_deposit')[0]);
				$part_time_registation_cash_fee = $part_time_registration_fee + $part_time_cash_fee;
				$part_time_registation_deposit = $part_time_registration_fee + $part_time_deposit;
				$matric_certificate = get_post_meta($post_id,'matric_certificate_required')[0];

				$part_time_title = $post->post_title;
				
				$course_html .= '<option data-from-dependent="'.$learning_method[0].'" data-matric = "'.$matric_certificate[0].'" data-fee = "'.$part_time_registration_fee.'" data-date= "'.$convert.'" data-cash = "'.$part_time_registation_cash_fee.'" data-deposit = "'. $part_time_registation_deposit.'" data-group ="'.$learning_method[0].'" data-title = "'. $part_time_title.'" value="'.$part_time_title.'">'.$part_time_title.'</option>';
				
			}
			else if($learning_method[1] == 'part_time' && $part_time_course_start_date > $current_date)
			{
				$convert = date('j M Y',strtotime($part_time_course_start_date));
				$part_time_registration_fee = str_replace(" ","",get_post_meta($post_id,'part_time_registration_fee')[0]);
				$part_time_cash_fee = str_replace(" ","",get_post_meta($post_id,'part_time_cash_fee')[0]);
				$part_time_deposit = str_replace(" ","",get_post_meta($post_id,'part_time_deposit')[0]);
				$part_time_registation_cash_fee = $part_time_registration_fee + $part_time_cash_fee;
				$part_time_registation_deposit = $part_time_registration_fee + $part_time_deposit;
				$matric_certificate = get_post_meta($post_id,'matric_certificate_required')[0];

				$part_time_title = $post->post_title;
				
				$course_html .= '<option data-from-dependent="'.$learning_method[1].'" data-matric = "'.$matric_certificate[0].'" data-fee = "'. $part_time_registration_fee.'" data-date= "'. $convert.'" data-cash = "'. $part_time_registation_cash_fee.'" data-deposit = "'. $part_time_registation_deposit.'" data-group ="'. $learning_method[1].'" data-title = "'. $part_time_title.'" value="'. $part_time_title.'">'. $part_time_title.'</option>';
				
			}
			else if($learning_method[0] == 'online' && $online_course_start_date > $current_date)
			{
				$convert = date('j M Y',strtotime($online_course_start_date));
				$online_registration_fee = str_replace(" ","",get_post_meta($post_id,'online_registration_fee')[0]);
				$online_cash_fee = str_replace(" ","",get_post_meta($post_id,'online_cash_fee')[0]);
				$online_deposit = str_replace(" ","",get_post_meta($post_id,'online_deposit')[0]);
				$online_registation_cash_fee = $online_registration_fee + $online_cash_fee;
				$online_registation_deposit = $online_registration_fee + $online_deposit;
				$matric_certificate = get_post_meta($post_id,'matric_certificate_required')[0];

				$online_title = $post->post_title;
				
				$course_html .= '<option data-from-dependent="'. $learning_method[0].'" data-matric = "'. $matric_certificate[0].'" data-fee = "'. $online_registration_fee.'" data-date= "'. $convert.'" data-cash = "'. $online_registation_cash_fee.'" data-deposit = "'. $online_registation_deposit.'" data-group ="'. $learning_method[0].'" data-title = "'. $online_title.'" value="'. $online_title.'">'. $online_title.'</option>';
				
			}
			else if($learning_method[1] == 'online' && $online_course_start_date > $current_date)
			{
				$convert = date('j M Y',strtotime($online_course_start_date));
				$online_registration_fee = str_replace(" ","",get_post_meta($post_id,'online_registration_fee')[0]);
				$online_cash_fee = str_replace(" ","",get_post_meta($post_id,'online_cash_fee')[0]);
				$online_deposit = str_replace(" ","",get_post_meta($post_id,'online_deposit')[0]);
				$online_registation_cash_fee = $online_registration_fee + $online_cash_fee;
				$online_registation_deposit = $online_registration_fee + $online_deposit;
				$matric_certificate = get_post_meta($post_id,'matric_certificate_required')[0];

				$online_title = $post->post_title;
				
				$course_html .= '<option data-from-dependent="'. $learning_method[1].'" data-matric = "'. $matric_certificate[0].'" data-fee = "'. $online_registration_fee.'" data-date= "'. $convert.'" data-cash = "'. $online_registation_cash_fee.'" data-deposit = "'. $online_registation_deposit.'" data-group ="'.$learning_method[1].'" data-title = "'. $online_title.'" value="'.$online_title.'">'.$online_title.'</option>';
				
			}
			else if($learning_method[2] == 'online' && $online_course_start_date > $current_date)
			{
				$convert = date('j M Y',strtotime($online_course_start_date));
				$online_registration_fee = str_replace(" ","",get_post_meta($post_id,'online_registration_fee')[0]);
				$online_cash_fee = str_replace(" ","",get_post_meta($post_id,'online_cash_fee')[0]);
				$online_deposit = str_replace(" ","",get_post_meta($post_id,'online_deposit')[0]);
				$online_registation_cash_fee = $online_registration_fee + $online_cash_fee;
				$online_registation_deposit = $online_registration_fee + $online_deposit;
				$matric_certificate = get_post_meta($post_id,'matric_certificate_required')[0];

				$online_title = $post->post_title;
				
				$course_html .= '<option data-from-dependent="'. $learning_method[2].'" data-matric = "'. $matric_certificate[0].'" data-fee = "'. $online_registration_fee.'" data-date= "'. $convert.'" data-cash = "'. $online_registation_cash_fee.'" data-deposit = "'. $online_registation_deposit.'" data-group ="'. $learning_method[2].'" data-title = "'. $online_title.'" value="'. $online_title.'">'. $online_title.'</option>';
				
			}
			else if($learning_method[0] == 'workshops' && $workshops_course_start_date > $current_date)
			{
				$convert = date('j M Y',strtotime($workshops_course_start_date));
				$workshop_cash_fee = str_replace(" ","",get_post_meta($post_id,'workshop_cash_fee')[0]);
				$matric_certificate = get_post_meta($post_id,'matric_certificate_required')[0];

				$workshop_title = $post->post_title;
				
				$course_html .= '<option data-from-dependent="'. $learning_method[0].'" data-matric = "'. $matric_certificate[0].'" data-date= "'. $convert.'" data-cash = "'. $workshop_cash_fee.'" data-group ="'. $learning_method[0].'" data-title = "'.$workshop_title.'" value="'. $workshop_title.'">'.$workshop_title.'</option>';
				
			}
			else if($learning_method[1] == 'workshops' && $workshops_course_start_date > $current_date)
			{
				$convert = date('j M Y',strtotime($workshops_course_start_date));
				$workshop_cash_fee = str_replace(" ","",get_post_meta($post_id,'workshop_cash_fee')[0]);
				$matric_certificate = get_post_meta($post_id,'matric_certificate_required')[0];

				$workshop_title = $post->post_title;
				
				$course_html .= '<option data-from-dependent="'. $learning_method[1].'" data-matric = "'. $matric_certificate[0].'" data-date= "'. $convert.'" data-cash = "'. $workshop_cash_fee.'" data-group ="'. $learning_method[1].'" data-title = "'.$workshop_title.'" value="'. $workshop_title.'">'.$workshop_title.'</option>';
				
			}
			else if($learning_method[2] == 'workshops' && $workshops_course_start_date > $current_date)
			{
				$convert = date('j M Y',strtotime($workshops_course_start_date));
				$workshop_cash_fee = str_replace(" ","",get_post_meta($post_id,'workshop_cash_fee')[0]);
				$matric_certificate = get_post_meta($post_id,'matric_certificate_required')[0];

				$workshop_title = $post->post_title;
				
				$course_html .= '<option data-from-dependent="'. $learning_method[2].'" data-matric = "'. $matric_certificate[0].'" data-date= "'. $convert.'" data-cash = "'. $workshop_cash_fee.'" data-group ="'. $learning_method[2].'" data-title = "'.$workshop_title.'" value="'. $workshop_title.'">'.$workshop_title.'</option>';
				
			}
			else if($learning_method[3] == 'workshops' && $workshops_course_start_date > $current_date)
			{
				$convert = date('j M Y',strtotime($workshops_course_start_date));
				$workshop_cash_fee = str_replace(" ","",get_post_meta($post_id,'workshop_cash_fee')[0]);
				$matric_certificate = get_post_meta($post_id,'matric_certificate_required')[0];

				$workshop_title = $post->post_title;
				
				$course_html .= '<option data-from-dependent="'. $learning_method[3].'" data-matric = "'. $matric_certificate[0].'" data-date= "'. $convert.'" data-cash = "'. $workshop_cash_fee.'" data-group ="'. $learning_method[3].'" data-title = "'.$workshop_title.'" value="'. $workshop_title.'">'.$workshop_title.'</option>';
				
			}
		}

		$course_html .= '</select>';
		wp_reset_postdata();
	}
	else
	{		
		$course_html = '<select name="course" id="course" class="wpcf7-form-control" onchange="get_date()"><option>Select One</option></select>';	
		
	}	
	echo $course_html;
	wp_die();
}
?>