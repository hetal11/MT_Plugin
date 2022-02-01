<?php
 /*Template Name: New Template
 */

get_header(); ?>
<div id="primary">
	<div id="content" role="main">
	<center>
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title(); ?>
				<!-- Display featured image in right-aligned floating div -->
				<div style=" margin: 10px">
					<?php the_post_thumbnail( array( 500, 500 ) ); ?>
				</div>
    
			</header>
            <?php the_content(); ?>
			<br>
			 <?php 
			 
			  $status = get_post_meta( $post->ID, 'movie_status', true );
              $type = get_post_meta( $post->ID, '_movie_meta_key', true );
	          $director = get_post_meta($post->ID, 'movie_director',true);
	          $date = get_post_meta($post->ID, 'movie_date',true);
	          $duration=get_post_meta($post->ID, 'movie_duration',true);
			  	$video_url=get_post_meta($post->ID,'video_url',true);
			?>
			<div><b>Movie Details</b></div>
			<br>
			 <?php if($type!='')
			{ ?>
			<div>
			 <lable><b>Type : </b></lable><?php echo $type;?>
			 <br>
			 </div>
			<?php }  if($director!=''){ ?>
			 <div>
			 <lable><b>Director : </b></lable><?php echo $director;?>
			 <br>
			 </div>
			 <?php }  if($status!=''){ ?>
			 
			 <div>
			 <lable><b>Status : </b></lable><?php echo $status;?>
			 <br>
			 </div>
			  <?php }  if($duration!=''){ ?>
			  <div>
			 <lable><b>Duration : </b></lable><?php echo $duration;?>
			 <br>
			 </div>
			  <?php }  if($date!=''){ ?>
			 <div>
			 <lable><b>Date : </b></lable><?php echo $date;?>
			 <br>
			 </div>
			  <?php } ?>
		</article>
    
   <div id="vidBox">
        <div id="videCont">
		<?php
		if($video_url!='')
		{
		?>
		<video autoplay id="v1" loop controls>
            <source src=<?php echo $video;?> type="video/mp4">
            <source src=<?php echo $video;?> type="video/ogg">
        </video>
		<?php } ?>
		 </div>
        </div>
	</center>
	<hr>
	
	</div>
</div>

<?php get_footer(); ?>