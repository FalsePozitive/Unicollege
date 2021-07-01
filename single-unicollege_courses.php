<style>

#contact_links{
	display:block;
margin:10px auto;
padding:10px 0px;
}
.contact_links_button{
	background-color:#363636;
	color:white!important;
	padding:14px 18px;
	font-weight:bold;
	margin-right:20px
}

body
{
	font-size: 13px !important;
}
.faq_custom_class
{
    margin-top: 30px;
}
.accordion 
{
  background-color: #eee;
  color: #000;
  cursor: pointer;
  padding: 12px 25px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 17px;
  transition: 0.4s;
  margin-top: 20px;
  font-weight: 700;
}
.active, .accordion:hover 
{
  background-color: #eee; 
}
.panel 
{
   padding: 15px 10px;
  display: none;
  background-color: white;
  overflow: hidden;
  padding-bottom: 0px;
  box-shadow: none !important;
}
.panel p 
{
    margin-bottom: 5px;
    font-size: 13px;
}
button.accordion:focus 
{
    outline: none;
}
.accordion:after 
{
  content: '+';
  font-size: 17px;
  color: #000;
  float: right;
}
.accordion.active:after 
{
  content: "-";
  font-size: 17px;
}
div#myCarousel 
{
    margin-top: 60px;
    margin-bottom: 30px;
}
.item.active
{
	background-color: #fff;
}
.testimonial_title {
    color: #B50E20;
    text-align: center;
    font-size: 18px;
    text-transform: uppercase;
    font-weight: 700;
    margin-bottom: 15px;
}
.testimonial_description 
{
    text-align: center;
    padding: 0px 35px;
}
.testimonial_name 
{
    text-align: center;
    font: italic normal 600 15px/22px Montserrat;
    margin-top: 8px;
}

a:focus, a:hover {
    text-decoration: none !important;
}
@media only screen 
    and (min-device-width : 320px) 
    and (max-device-width : 480px) 
    and (orientation : portrait) 
    {
	.mean-stick #meanmenu {
	    position: inherit !important;
	}
	header#masthead 
	{
	    margin-top: 78px !important;
	}
	div#meanmenu 
	{
    	margin-top: -219.5px !important;
    }
    div#primary\ desktop 
    {
	    display: none;
	}
}
@media only screen 
    and (min-device-width : 481px) 
{
	div#primary\ mobile 
    {
	    display: none;
	}
}
@media (min-width: 1200px)
{
.container {
    width: 1348px !important;
    padding-right: 20px !important;
    padding-left: 20px !important;
}
</style>


<?php 
/* Template Name: Unicollege Course Detail Page */ 
get_header();
global $post;
$args = array(
            'post_type'      => 'unicollege_courses',
            'publish_status' => 'published',
        );

$post_id = $post->ID;

$learning_method = get_field('learning_method',$post_id, true);
$course_description = get_field('course_description',$post_id);
$entrance_requirements = get_field('entrance_requirements',$post_id);
$who_should_attend = get_field('who_should_attend',$post_id);
$career_opportunities = get_field('career_opportunities',$post_id);
$course_outline = get_field('course_outline',$post_id);
$accreditation_certification = get_field('accreditation_certification',$post_id);
$course_fact_sheet_url = get_field('course_fact_sheet_url',$post_id);
$second_factsheet = get_field('second_factsheet',$post_id);
$fulltime_factsheet = get_field('fulltime_course_fact_sheet_url',$post_id);
$parttime_factsheet = get_field('parttime_course_fact_sheet_url',$post_id);
$full_time_registration_fee = get_field('full_time_registration_fee',$post_id);
$part_time_registration_fee = get_field('part_time_registration_fee',$post_id);
$online_registration_fee = get_field('online_registration_fee',$post_id);
$workshop_registration_fee = get_field('workshop_registration_fee',$post_id);
$full_time_cash_fee = get_field('full_time_cash_fee',$post_id);
$part_time_cash_fee = get_field('part_time_cash_fee',$post_id);
$online_cash_fee = get_field('online_cash_fee',$post_id);
$workshop_cash_fee = get_field('workshop_cash_fee',$post_id);
$full_time_total_terms_fee = get_field('full_time_total_terms_fee',$post_id);
$part_time_total_terms_fee = get_field('part_time_total_terms_fee',$post_id);
$online_total_terms_fee = get_field('online_total_terms_fee',$post_id);
$full_time_deposit = get_field('full_time_deposit',$post_id);
$part_time_deposit = get_field('part_time_deposit',$post_id);
$online_deposit = get_field('online_deposit',$post_id);
$full_time_monthly_instalment = get_field('full_time_monthly_instalment',$post_id);
$part_time_monthly_instalment = get_field('part_time_monthly_instalment',$post_id);
$online_monthly_instalment = get_field('online_monthly_instalment',$post_id);
$full_time_no_of_months = get_field('full_time_no_of_months',$post_id);
$part_time_no_of_months = get_field('part_time_no_of_months',$post_id);
$online_no_of_months = get_field('online_no_of_months',$post_id);
$testimonial = get_field('testimonial',$post_id);

$programme_type_field = get_field_object('programme_type',$post_id);
$values = $programme_type_field['value'];
foreach ($values as $value) 
{
   $programme_type[] = $programme_type_field['choices'][ $value ];
}

$accreditation_field = get_field_object('accreditation',$post_id);
$values = $accreditation_field['value'];
foreach ($values as $value) 
{
   $accreditation[] = $accreditation_field['choices'][ $value ];
}

$full_time_course_start_date = get_field('full_time_course_start_date',$post_id);
$full_time_course_start_date = date('j F Y',strtotime($full_time_course_start_date));

$full_time_course_duration_years =  get_field('full_time_course_duration_years',$post_id);
$full_time_course_duration_months = get_field('full_time_course_duration_months',$post_id);
$full_time_course_duration_weeks = get_field('full_time_course_duration_weeks',$post_id);

$full_time_class_times_field = get_field_object('full_time_class_times',$post_id, true);
$full_time_class_times = $full_time_class_times_field['value'];

$part_time_course_start_date = get_field('part_time_course_start_date',$post_id);
$part_time_course_start_date = date('j F Y',strtotime($part_time_course_start_date));
$part_time_course_duration_years = get_field('part_time_course_duration_years',$post_id);
$part_time_course_duration_months = get_field('part_time_course_duration_months',$post_id);
$part_time_course_duration_weeks = get_field('part_time_course_duration_weeks',$post_id);

$part_time_class_times_field = get_field_object('part_time_class_times',$post_id, true);
$part_time_class_times = $part_time_class_times_field['value'];

$online_course_start_date = get_field('online_course_start_date',$post_id);
$online_course_start_date = date('j F Y',strtotime($online_course_start_date));
$online_course_duration_years = get_field('online_course_duration_years',$post_id);
$online_course_duration_months = get_field('online_course_duration_months',$post_id);
$online_course_duration_weeks = get_field('online_course_duration_weeks',$post_id);

$workshop_course_start_date = get_field('workshop_course_start_date',$post_id);
$workshop_course_start_date = date('j F Y',strtotime($workshop_course_start_date));
$wordshop_course_duration_years = get_field('workshop_course_duration_years',$post_id);
$workshop_course_duration_months = get_field('workshop_course_duration_months',$post_id);
$workshop_course_duration_weeks = get_field('workshop_course_duration_weeks',$post_id);

$iframe = get_field('youtube_link');
preg_match('/src="(.+?)"/', $iframe, $matches);
$src = $matches[1];
$params = array(
    'controls'  => 0,
    'hd'        => 1,
    'autohide'  => 1
);
$new_src = add_query_arg($params, $src);
$iframe = str_replace($src, $new_src, $iframe);
$attributes = 'frameborder="0"';
$iframe = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $iframe);

$currency = get_field('currency',$post_id);
$pricing_indicater = get_field('pricing_indicater',$post_id);


?>




<div id="primary desktop" class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<main id="main" class="site-main">
					<article id="<?php echo $post_id;?>" class="post-<?php echo $post_id;?> page type-page status-publish hentry">
						<div class="entry-content">
							<div class="col-lg-3 custom_class">
								<?php
								if( $learning_method ): ?>
								    <?php 
								    foreach( $learning_method as $learning_methods ): 
								    ?>
								    <?php 
						         		if($learning_methods['value'] == "full_time")
						         		{
						         			echo '<div class="learning_button" style = "background-color:#B50E20; color:#fff;">FULL TIME</div>';
						         		}
						         		elseif($learning_methods['value'] == "part_time")
						         		{
						         			echo '<div class="learning_button" style = "background-color:#322668; color:#fff;">PART TIME</div>';
						         		}
						         		elseif($learning_methods['value'] == "online")
						         		{
						         			echo '<div class="learning_button" style = "background-color:#F35E02; color:#fff;">ONLINE</div>';
						         		}
						         		elseif($learning_methods['value'] == "workshops")
						         		{
						         			echo '<div class="learning_button" style = "background-color:#767676; color:#fff;">WORKSHOPS</div>';
						         		} 
					    			endforeach; 
					    		endif; 
								?>
							</div>
							<div class="col-lg-9 custom_class">
								<?php echo $course_description;?>
							</div>
						</div>
						<?php
						if($course_fact_sheet_url)
						{
						?>
							<div class="entry-content">
							<div class="col-12 download_custom">
								<a href="<?php echo $course_fact_sheet_url;?>" target="_blank">
									<img src="<?php echo site_url();?>/wp-content/uploads/2021/04/download-e1619420576801.png">
										<strong style="color: #3b3b3b; font-size: 14px;     margin-left: 10px;">Download a Course Factsheet</strong>
								</a>
							</div>
						</div>
						<?php
						}
						else
						{
							echo "";
						}
						if( $learning_method )
						{
							foreach( $learning_method as $learning_methods )
							{
								if($learning_methods['value'] == "online")
								{
									if($second_factsheet)
									{
									?>
										<div class="entry-content">
										<div class="col-12 download_custom">
											<a href="<?php echo $second_factsheet;?>" target="_blank">
												<img src="<?php echo site_url();?>/wp-content/uploads/2021/04/download-e1619420576801.png">
													<strong style="color: #3b3b3b; font-size: 14px;     margin-left: 10px;">Download an Online Factsheet</strong>
											</a>
										</div>
									</div>
									<?php
									}
									
								}	//close first if
                                if($learning_methods['value'] == "full_time")
								{
									if($fulltime_factsheet)
									{
									?>
										<div class="entry-content">
										<div class="col-12 download_custom">
											<a href="<?php echo $fulltime_factsheet;?>" target="_blank">
												<img src="<?php echo site_url();?>/wp-content/uploads/2021/04/download-e1619420576801.png">
													<strong style="color: #3b3b3b; font-size: 14px;     margin-left: 10px;">Download a Full-Time Factsheet</strong>
											</a>
										</div>
									</div>
									<?php
									}
									
								}	//close second if
                                if($learning_methods['value'] == "part_time")
								{
									if($parttime_factsheet)
									{
									?>
										<div class="entry-content">
										<div class="col-12 download_custom">
											<a href="<?php echo $parttime_factsheet;?>" target="_blank">
												<img src="<?php echo site_url();?>/wp-content/uploads/2021/04/download-e1619420576801.png">
													<strong style="color: #3b3b3b; font-size: 14px;     margin-left: 10px;">Download a Part-Time Factsheet</strong>
											</a>
										</div>
									</div>
									<?php
									}
									
								}	//close third if
							}
						}
						if($entrance_requirements)
						{
						?>
							<div class="entry-content faq_custom_class">
								<div class="col-12">
									<button class="accordion">Entrance Requirements</button>
									<div class="panel">
									  <?php echo $entrance_requirements;?>
									</div>
								</div>
							</div>
						<?php
						}
						if($who_should_attend)
						{
						?>
							<div class="entry-content">
								<div class="col-12">
									<button class="accordion">Who should attend?</button>
									<div class="panel">
									  <?php echo $who_should_attend;?>
									</div>
								</div>
							</div>
						<?php
						}
						if($career_opportunities)
						{
						?>
							<div class="entry-content">
								<div class="col-12">
									<button class="accordion">Career Opportunities</button>
									<div class="panel">
									  <?php echo $career_opportunities;?>
									</div>
								</div>
							</div>
						<?php
						}
						if($course_outline)
						{
						?>
							<div class="entry-content">
								<div class="col-12">
									<button class="accordion">Course Outline</button>
									<div class="panel">
									  <?php echo $course_outline;?>
									</div>
								</div>
							</div>
						<?php
						}
						if($accreditation_certification)
						{
						?>
							<div class="entry-content">
								<div class="col-12">
									<button class="accordion">Accreditation and Certification</button>
									<div class="panel">
									  <?php echo $accreditation_certification;?>
									</div>
								</div>
							</div>
						<?php
						}
						?>
						
						<div class="entry-content">
							<div class="col-12">
								<div id="myCarousel" class="carousel slide" data-ride="carousel">
								    <div class="carousel-inner">
								    	<?php
								    	if(count(array($testimonial)) > 0)
										{
									    	$i = 0;
									    	?>
									    	
									    	<?php
									    	foreach($testimonial as $testimonials)
									    	{
									    		$i++;
									    		if( $i == 1)
									    		{
									    			$testimonial_loop ='active';
									    		}
									    		else
									    		{
									    			$testimonial_loop ='';
									    		}
												?>
									    		<div class="item <?php echo $testimonial_loop;?>">
									    			<div class="testimonial_title">
									    				<?php
									    				echo $testimonials['testimonial_title'];
									    				?>
									    			</div>
									    			<div class="col-lg-12 testimonial_description">
									    				<div class="col-lg-1 custom_class">
									    					<img src="https://www.unicollege.co.za/wp-content/uploads/2021/05/quotation-grey-1.png" style="width: 25px !important;">
									    				</div>
									    				<div class="col-lg-10 custom_class">
									    				<?php
									    				echo $testimonials['testimonial_description'];
									    				?>
									    				</div>
									    				<div class="col-lg-1 custom_class">
									    					<img src="https://www.unicollege.co.za/wp-content/uploads/2021/05/quotation-grey.png" style="width: 25px !important;">
									    				</div>
									    			</div>
									    			<div class="testimonial_name">
									    				<?php
									    				echo $testimonials['testimonial_name'];
									    				?>
									    			</div>
									    		</div>
									    	<?php
										    }
										}
										?>

								    </div>
								    <ol class="carousel-indicators course-detail">
								    	<?php
								    	if(count(array($testimonial)) > 0)
										{
									    	$i = 0;
									    	?>
									    	
									    	<?php
									    	foreach($testimonial as $testimonials)
									    	{
									    		$i++;
									    		if( $i == 1)
									    		{
									    			$testimonial_loop ='active';
									    		}
									    		else
									    		{
									    			$testimonial_loop ='';
									    		}
												?>
    											<li data-target="#myCarousel" data-slide-to="<?php echo $i;?>" class="active"></li>
    											
  											
  											<?php
  										}}
  										?>
  										</ol>
								</div>
							</div>
						</div>
					</article>
				</main>
			</div>
			<div class="col-lg-4">
					<img src="<?php echo get_the_post_thumbnail_url();?>">
					<!-- <div class="right_sidebar_button">
						<a href="<?php echo site_url()?>/contact">
							<button class="right_first_button">ENQUIRE</button>
						</a>
						<a href="<?php echo site_url()?>/registration">
							<button class="right_secound_button">REGISTER</button>
						</a>
					</div> -->
					<?php
					if($programme_type)
					{
					?>
						<div class="prog_type">
							<span class="accreditation_label">Programme Type:&nbsp;</span> 
							<span class="accreditation_data">
								<?php 
								if($programme_type)
								{
									echo implode(', ', $programme_type);
								}
								?>
							</span>
						</div>
					<?php
					}
					if($accreditation)
					{
					?>
						<div class="accreditation">
							<span class="accreditation_label">Accreditation:&nbsp;</span> 
							<span class="accreditation_data">
								<?php 
								if($accreditation)
								{
									echo implode(', ', $accreditation);
								}
								?>
							</span>
						</div>
					<?php
					}
					if(count($learning_method) != '0')
					{
					?>
						<div class="course_start_dates">
							<p class="title">Course Start Dates</p>
							<?php
							foreach ($learning_method as $learning_methods) 
							{
								if($learning_methods['value'] == 'full_time')
								{
								?>
									<div class="full_time_date">
										<div class="full_time_date_design"></div>
										<div class="full_time_date_information">
											<span class="full_time_date_title">Full Time: </span><span class="description"><?php echo $full_time_course_start_date;?></span><br>
											<?php
											if ($full_time_course_duration_years != ''){
												$full_time_course_duration_years = $full_time_course_duration_years. " Years";
											
										}
										if ($full_time_course_duration_months != ''){
												$full_time_course_duration_months = $full_time_course_duration_months. " Months";
										}
										if ($full_time_course_duration_weeks != ''){
												$full_time_course_duration_weeks = $full_time_course_duration_weeks. " Weeks";}
											?>
											<span class="full_time_date_duration">Duration: </span><span class="description"><?php echo $full_time_course_duration_years." ".$full_time_course_duration_months." ".$full_time_course_duration_weeks;?></span>
											<span class="full_time_date_time">Class Times: </span><span class="description">
												<?php 
												if( $full_time_class_times )
												{
													foreach($full_time_class_times as $full_time_class)
													{
														echo $full_time_class_times_field['choices'][$full_time_class];
													}
												}
												?></span>
										</div>
									</div>
								<?php
								}
								if($learning_methods['value'] == 'part_time')
								{
								?>
									<div class="part_time_date">
										<div class="part_time_date_design"></div>
										<div class="part_time_date_information">
											<span class="part_time_date_title">Part Time: </span><span class="description"><?php echo $part_time_course_start_date;?></span><br>
											<?php
											if ($part_time_course_duration_years != ''){
												$part_time_course_duration_years = $part_time_course_duration_years. " Years";
											
										}
										if ($part_time_course_duration_months != ''){
												$part_time_course_duration_months = $part_time_course_duration_months. " Months";
										}
										if ($part_time_course_duration_weeks != ''){
												$part_time_course_duration_weeks = $part_time_course_duration_weeks. " Weeks";}
											?>
											<span class="part_time_date_duration">Duration: </span><span class="description"><?php echo $part_time_course_duration_years." ".$part_time_course_duration_months." ".$part_time_course_duration_weeks;?></span>
											<span class="part_time_date_time">Class Times: </span><span class="description">
												<?php 
												if( $part_time_class_times )
												{
													foreach($part_time_class_times as $part_time_class)
													{
														echo $part_time_class_times_field['choices'][$part_time_class];
													}
												}
												?></span>
										</div>
									</div>
								<?php
								}
								if($learning_methods['value'] == 'online')
								{
								?>
									<div class="online_date">
										<div class="online_date_design"></div>
										<div class="online_date_information">
											<span class="online_date_title">Online Learning: </span><span class="description"><?php echo $online_course_start_date;?></span><br>
											<?php
											if ($online_course_duration_years != ''){
												$online_course_duration_years = $online_course_duration_years. " Years";
											
										}
										if ($online_course_duration_months != ''){
												$online_course_duration_months = $online_course_duration_months. " Months";
										}
										if ($online_course_duration_weeks != ''){
												$online_course_duration_weeks = $online_course_duration_weeks. " Weeks";}
											?>
											<span class="online_date_duration">Duration: </span><span class="description"><?php echo $online_course_duration_years." ".$online_course_duration_months." ".$online_course_duration_weeks;?></span>


											<!-- <span class="online_date_duration">Duration: </span><span class="description"><?php echo $online_course_duration_months;?> Months</span> -->
										</div>
									</div>
								<?php
							    }
							    if($learning_methods['value'] == 'workshops')
								{
								?>
									<div class="workshop_date">
										<div class="workshop_date_design"></div>
										<div class="workshop_date_information">
											<span class="workshop_date_title">Workshop: </span><span class="description"><?php echo $workshop_course_start_date;?></span><br>
											<?php
											/*if ($workshop_course_duration_years != ''){
												$workshop_course_duration_years = $workshop_course_duration_years. " Years";
											
										}*/
										if ($workshop_course_duration_months != ''){
												$workshop_course_duration_months = $workshop_course_duration_months. " Half Day";
										}
										if ($workshop_course_duration_weeks != ''){
												$workshop_course_duration_weeks = $workshop_course_duration_weeks. " Days";}
											?>
											<span class="workshop_date_duration">Duration: </span><span class="description"><?php echo $workshop_course_duration_months." ".$workshop_course_duration_weeks;?></span>


											<!-- <span class="workshop_date_duration">Duration: </span><span class="description"><?php echo $workshop_course_duration_months;?> Months</span> -->
										</div>
									</div>
								<?php
							    }
							}
							?>
						</div>
					<?php
					}
					?>
					<div class="youtube_video_link">
						<?php echo $iframe;?>
					</div>
			</div>
		</div>
	</div>
</div>

<div id="primary mobile" class="content-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-8" style="padding: 0px;">
				<main id="main" class="site-main">
					<article id="<?php echo $post_id;?>" class="post-<?php echo $post_id;?> page type-page status-publish hentry">
						<div class="entry-content">
							<div class="col-lg-3 custom_class">
								<img src="<?php echo get_the_post_thumbnail_url();?>" style="margin-bottom: 10px;">
							</div>
							<div class="col-lg-9 custom_class">
								<?php echo $course_description;
								if(count($learning_method) != '0')
								{
								?>
									<div class="course_start_dates">
										<p class="title" style="font-size: 18px;margin-top: 25px;margin-bottom: 20px;">Course Start Dates</p>
										<?php
										foreach ($learning_method as $learning_methods) 
										{
											if($learning_methods['value'] == 'full_time')
											{
											?>
												<div class="full_time_date">
													<div class="full_time_date_design"></div>
													<div class="full_time_date_information">
														<span class="full_time_date_title">Full Time: </span><span class="description"><?php echo $full_time_course_start_date;?></span><br>
														<?php
											if ($full_time_course_duration_years != ''){
												$full_time_course_duration_years = $full_time_course_duration_years;
											
										}
										if ($full_time_course_duration_months != ''){
												$full_time_course_duration_months = $full_time_course_duration_months;
										}
										if ($full_time_course_duration_weeks != ''){
												$full_time_course_duration_weeks = $full_time_course_duration_weeks;}
											?>
											<span class="full_time_date_duration">Duration: </span><span class="description"><?php echo $full_time_course_duration_years." ".$full_time_course_duration_months." ".$full_time_course_duration_weeks;?></span>
														<span class="full_time_date_time">Class Times: </span><span class="description">
															<?php 
															if( $full_time_class_times )
															{
																foreach($full_time_class_times as $full_time_class)
																{
																	echo $full_time_class_times_field['choices'][$full_time_class];
																}
															}
															?></span>
													</div>
												</div>
											<?php
											}
											if($learning_methods['value'] == 'part_time')
											{
											?>
												<div class="part_time_date">
													<div class="part_time_date_design"></div>
													<div class="part_time_date_information">
														<span class="part_time_date_title">Part Time: </span><span class="description"><?php echo $part_time_course_start_date;?></span><br>
														<?php
											if ($part_time_course_duration_years != ''){
												$part_time_course_duration_years = $part_time_course_duration_years;
											
										}
										if ($part_time_course_duration_months != ''){
												$part_time_course_duration_months = $part_time_course_duration_months;
										}
										if ($part_time_course_duration_weeks != ''){
												$part_time_course_duration_weeks = $part_time_course_duration_weeks;}
											?>
											<span class="part_time_date_duration">Duration: </span><span class="description"><?php echo $part_time_course_duration_years." ".$part_time_course_duration_months." ".$part_time_course_duration_weeks;?></span>
														<span class="part_time_date_time">Class Times: </span><span class="description">
															<?php 
															if( $part_time_class_times )
															{
																foreach($part_time_class_times as $part_time_class)
																{
																	echo $part_time_class_times_field['choices'][$part_time_class];
																}
															}
															?></span>
													</div>
												</div>
											<?php
											}
											if($learning_methods['value'] == 'online')
											{
											?>
												<div class="online_date">
													<div class="online_date_design"></div>
													<div class="online_date_information">
														<span class="online_date_title">Online Learning: </span><span class="description"><?php echo $online_course_start_date;?></span><br>
														<?php
											if ($online_course_duration_years != ''){
												$online_course_duration_years = $online_course_duration_years;
											
										}
										if ($online_course_duration_months != ''){
												$online_course_duration_months = $online_course_duration_months;
										}
										if ($online_course_duration_weeks != ''){
												$online_course_duration_weeks = $online_course_duration_weeks;}
											?>
											<span class="online_date_duration">Duration: </span><span class="description"><?php echo $online_course_duration_years." ".$online_course_duration_months." ".$online_course_duration_weeks;?></span>
													</div>
												</div>
											<?php
										    }
										    if($learning_methods['value'] == 'workshops')
											{
											?>
												<div class="workshop_date">
													<div class="workshop_date_design"></div>
													<div class="workshop_date_information">
														<span class="workshop_date_title">workshop: </span><span class="description"><?php echo $workshop_course_start_date;?></span><br>
														<?php
											/*if ($workshop_course_duration_years != ''){
												$workshop_course_duration_years = $workshop_course_duration_years. " Years";
											
										}*/
										if ($workshop_course_duration_months != ''){
												$workshop_course_duration_months = $workshop_course_duration_months;
										}
										if ($workshop_course_duration_weeks != ''){
												$workshop_course_duration_weeks = $workshop_course_duration_weeks;}
											?>
											<span class="workshop_date_duration">Duration: </span><span class="description"><?php echo $workshop_course_duration_months." ".$workshop_course_duration_weeks;?></span>

													</div>
												</div>
											<?php
										    }
										}
										?>
									</div>
								<?php
								}
								if($programme_type)
								{
								?>
									<div class="prog_type">
										<span class="accreditation_label">Programme Type:&nbsp;</span> 
										<span class="accreditation_data">
											<?php 
											if($programme_type)
											{
												echo implode(', ', $programme_type);
											}
											?>
										</span>
									</div>
								<?php
								}
								if($accreditation)
								{
								?>
									<div class="accreditation" style="border-bottom: none;">
										<span class="accreditation_label">Accreditation:&nbsp;</span> 
										<span class="accreditation_data">
											<?php 
											if($accreditation)
											{
												echo implode(', ', $accreditation);
											}
											?>
										</span>
									</div>
								<?php
								}
								if($course_fact_sheet_url)
								{
								?>
									<div class="entry-content">
									<div class="col-12 download_custom" style="margin-left: 0px;">
										<a href="<?php echo $course_fact_sheet_url;?>" target="_blank">
											<img src="<?php echo site_url();?>/wp-content/uploads/2021/04/download-e1619420576801.png">
												<strong style="color: #3b3b3b; font-size: 14px;     margin-left: 10px;">Download a Course Factsheet</strong>
										</a>
									</div>
								</div>
								<?php
								}
								if( $learning_method )
								{
									foreach( $learning_method as $learning_methods )
									{
										if($learning_methods['value'] == "online")
										{
											if($second_factsheet)
											{
											?>
												<div class="entry-content">
												<div class="col-12 download_custom"  style="margin-left: 0px;">
													<a href="<?php echo $second_factsheet;?>" target="_blank">
														<img src="<?php echo site_url();?>/wp-content/uploads/2021/04/download-e1619420576801.png">
															<strong style="color: #3b3b3b; font-size: 14px;     margin-left: 10px;">Download an Online Factsheet</strong>
													</a>
												</div>
											</div>
											<?php
											}
                                        }	//close first if
                                        if($learning_methods['value'] == "full_time")
                                        {
                                            if($fulltime_factsheet)
                                            {
                                            ?>
                                                <div class="entry-content">
                                                <div class="col-12 download_custom" style="margin-left: 0px;">
                                                    <a href="<?php echo $fulltime_factsheet;?>" target="_blank">
                                                        <img src="<?php echo site_url();?>/wp-content/uploads/2021/04/download-e1619420576801.png">
                                                            <strong style="color: #3b3b3b; font-size: 14px;     margin-left: 10px;">Download a Full-Time Factsheet</strong>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            
                                        }	//close second if
                                        if($learning_methods['value'] == "part_time")
                                        {
                                            if($parttime_factsheet)
                                            {
                                            ?>
                                                <div class="entry-content">
                                                <div class="col-12 download_custom" style="margin-left: 0px;">
                                                    <a href="<?php echo $parttime_factsheet;?>" target="_blank">
                                                        <img src="<?php echo site_url();?>/wp-content/uploads/2021/04/download-e1619420576801.png">
                                                            <strong style="color: #3b3b3b; font-size: 14px;     margin-left: 10px;">Download a Part-Time Factsheet</strong>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                            }
                                            
                                        }	//close third if
											
									}
								}
								?>
							</div>
                        <div id="contact_links">
                        <a href="/contact" class="contact_links_button">ENQUIRE</a>
                        <a href="/registration" class="contact_links_button">REGISTER</a>
                        </div>            
						</div>
						<?php
						if($entrance_requirements)
						{
						?>
							<div class="entry-content faq_custom_class">
								<div class="col-12">
									<button class="accordion">Entrance Requirements</button>
									<div class="panel">
									  <?php echo $entrance_requirements;?>
									</div>
								</div>
							</div>
						<?php
						}
						if($who_should_attend)
						{
						?>
							<div class="entry-content">
								<div class="col-12">
									<button class="accordion">Who should attend?</button>
									<div class="panel">
									  <?php echo $who_should_attend;?>
									</div>
								</div>
							</div>
						<?php
						}
						if($career_opportunities)
						{
						?>
							<div class="entry-content">
								<div class="col-12">
									<button class="accordion">Career Opportunities</button>
									<div class="panel">
									  <?php echo $career_opportunities;?>
									</div>
								</div>
							</div>
						<?php
						}
						if($course_outline)
						{
						?>
							<div class="entry-content">
								<div class="col-12">
									<button class="accordion">Course Outline</button>
									<div class="panel">
									  <?php echo $course_outline;?>
									</div>
								</div>
							</div>
						<?php
						}
						if($accreditation_certification)
						{
						?>
							<div class="entry-content">
								<div class="col-12">
									<button class="accordion">Accreditation and Certification</button>
									<div class="panel">
									  <?php echo $accreditation_certification;?>
									</div>
								</div>
							</div>
						<?php
						}
						?>
							
						<div class="entry-content">
							<div class="col-12">
								<div id="myCarousel" class="carousel slide" data-ride="carousel">
								    <div class="carousel-inner">
								    	<?php
								    	if(count(array($testimonial)) > 0)
										{
									    	$i = 0;
									    	foreach($testimonial as $testimonials)
									    	{
									    		$i++;
									    		if( $i == 1)
									    		{
									    			$testimonial_loop ='active';
									    		}
									    		else
									    		{
									    			$testimonial_loop ='';
									    		}
												?>
									    		<div class="item <?php echo $testimonial_loop;?>">
									    			<div class="testimonial_title">
									    				<?php
									    				echo $testimonials['testimonial_title'];
									    				?>
									    			</div>
									    			<div class="col-lg-12 testimonial_description">
									    				<div class="col-lg-1 custom_class">
									    					<img src="https://www.unicollege.co.zawp-content/uploads/2021/05/quotation-grey.png" style="width: 25px !important;">
									    				</div>
									    				<div class="col-lg-10 custom_class">
									    				<?php
									    				echo $testimonials['testimonial_description'];
									    				?>
									    				</div>
									    				<div class="col-lg-1 custom_class">
									    					<img src="https://www.unicollege.co.zawp-content/uploads/2021/05/quotations@2x.png" style="width: 25px !important;">
									    				</div>
									    			</div>
									    			<div class="testimonial_name">
									    				<?php
									    				echo $testimonials['testimonial_name'];
									    				?>
									    			</div>
									    		</div>
									    	<?php
										    }
										}
										?>
										<div class="youtube_video_link">
											<?php echo $iframe;?>
										</div>
								    </div>
								</div>
							</div>
						</div>
					</article>
				</main>
			</div>
		</div>
	</div>
</div>




<?php get_footer(); ?>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
