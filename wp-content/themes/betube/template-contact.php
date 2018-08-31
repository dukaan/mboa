<?php
/**
 * Template Name: Contact
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage betube
 * @since betube 1.0
 */

global $redux_demo; 
$contact_email = $redux_demo['contact-email'];
$beTubeContactEmailError = $redux_demo['contact-email-error'];
$beTubeContactNameError = $redux_demo['contact-name-error'];
$beTubeConMsgError = $redux_demo['contact-message-error'];
$beTubeContactThankyou = $redux_demo['contact-thankyou-message'];

$beTubeContactLatitude = $redux_demo['contact-latitude'];
$beTubeContactLongitude = $redux_demo['contact-longitude'];
$beTubeContactZoomLevel = $redux_demo['contact-zoom'];
$beTubeContactTitle = $redux_demo['betube-contact-title'];
$beTubeContactAddress = $redux_demo['betube-contact-address'];
$contactDesc = $redux_demo['contact-description'];
$contactAddress = $redux_demo['contact-address'];
$contactPhone = $redux_demo['contact-phone'];
$contactFax = $redux_demo['contact-fax'];
$beTubeMAPOnOff = $redux_demo['contact-map'];

/*Social Links*/
$facebookLink = $redux_demo['facebook-link'];
$twitterLink = $redux_demo['twitter-link'];
$dribbbleLink = $redux_demo['dribbble-link'];
$flickrLink = $redux_demo['flickr-link'];
$githubLink = $redux_demo['github-link'];
$pinLink = $redux_demo['pinterest-link'];
$youtubeLink = $redux_demo['youtube-link'];
$googleLink = $redux_demo['google-plus-link'];
$linkedinLink = $redux_demo['linkedin-link'];
$instagramLink = $redux_demo['instagram-link'];						
$vimeoLink = $redux_demo['vimeo-link'];
/*Social Links*/

global $nameError;
global $emailError;
global $commentError;
global $subjectError;
global $humanTestError;

//If the form is submitted
if(isset($_POST['submit'])) {
	
		//Check to make sure that the name field is not empty
		if(trim($_POST['contactName']) === '') {
			$nameError = $beTubeContactNameError;
			$hasError = true;
		} elseif(trim($_POST['contactName']) === 'Name*') {
			$nameError = $beTubeContactNameError;
			$hasError = true;
		}	else {
			$name = trim($_POST['contactName']);
		}

		//Check to make sure that the subject field is not empty
		if(trim($_POST['subject']) === '') {
			$subjectError = $classiera_contact_subject_error;
			$hasError = true;
		} elseif(trim($_POST['subject']) === 'Subject*') {
			$subjectError = $classiera_contact_subject_error;
			$hasError = true;
		}	else {
			$subject = trim($_POST['subject']);
		}
		
		//Check to make sure sure that a valid email address is submitted
		if(trim($_POST['email']) === '')  {
			$emailError = $beTubeContactEmailError;
			$hasError = true;
		} else if (!preg_match("/^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$/i", trim($_POST['email']))) {
			$emailError = $beTubeContactEmailError;
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
			
		//Check to make sure comments were entered	
		if(trim($_POST['comments']) === '') {
			$commentError = $beTubeConMsgError;
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}

		//Check to make sure that the human test field is not empty
		if(trim($_POST['humanTest']) != '8') {
			$humanTestError = "Not Human :(";
			$hasError = true;
		} else {

		}
			
		//If there is no error, send the email
		if(!isset($hasError)) {

			$emailTo = $contact_email;
			$subject = $subject;	
			$body = "Nume: $name \n\nEmail: $email \n\nComments: $comments";
			$headers = 'From website <'.$emailTo.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			wp_mail($emailTo, $subject, $body, $headers);

			$emailSent = true;

	}
}

get_header(); 
betube_breadcrumbs();
?>
<?php 
	$page = get_page($post->ID);
	$current_page_id = $page->ID;
?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<section class="registration">
	<div class="row secBg">
		<div class="large-12 columns">
			<div class="login-register-content">
				<div class="row collapse borderBottom">
					<div class="medium-6 large-centered medium-centered">
						<div class="page-heading text-center">
							<h3><?php the_title(); ?></h3>
							<p><?php echo $contactDesc; ?></p>
						</div><!--page-heading-->
					</div><!--medium-6-->
				</div><!--row collapse borderBottom-->
				<div class="row" data-equalizer data-equalize-on="medium" id="test-eq">
					<div class="large-6 columns">
						<h4><?php esc_html_e('Contact Details', 'betube') ?>:</h4>
						<?php if($beTubeMAPOnOff == 1){ ?>
						<div class="map" id="betube-main-map">
							<script type='text/javascript'>function init_map(){var myOptions = {zoom:10,center:new google.maps.LatLng(<?php echo $beTubeContactLatitude;?>,<?php echo $beTubeContactLongitude;?>),mapTypeId: google.maps.MapTypeId.ROADMAP};map = new google.maps.Map(document.getElementById('betube-main-map'), myOptions);marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(<?php echo $beTubeContactLatitude;?>,<?php echo $beTubeContactLongitude;?>)});infowindow = new google.maps.InfoWindow({content:'<strong><?php echo $beTubeContactTitle;?></strong><br><?php echo $beTubeContactAddress; ?><br>'});google.maps.event.addListener(marker, 'click', function(){infowindow.open(map,marker);});infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);</script>
						</div><!--map-->
						<?php }?>
						<div class="user-contacts">
							<div class="row small-up-1 medium-up-2 large-up-2" data-equalizer data-equalize-by-row="true">
								<?php if(!empty($contactAddress)){ ?>
								<div class="column">
									<div class="contact-stats">
										<i class="fa fa-map-marker"></i>
										<h6><?php esc_html_e("Office Address", "betube"); ?></h6>
										<p><?php echo $contactAddress; ?></p>
									</div><!--contact-stats-->
								</div><!--large6 Office Address-->
								<?php } ?>
								<?php if(!empty($contact_email)){ ?>
								<div class="column">
									<div class="contact-stats">
										<i class="fa fa-envelope"></i>
										<h6><?php esc_html_e("Email Adrress", "betube"); ?></h6>
										<p><?php echo $contact_email; ?></p>
									</div>
								</div><!--large6 Email Address-->
								<?php } ?>
								<?php if(!empty($contactPhone)){ ?>
								<div class="column">
									<div class="contact-stats">
										<i class="fa fa-phone"></i>
										<h6><?php esc_html_e("Phone Numers", "betube"); ?></h6>
										<p>
											<strong><?php esc_html_e("Office No", "betube"); ?> :</strong> 
											<?php echo $contactPhone;?> <br/> 
											<?php if(!empty($contactFax)){ ?>
											<strong><?php esc_html_e("Fax No", "betube"); ?>: </strong>
											<?php echo $contactFax; ?> 
											<?php }?>
										</p>
									</div>
								</div><!--large6 Phone Numers-->
								<?php }?>
								<?php 
									$facebookLink = $redux_demo['facebook-link'];
									$twitterLink = $redux_demo['twitter-link'];
									$dribbbleLink = $redux_demo['dribbble-link'];
									$flickrLink = $redux_demo['flickr-link'];
									$githubLink = $redux_demo['github-link'];
									$pinLink = $redux_demo['pinterest-link'];
									$youtubeLink = $redux_demo['youtube-link'];
									$googleLink = $redux_demo['google-plus-link'];
									$linkedinLink = $redux_demo['linkedin-link'];
									$instagramLink = $redux_demo['instagram-link'];						
									$vimeoLink = $redux_demo['vimeo-link'];									
								?>
								<div class="column">
									<div class="contact-stats">
										<i class="fa fa-phone"></i>
										<h6><?php esc_html_e("Social Media", "betube"); ?></h6>
										<p>
											<?php if(!empty($facebookLink)){ ?>
											<a href="<?php echo $facebookLink; ?>" class="secondary-button"><i class="fa fa-facebook" aria-hidden="true"></i></a>
											<?php }?>
											
											<?php if(!empty($twitterLink)){ ?>
											<a href="<?php echo $twitterLink; ?>" class="secondary-button"><i class="fa fa-twitter" aria-hidden="true"></i></a>
											<?php }?>
											
											<?php if(!empty($dribbbleLink)){ ?>
											<a href="<?php echo $dribbbleLink; ?>" class="secondary-button"><i class="fa fa-dribbble" aria-hidden="true"></i></a>
											<?php }?>
											
											<?php if(!empty($flickrLink)){ ?>
											<a href="<?php echo $flickrLink; ?>" class="secondary-button"><i class="fa fa-flickr" aria-hidden="true"></i></a>
											<?php }?>
											
											<?php if(!empty($githubLink)){ ?>
											<a href="<?php echo $githubLink; ?>" class="secondary-button"><i class="fa fa-github-alt" aria-hidden="true"></i></a>
											<?php }?>
											
											<?php if(!empty($pinLink)){ ?>
											<a href="<?php echo $pinLink; ?>" class="secondary-button"><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
											<?php }?>
											
											<?php if(!empty($googleLink)){ ?>
											<a href="<?php echo $googleLink; ?>" class="secondary-button"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
											<?php }?>
											
											<?php if(!empty($linkedinLink)){ ?>
											<a href="<?php echo $linkedinLink; ?>" class="secondary-button"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
											<?php }?>
											
											<?php if(!empty($instagramLink)){ ?>
											<a href="<?php echo $instagramLink; ?>" class="secondary-button"><i class="fa fa-instagram" aria-hidden="true"></i></a>
											<?php }?>
											
											<?php if(!empty($vimeoLink)){ ?>
											<a href="<?php echo $vimeoLink; ?>" class="secondary-button"><i class="fa fa-vimeo" aria-hidden="true"></i></a>
											<?php }?>
											
											<?php if(!empty($youtubeLink)){ ?>
											<a href="<?php echo $youtubeLink; ?>" class="secondary-button"><i class="fa fa-youtube" aria-hidden="true"></i></a>
											<?php }?>
										</p>
									</div>
								</div><!--End Socil Div-->
							</div><!--row-->
						</div><!--user-contacts-->
					</div><!--large6-->
					<div class="large-6 columns">
						<h4><?php esc_html_e("We'd Love to hear from you!", "betube"); ?></h4>
						<div class="register-form">
						<form name="contactForm" action="<?php the_permalink(); ?>" id="contact-form" method="post" class="contactform" data-abide novalidate>
							<div>
								<p>
									<?php if($emailSent == true){ ?>			
									<?php echo $beTubeContactThankyou ?>
									<?php }?>
									
									<?php if($nameError != '') { ?>							
									<?php echo $nameError;?> 
									<?php } ?>
									
									<?php if($emailError != '') { ?>							
									<?php echo $emailError;?>							
									<?php } ?>

									<?php if($subjectError != '') { ?>							
									<?php echo $subjectError;?> 							
									<?php } ?>
									
									<?php if($commentError != '') { ?>							
									<?php echo $commentError;?>							
									<?php } ?>

									<?php if($humanTestError != '') { ?>							
									<?php echo $humanTestError;?>							
									<?php } ?>
								</p>
							</div>
							<div class="input-group">
								<span class="input-group-label"><i class="fa fa-user"></i></span>
								<input class="input-group-field" name="contactName" id="contactName" type="text" placeholder="<?php esc_html_e("Enter Your Name", "betube"); ?>" required>
							</div>
							<div class="input-group">
								<span class="input-group-label"><i class="fa fa-envelope"></i></span>
								<input class="input-group-field" name="email" id="email" type="email" placeholder="<?php esc_html_e("Enter Your Email", "betube"); ?>" required>
							</div>
							<div class="input-group">
								<span class="input-group-label"><i class="fa fa-book"></i></span>
								<input class="input-group-field" type="text" name="subject" id="subject" placeholder="<?php esc_html_e("Enter Your Subject", "betube"); ?>" required>
							</div>
							<textarea required name="comments" id="commentsText" placeholder="<?php esc_html_e("Type Your Message", "betube"); ?>"></textarea>
							<div class="input-group">
								<p><?php esc_html_e("Human test. Please input the result of 5+3=?", "betube"); ?></p>
								<input class="input-group-field" type="text" name="humanTest" id="humanTest" placeholder="<?php esc_html_e("Your Answer", "betube"); ?>" required>
							</div>
							<button class="button expanded" type="submit" name="submit"><?php esc_html_e("Send Message", "betube"); ?></button>
						</form>
						</div>
					</div><!---->
				</div><!--row-test-eq-->
			</div><!--login-register-content-->
		</div><!--large12-->
	</div><!--row-->
</section><!--registration-->
<?php //the_content(); ?>
<?php endwhile; endif; ?>

<?php get_footer(); ?>