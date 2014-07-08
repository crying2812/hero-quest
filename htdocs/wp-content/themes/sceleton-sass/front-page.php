<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
		<article class="<?php post_class(); ?>" id="post-<?php the_ID(); ?>">
			<div class="entry">
				<?php the_content(); ?>
				<a href="#" class="button reset-cards" data-icon="a">Reset</a>
			</div>
			<?php $nonce = wp_create_nonce("hq_ajax_nonce"); ?>
			<div class="current-quest" data-nonce="<?php echo $nonce; ?>">
				<?php
				global $current_user;
				get_currentuserinfo();
				$my_spells = get_field('wizard_spells', 'user_'.$current_user->ID);
				?>
				<?php if($my_spells): ?>
					<?php
					$grouped_spells = array();
					foreach($my_spells as $spell){
						$schools = get_the_terms($spell->ID, 'school');
						if($schools){
							foreach($schools as $school){
								$grouped_spells[$school->name][] = $spell;
							}	
						}
					}
					?>
					<?php $used_cards = get_user_meta($current_user->ID, 'used_cards', true); ?>
					<?php if($grouped_spells): foreach($grouped_spells as $key => $value): ?>
						<h2 class="school-heading"><?php echo $key; ?></h2>
						<div class="columns cards clearfix">
							<?php foreach($value as $spell): ?>
								<?php 
								if($used_cards):
									$used = (in_array($spell->ID, $used_cards) ? 'used' : ''); 
								endif;
								?>
								<div class="three-col card <?php echo $used; ?>" data-id="<?php echo $spell->ID; ?>">
									<div id="f1_container">
										<div id="f1_card" class="shadow">
											<div class="front face">
												<?php $card = get_field('magic_card', $spell->ID); ?>
												<?php if($card): ?>
													<img src="<?php echo $card['url']; ?>" alt="<?php echo get_the_title($spell->ID); ?>" width="<?php echo $card['url']; ?>" height="<?php echo $card['url']; ?>" class="cardimage" />
												<?php endif; ?>
											</div>
											<div class="back face center">
												<img src="<?php echo $GLOBALS['templdir']; ?>/images/card-bg.png" alt="<?php echo get_the_title(); ?>" width="" height="" class="cardbg" />
												<span class="back-text"><?php echo get_the_title($spell->ID); ?></span>
											</div>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					<?php endforeach; endif; ?>
				<?php else: ?>
					<h2>My deepest apologies sir</h2>
					<p>You do not appear to have purchased any spells yet. Make sure you do and then head over to <a href="<?php echo get_permalink(20); ?>">My spells</a> to add them to your quests! I wish you luck!</p>
				<?php endif; ?>
			</div>
		</article>
		
	<?php endwhile; endif; ?>

<?php get_footer(); ?>
