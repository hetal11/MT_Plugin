<?php

// Add custom field
function movie_add_custom_box() {
    $screens = ['movie' ];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'movie_box_id',            // Unique ID
            'Movie Meta Box ',      // title
            'movie_custom_box_html',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
}
add_action( 'add_meta_boxes', 'movie_add_custom_box' );

function movie_custom_box_html( $post ) {
	
	$status = get_post_meta( $post->ID, 'movie_status', true );
    $type = get_post_meta( $post->ID, '_movie_meta_key', true );
	$director = get_post_meta($post->ID, 'movie_director',true);
	$date = get_post_meta($post->ID, 'movie_date',true);
	$duration=get_post_meta($post->ID, 'movie_duration',true);
	$video_url=get_post_meta($post->ID,'video_url',true);

    ?>
    <label for="movie_field">Movie Type</label>
    <select name="movie_field" id="movie_field" class="postbox">
        <option value="">Select Movie Type...</option>
        <option value="action" <?php selected( $type, 'action' ); ?>>Action</option>
        <option value="comedy" <?php selected( $type, 'comedy' ); ?>>Comedy</option>
    </select>
	<br>
	
	<label for="movie_field">Movie Director</label>
	<input type="textbox" name="movie_director" value="<?php echo $director ?>"/>
	<br>
	
	<label for="movie_field">Movie Duration</label>
	<input type="textbox" name="movie_duration" value="<?php echo $duration ?>"/>
	<br>
   
   <label for="movie_field">Movie Status</label>
    <select name="movie_status" id="movie_status" class="postbox">
        <option value="">Select Movie Status...</option>
        <option value="yes" <?php selected( $status, 'yes' ); ?>>Yes</option>
        <option value="no" <?php selected( $status, 'no' ); ?>>No</option>
    </select>
	
	<br>
	<label for="movie_field">Movie Date</label>
    <input type="date" id="datePick" name="movie_date"/>
	
	<br>
	<label for="movie_field">Movie Video URL</label>
	<input type="textbox" name="video_url" value="<?php echo $video_url; ?>"/>
	<br>
    <?php
}

function movie_save_postdata( $post_id ) {
    if ( array_key_exists( 'movie_field', $_POST ) ) {
        update_post_meta(
		    $post_id,
            '_movie_meta_key',
            $_POST['movie_field']
        );
    }
	  if ( array_key_exists( 'movie_status', $_POST ) ) {
        update_post_meta(
		    $post_id,
            'movie_status',
            $_POST['movie_status']
        );
    }
	
    update_post_meta($post_id, 'movie_director',  sanitize_text_field($_POST['movie_director']));
	update_post_meta($post_id, 'movie_duration', sanitize_text_field( $_REQUEST['movie_duration'] ));
	update_post_meta($post_id, 'movie_date', sanitize_text_field( $_REQUEST['movie_date'] ));
	
	if( isset( $_POST[ 'video_url' ] ) ) {
		update_post_meta( $post_id, 'video_url', $_POST[ 'video_url' ] );
	}
}
add_action( 'save_post', 'movie_save_postdata' );
?>
