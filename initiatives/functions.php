<?php
if ( ! defined( 'ABSPATH' ) ) {
    die; // Die if accessed directly
}

//This section takes care of the awful Tribe events priority programming - It inserts and updates ticket meta based on the first time status and the update status of the event on edit post load
add_action( 'load-post.php', 'post_listing_page_advance_mi_manufacturing' );
function post_listing_page_advance_mi_manufacturing() {

      $post_id = $_GET['post'];

	if( get_field('push_to_syndicated_sites', $post_id) == 'yes' ){
    $sub_sites = get_field('event_sub_site_syndication', $post_id);
  
  if( $sub_sites && in_array('advance_mi_manufacturing', $sub_sites) ){
  
    // Connect to Site
    $adv_dbname = 'xxx';
    $adv_dbuser = 'xxx';
    $adv_dbpass = 'xxx';
    $adv_dbhost = 'localhost';
      
      
      // START odtr PUSH
    // Connect and post
    $adv_conn = new mysqli($adv_dbhost, $adv_dbuser, $adv_dbpass, $adv_dbname);
    // Check connection
    if ($adv_conn->connect_error) { die("Connection failed: " . $adv_conn->connect_error); }



// Set up all variables for the post data
$main_post_type = get_post_type($post_id);
$post_date = get_the_date($post_id);
$post_date_gmt = get_post_time($post_id);
$post_content = get_post_field('post_content', $post_id);
$post_content = str_replace ('"', '“', $post_content);
$post_content = str_replace ("'", "‘", $post_content);
$post_title = get_the_title($post_id);
$post_slug = get_post_field( 'post_name', get_post($post_id) );
$post_excerpt = get_the_excerpt($post_id);
$post_modified_date = get_the_modified_date($post_id);
$post_modified_gmt = get_post_modified_time($post_id);
$post_type = get_post_type();
$post_sub_sites = get_field( 'event_sub_site_syndication', $post_id );
$syndicate_source = 'syn_';
$syndicate_source .= $post_id;
$event_start_date = get_field( '_EventStartDate', $post_id );
$event_end_date = get_field( '_EventEndDate', $post_id );
$event_start_date_utc = get_field( '_EventStartDateUTC', $post_id );
$event_end_date_utc = get_field( '_EventStartDateUTC', $post_id );
$event_timezone = get_field( '_EventTimezone', $post_id );
$event_timezone_abbr = get_field( '_EventTimezoneAbbr', $post_id );
$event_cost = get_field( '_EventCost', $post_id );
$event_url = get_field( '_EventURL', $post_id );
$event_registration_url = get_field( 'event_registration_url', $post_id );
$event_duration = get_field( '_EventDuration', $post_id );
    
    $event_venue_name = get_field( 'event_venue_name', $post_id );
    $event_address = get_field( 'event_address', $post_id );
    $event_address_2 = get_field( 'event_address_2', $post_id );
    $event_city = get_field( 'event_city', $post_id );
    $event_state = get_field( 'event_state', $post_id );
    $event_zip = get_field( 'event_zip', $post_id );
            
      
$post_thumbnail = get_the_post_thumbnail_url($post_id, 'large');
$event_cats = get_categories($post_id);
    
    //this is the wp admin edit.php post listing page!

    $event_start_date = get_field( '_EventStartDate', $post_id );
      
    // Website URL
    $website_url = 'https://advancemimanufacturing.org/';


    
  // Build query for all posts on that site that match current post id
  $adv_sql = "SELECT * FROM adv_posts WHERE syndicate_source ='$syndicate_source'";

  //If there is mysql response
  if($result = mysqli_query($adv_conn, $adv_sql)){
      //Are there results?

      if(mysqli_num_rows($result) > 0){
        //While there is rows
          while($row = mysqli_fetch_array($result)){
                  //Update post meta to current
                  $mysql_id = $row['ID'];



    if(get_field('updated_advance_mi_manufacturing',  $post_id) == 'true'){

                      if(get_field('newpost_advance_mi_manufacturing', $post_id) == 'true'){
                        update_field('newpost_advance_mi_manufacturing', 'false' ,  $post_id);
                    
                    // Featured image via URL
                    $adv_sql_thumbnail_url = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL, '$mysql_id', '_knawatfibu_url' ,'$post_thumbnail')";
                      mysqli_query($adv_conn, $adv_sql_thumbnail_url);
                    // Update canonical URLs to avoid duplication
                    update_field('_yoast_wpseo_canonical', 'false' , ' ' . $website_url . '' . $post_slug . '');
                          
                    if(get_post_type($post_id) == 'tribe_events'){
                      $adv_sql_start_date = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL, '$mysql_id', '_EventStartDate' ,'$event_start_date')";
                      mysqli_query($adv_conn, $adv_sql_start_date);

                      $adv_sql_end_date = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL, '$mysql_id', '_EventEndDate' ,'$event_end_date')";
                      mysqli_query($adv_conn, $adv_sql_end_date);

                      $adv_sql_cost = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL, '$mysql_id', '_EventCost' ,'$event_cost')";
                      mysqli_query($adv_conn, $adv_sql_cost);

                      $adv_sql_start_date_utc = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','_EventStartDateUTC','$event_start_date_utc')";
                      mysqli_query($adv_conn, $adv_sql_start_date_utc);

                      $adv_sql_end_date_utc = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','_EventEndDateUTC','$event_end_date_utc')";
                      mysqli_query($adv_conn, $adv_sql_end_date_utc);

                      $adv_sql_event_timezone = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','_EventTimezone','$event_timezone')";
                      mysqli_query($adv_conn, $adv_sql_event_timezone);
                          
                      $adv_sql_event_timezone_abbr = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','_EventTimezoneAbbr','$event_timezone_abbr')";
                      mysqli_query($adv_conn, $adv_sql_event_timezone_abbr);
                          
                      $adv_sql_event_url = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','_EventURL','$event_url')";
                      mysqli_query($adv_conn, $adv_sql_event_url);
                        
                      $adv_sql_event_registration_url = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','event_registration_url','$event_registration_url')";
                      mysqli_query($adv_conn, $adv_sql_event_registration_url);

                      $adv_sql_event_duration = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','_EventDuration','$event_duration')";
                      mysqli_query($adv_conn, $adv_sql_event_duration);
                        
                          
                          // ADDRESS AND VENUE INFO
                    $adv_sql_event_venue_name = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','event_venue_name','$event_venue_name')";
                      mysqli_query($adv_conn, $adv_sql_event_venue_name);
                          
                    $adv_sql_event_address = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','event_address','$event_address')";
                      mysqli_query($adv_conn, $adv_sql_event_address);
                          
                    $adv_sql_event_address_2 = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','event_address_2','$event_address_2')";
                      mysqli_query($adv_conn, $adv_sql_event_address_2);
                          
                    $adv_sql_event_city = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','event_city','$event_city')";
                      mysqli_query($adv_conn, $adv_sql_event_city);
                          
                    $adv_sql_event_state = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','event_state','$event_state')";
                      mysqli_query($adv_conn, $adv_sql_event_state);
                          
                    $adv_sql_event_zip = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','event_state','$event_zip')";
                      mysqli_query($adv_conn, $adv_sql_event_zip);
                          
                        // END ADDRESS AND VENUE INFO
                          
                          
                    $adv_sql_event_address = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','event_address','$event_address')";
                      mysqli_query($adv_conn, $adv_sql_event_address);
                          
                      $adv_sql_post_thumbnail = "INSERT INTO adv_postmeta (meta_id, post_id, meta_key, meta_value) VALUES (NULL,'$mysql_id','fifu_image_url','$post_thumbnail')";
                      mysqli_query($adv_conn, $adv_sql_post_thumbnail);
                        
                    }

                      } else {
                          
                    //Finally, Update the post meta by found post id
                          
                    // Update thumbnail via URL
                      $adv_sql_thumbnail_url = "UPDATE adv_postmeta SET meta_value='$post_thumbnail' WHERE post_id='$mysql_id' AND meta_key='_knawatfibu_url'";
                    mysqli_query($adv_conn, $adv_sql_thumbnail_url);
                    
                    // Set the canonical URL so we don't have SEO duplication
                    update_field('_yoast_wpseo_canonical', 'false' , ' ' . $website_url . '' . $post_slug . '');
                          
                    if(get_post_type($post_id) == 'tribe_events'){

                      //Finally, Update the post meta by found post id
                      $adv_sql_start_date = "UPDATE adv_postmeta SET meta_value='$event_start_date' WHERE post_id='$mysql_id' AND meta_key='_EventStartDate'";
                    mysqli_query($adv_conn, $adv_sql_start_date);
                      
                    $adv_sql_end_date = "UPDATE adv_postmeta SET meta_value='$event_end_date' WHERE post_id='$mysql_id' AND meta_key='_EventEndDate'";
                    mysqli_query($adv_conn, $adv_sql_end_date);
                    
                    $adv_sql_cost = "UPDATE adv_postmeta SET meta_value='$event_cost' WHERE post_id='$mysql_id' AND meta_key='_EventCost'";
                    mysqli_query($adv_conn, $adv_sql_cost);


                    $adv_sql_start_date_utc = "UPDATE adv_postmeta SET meta_value='$event_start_date_utc' WHERE post_id='$mysql_id' AND meta_key='_EventStartDateUTC'";
                    mysqli_query($adv_conn, $adv_sql_start_date_utc);

                    $adv_sql_end_date_utc = "UPDATE adv_postmeta SET meta_value='$event_start_date_utc' WHERE post_id='$mysql_id' AND meta_key='_EventEndDateUTC'";
                    mysqli_query($adv_conn, $adv_sql_end_date_utc);

                    $adv_sql_event_timezone = "UPDATE adv_postmeta SET meta_value='$event_timezone' WHERE post_id='$mysql_id' AND meta_key='_EventTimezone'";
                    mysqli_query($adv_conn, $adv_sql_event_timezone);

                    $adv_sql_event_timezone_abbr = "UPDATE adv_postmeta SET meta_value='$event_timezone_abbr' WHERE post_id='$mysql_id' AND meta_key='_EventTimezoneAbbr'";
                    mysqli_query($adv_conn, $adv_sql_event_timezone_abbr);

                    $adv_sql_event_url = "UPDATE adv_postmeta SET meta_value='$event_url' WHERE post_id='$mysql_id' AND meta_key='_EventURL'";
                    mysqli_query($adv_conn, $adv_sql_event_url);
                        
                    $adv_sql_event_registration_url = "UPDATE adv_postmeta SET meta_value='$event_registration_url' WHERE post_id='$mysql_id' AND meta_key='event_registration_url'";
                    mysqli_query($adv_conn, $adv_sql_event_registration_url);

                    $adv_sql_event_duration = "UPDATE adv_postmeta SET meta_value='$event_duration' WHERE post_id='$mysql_id' AND meta_key='_EventDuration'";
                    mysqli_query($adv_conn, $adv_sql_event_duration);
                          
                        
                    // ADDRESS & VENUE INFO
                    $adv_sql_event_venue_name = "UPDATE adv_postmeta SET meta_value='$event_venue_name' WHERE post_id='$mysql_id' AND meta_key='event_venue_name'";
                    mysqli_query($adv_conn, $adv_sql_event_venue_name);
                          
                    $adv_sql_event_address = "UPDATE adv_postmeta SET meta_value='$event_address' WHERE post_id='$mysql_id' AND meta_key='event_address'";
                    mysqli_query($adv_conn, $adv_sql_event_address);
                          
                    $adv_sql_event_address_2 = "UPDATE adv_postmeta SET meta_value='$event_address_2' WHERE post_id='$mysql_id' AND meta_key='event_address_2'";
                    mysqli_query($adv_conn, $adv_sql_event_address_2);
                          
                    $adv_sql_event_city = "UPDATE adv_postmeta SET meta_value='$event_city' WHERE post_id='$mysql_id' AND meta_key='event_city'";
                    mysqli_query($adv_conn, $adv_sql_event_city);
                          
                    $adv_sql_event_state = "UPDATE adv_postmeta SET meta_value='$event_state' WHERE post_id='$mysql_id' AND meta_key='event_state'";
                    mysqli_query($adv_conn, $adv_sql_event_state);
                          
                    $adv_sql_event_zip = "UPDATE adv_postmeta SET meta_value='$event_zip' WHERE post_id='$mysql_id' AND meta_key='event_zip'";
                    mysqli_query($adv_conn, $adv_sql_event_zip);
                          

                    } // IF IT'S AN EVENT

                      update_field('updated_advance_mi_manufacturing', 'false' ,  $post_id);

                } 
    }





          }
        }

}

  //Close Connection
  $adv_conn->close();

}

}
}




















































add_action('acf/save_post', 'sub_syndication_advance_mi_manufacturing', 20);
function sub_syndication_advance_mi_manufacturing($post_id){
	//Make sure that the post is an event
if(get_post_type($post_id) == 'tribe_events' || get_post_type($post_id) == 'post'){
update_field('updated_advance_mi_manufacturing', 'true' ,  $post_id);

// Set up all variables for the post data
$main_post_type = get_post_type($post_id);
$post_date = get_the_date('Y-m-d H:i:s');
$post_date_gmt = get_post_time('Y-m-d H:i:s');
$post_content = get_post_field('post_content', $post_id);
$post_content = str_replace ('"', '“', $post_content);
$post_content = str_replace ("'", "‘", $post_content);
$post_title = get_the_title($post_id);
$post_slug = get_post_field( 'post_name', get_post($post_id) );
$post_excerpt = get_the_excerpt($post_id);
$post_modified_date = get_the_modified_date($post_id);
$post_modified_gmt = get_post_modified_time($post_id);
$post_type = get_post_type();
$post_sub_sites = get_field( 'event_sub_site_syndication', $post_id );
$syndicate_source = 'syn_';
$syndicate_source .= $post_id;
$event_start_date = get_field( '_EventStartDate', $post_id );
$event_end_date = get_field( '_EventEndDate', $post_id );
$event_start_date_utc = get_field( '_EventStartDateUTC', $post_id );
$event_end_date_utc = get_field( '_EventStartDateUTC', $post_id );
$event_timezone = get_field( '_EventTimezone', $post_id );
$event_timezone_abbr = get_field( '_EventTimezoneAbbr', $post_id );
$event_url = get_field( '_EventURL', $post_id );
$event_duration = get_field( '_EventDuration', $post_id );
$post_thumbnail = get_the_post_thumbnail_url($post_id, 'large');
$event_cats = get_categories($post_id);
    
    
$testmeta = isset( $_POST['_EventStartDate'] );
//update_field('testmeta', $testmeta, $post_id);
// If syndication is turned on
	if( get_field('push_to_syndicated_sites') == 'yes' ){
	$sub_sites = get_field('event_sub_site_syndication');

if( $sub_sites && in_array('advance_mi_manufacturing', $sub_sites) ){

    // Connect to Site
    $adv_dbname = 'xxx';
    $adv_dbuser = 'xxx';
    $adv_dbpass = 'xxx';
    $adv_dbhost = 'localhost';

  
  // START odtr PUSH
    // Connect and post
    $adv_conn = new mysqli($adv_dbhost, $adv_dbuser, $adv_dbpass, $adv_dbname);
    // Check connection
    if ($adv_conn->connect_error) { die("Connection failed: " . $adv_conn->connect_error); }
  
  
  // Build query for all posts on that site that match current post id
  $adv_sql = "SELECT * FROM adv_posts WHERE syndicate_source ='$syndicate_source'";

  //If there is mysql response
  if($result = mysqli_query($adv_conn, $adv_sql)){
      //Are there results?
      if(mysqli_num_rows($result) > 0){
        //While there is rows
          while($row = mysqli_fetch_array($result)){
                  //Update post meta to current
                  $mysql_id = $row['ID'];
  
                  $adv_sql = "UPDATE adv_posts SET post_date='$post_date',post_name='$post_slug', post_date_gmt='$post_date_gmt',post_content='$post_content',post_title='$post_title',post_excerpt='$post_excerpt',post_status='publish',comment_status='open',ping_status='open', post_modified='$post_modified_date',post_modified_gmt='$post_modified_gmt',post_parent='0', menu_order='0',      post_type='$post_type' WHERE syndicate_source ='$syndicate_source'";
                  mysqli_query($adv_conn, $adv_sql);
              
          }
      }
      //If there is no rows
      elseif(mysqli_num_rows($result) == 0){
                  //Make a shiny new post
                  $adv_sql = "INSERT INTO adv_posts (ID, post_author, post_date, post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged, post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order, post_type, post_mime_type, comment_count, syndicate_source) VALUES ('', '', '$post_date', '$post_date_gmt', '$post_content', '$post_title', '$post_excerpt', 'publish', 'open', 'open', '', '$post_slug', '', '', '$post_modified_date', '$post_modified_gmt', '', '0', '', '0', '$post_type', '', '0', '$syndicate_source');";
        mysqli_query($adv_conn, $adv_sql);
                  update_field('newpost_advance_mi_manufacturing', 'true' ,  $post_id);

              //ONLY IF EVENT Then, when there is a post, update the meta
              if(get_post_type($post_id) == 'tribe_events'){
        $adv_sql = "SELECT * FROM adv_posts WHERE syndicate_source ='$syndicate_source'";
        //If there is mysql response
        if($result = mysqli_query($adv_conn, $adv_sql)){
            //Are there results?
            if(mysqli_num_rows($result) > 0){
              //While there is rows
              while($row = mysqli_fetch_array($result)){
                //Update post meta to current
                $mysql_id = $row['ID'];

                $adv_sql = "UPDATE adv_posts SET post_date='$post_date',post_name='$post_slug', post_date_gmt='$post_date_gmt',post_content='$post_content',post_title='$post_title',post_excerpt='$post_excerpt',post_status='publish',comment_status='open',ping_status='open', post_modified='$post_modified_date',post_modified_gmt='$post_modified_gmt',post_parent='0', menu_order='0',      post_type='$post_type' WHERE syndicate_source ='$syndicate_source'";
                mysqli_query($adv_conn, $adv_sql);

            // IF AN EVENT
            if(get_post_type($post_id) == 'tribe_events'){
                      //Finally, Update the post meta by found post id
                      $adv_sql_start_date = "UPDATE adv_postmeta SET meta_value='$event_start_date' WHERE post_id='$mysql_id' AND meta_key='_EventStartDate'";
                                            mysqli_query($adv_conn, $adv_sql_start_date);
            
                
                            } // IF IT'S AN EVENT
        }
              }
            }
              } // ONLY IF EVENT
      }
      // Close result set
      mysqli_free_result($result);
  
  }
  
  
  
  






/////////////////////
//PAST HERE IS THE TAX BLOCK
/////////////////////

  //Create Cats on the pushed site if needed
  if($post_type == 'post'){
    $terms = get_the_terms( $post_id, 'category' );
    $term_name = 'category';

  }else{
    $terms = get_the_terms( $post_id, 'tribe_events_cat' );
    $term_name = 'tribe_events_cat';
  }
  $cat_names_total = '';
  


//Normal Cats
  //Clean relationships
                    //Fetch the Post ID
                    $mysql_tax_create = "SELECT ID FROM adv_posts WHERE post_name = '$post_slug'";
                    if($result = mysqli_query($adv_conn, $mysql_tax_create)){
                      //Are there results?
                      if(mysqli_num_rows($result) > 0){
                        //While there is rows
                        while($row = mysqli_fetch_array($result)){
                      $mysql_post_ID = $row['ID'];
                        }}}
        $mysql_tax_clean = "DELETE FROM adv_term_relationships WHERE object_id = '$mysql_post_ID'";  
        mysqli_query($adv_conn, $mysql_tax_clean);
  
        $term_list = '';
  foreach( $terms as $term ) {
    
    $cat_name = $term->name;
    $cat_slug = $term->slug;
    $cat_taxonomy = $term->taxonomy;
    $cat_description = $term->description;
    $term_list .= $cat_name . ', ';
  
    $adv_sql = "SELECT term_id FROM adv_terms WHERE slug = '$cat_slug'";
  
    //If there is mysql response
    if($result = mysqli_query($adv_conn, $adv_sql)){
        //Are there results?
        if(mysqli_num_rows($result) > 0){
          //While there is rows
            while($row = mysqli_fetch_array($result)){
              $mysql_tax_ID = $row['term_id'];
              //Updates
              $mysql_tax_update = "UPDATE adv_term_taxonomy SET description='$cat_description' WHERE term_id = '$mysql_tax_ID'";
              mysqli_query($adv_conn, $mysql_tax_update);
                    //Link post to category
                    //Fetch the Post ID
                    $mysql_tax_create = "SELECT ID FROM adv_posts WHERE post_name = '$post_slug'";
                    if($result = mysqli_query($adv_conn, $mysql_tax_create)){
                      //Are there results?
                      if(mysqli_num_rows($result) > 0){
                        //While there is rows
                        while($row = mysqli_fetch_array($result)){
                      $mysql_post_ID = $row['ID'];
                        }}}
  
                        //Fetch the category ID by slug
                        $mysql_tax_create = "SELECT term_id FROM adv_terms WHERE slug = '$cat_slug'";
                        if($result = mysqli_query($adv_conn, $mysql_tax_create)){
                          //Are there results?
                          if(mysqli_num_rows($result) > 0){
                            //While there is rows
                            while($row = mysqli_fetch_array($result)){
                          $mysql_new_ID = $row['term_id'];
                            }}}
                
                        //set the relationship post to term
                        $mysql_tax_create = "INSERT INTO adv_term_relationships(object_id, term_taxonomy_id) VALUES ($mysql_post_ID, $mysql_new_ID)";  
                        mysqli_query($adv_conn, $mysql_tax_create);
  
  
  
            }
        }else{
          //Create tax if none
          $mysql_tax_create = "INSERT INTO adv_terms(name, slug) VALUES ('$cat_name', '$cat_slug')";
          mysqli_query($adv_conn, $mysql_tax_create);
          //Snag new ID
          $mysql_tax_create = "SELECT term_id FROM adv_terms WHERE slug = '$cat_slug'";
  
          if($result = mysqli_query($adv_conn, $mysql_tax_create)){
            //Are there results?
            if(mysqli_num_rows($result) > 0){
              //While there is rows
              while($row = mysqli_fetch_array($result)){
            $mysql_new_ID = $row['term_id'];
              }}}
  
          //Update meta
          $mysql_tax_create = "INSERT INTO adv_term_taxonomy(term_taxonomy_id, term_id, taxonomy, description) VALUES ('$mysql_new_ID','$mysql_new_ID','$term_name', '$cat_description')";  
          mysqli_query($adv_conn, $mysql_tax_create);
          //Link post to category
              //Fetch the Post ID
              $mysql_tax_create = "SELECT ID FROM adv_posts WHERE post_name = '$post_slug'";
              if($result = mysqli_query($adv_conn, $mysql_tax_create)){
                //Are there results?
                if(mysqli_num_rows($result) > 0){
                  //While there is rows
                  while($row = mysqli_fetch_array($result)){
                $mysql_post_ID = $row['ID'];
                  }}}
  
                  //set the relationship post to term
                  $mysql_tax_create = "INSERT INTO adv_term_relationships(object_id, term_taxonomy_id) VALUES ($mysql_post_ID, $mysql_new_ID)";  
                  mysqli_query($adv_conn, $mysql_tax_create);
          
  
        }
      }
  }
  
  












 if($post_type == 'tribe_events'){
    $terms = get_the_terms( $post_id, 'taxonomy_college_partners' );
    $term_name = 'taxonomy_college_partners';
  }
  
//taxonomy_college_partners Cats

  
        $term_list = '';
  foreach( $terms as $term ) {

    $cat_name = $term->name;
    $cat_slug = $term->slug;
    $cat_taxonomy = $term->taxonomy;
    $cat_description = $term->description;
    $term_list .= $cat_name . ', ';
  
    $adv_sql = "SELECT term_id FROM adv_terms WHERE slug = '$cat_slug'";
    update_field('taxinfo', $adv_sql, $post_id);

    //If there is mysql response
    if($result = mysqli_query($adv_conn, $adv_sql)){
        //Are there results?
        if(mysqli_num_rows($result) > 0){

          //While there is rows
            while($row = mysqli_fetch_array($result)){
              $mysql_tax_ID = $row['term_id'];
              //Updates
              $mysql_tax_update = "UPDATE adv_term_taxonomy SET taxonomy='taxonomy_college_partners', description='$cat_description' WHERE term_id = '$mysql_tax_ID'";
              update_field('taxinfo', $mysql_tax_update, $post_id);

              mysqli_query($adv_conn, $mysql_tax_update);
                    //Link post to category
                    //Fetch the Post ID
                    $mysql_tax_create = "SELECT ID FROM adv_posts WHERE post_name = '$post_slug'";
                    if($result = mysqli_query($adv_conn, $mysql_tax_create)){
                      //Are there results?
                      if(mysqli_num_rows($result) > 0){
                        //While there is rows
                        while($row = mysqli_fetch_array($result)){
                      $mysql_post_ID = $row['ID'];
                        }}}
  
                        //Fetch the category ID by slug
                        $mysql_tax_create = "SELECT term_id FROM adv_terms WHERE slug = '$cat_slug'";

                        
                        if($result = mysqli_query($adv_conn, $mysql_tax_create)){
                          //Are there results?
                          if(mysqli_num_rows($result) > 0){
                            //While there is rows
                            while($row = mysqli_fetch_array($result)){
                          $mysql_new_ID = $row['term_id'];
                            }}}

                
                        //set the relationship post to term
                        
                        $mysql_tax_create = "INSERT INTO `adv_term_relationships`(`object_id`, `term_taxonomy_id`) VALUES ($mysql_post_ID, $mysql_new_ID)";
                        update_field('taxinfo', $mysql_tax_create, $post_id);

                        mysqli_query($adv_conn, $mysql_tax_create);


  
            }
        }else{
          //Create tax if none
          $mysql_tax_create = "INSERT INTO adv_terms(name, slug) VALUES ('$cat_name', '$cat_slug')";
          mysqli_query($adv_conn, $mysql_tax_create);
          //Snag new ID
          $mysql_tax_create = "SELECT term_id FROM adv_terms WHERE slug = '$cat_slug'";
  
          if($result = mysqli_query($adv_conn, $mysql_tax_create)){
            //Are there results?
            if(mysqli_num_rows($result) > 0){
              //While there is rows
              while($row = mysqli_fetch_array($result)){
            $mysql_new_ID = $row['term_id'];
              }}}
  
          //Update meta
          $mysql_tax_create = "INSERT INTO adv_term_taxonomy(term_taxonomy_id, term_id, taxonomy, description) VALUES ('$mysql_new_ID','$mysql_new_ID','$term_name', '$cat_description')";  
          mysqli_query($adv_conn, $mysql_tax_create);
          //Link post to category
              //Fetch the Post ID
              $mysql_tax_create = "SELECT ID FROM adv_posts WHERE post_name = '$post_slug'";
              if($result = mysqli_query($adv_conn, $mysql_tax_create)){
                //Are there results?
                if(mysqli_num_rows($result) > 0){
                  //While there is rows
                  while($row = mysqli_fetch_array($result)){
                $mysql_post_ID = $row['ID'];
                  }}}
  
                  //set the relationship post to term
                  $mysql_tax_create = "INSERT INTO adv_term_relationships(object_id, term_taxonomy_id) VALUES ($mysql_post_ID, $mysql_new_ID)";  
                  mysqli_query($adv_conn, $mysql_tax_create);
          
  
        }
      }
  }




  if($post_type == 'tribe_events'){
    $terms = get_the_terms( $post_id, 'taxonomy_michigan_works' );
    $term_name = 'taxonomy_michigan_works';
  }
  
//taxonomy_michigan_works

  
        $term_list = '';
  foreach( $terms as $term ) {
    
    $cat_name = $term->name;
    $cat_slug = $term->slug;
    $cat_taxonomy = $term->taxonomy;
    $cat_description = $term->description;
    $term_list .= $cat_name . ', ';
  
    $adv_sql = "SELECT term_id FROM adv_terms WHERE slug = '$cat_slug'";
  
    //If there is mysql response
    if($result = mysqli_query($adv_conn, $adv_sql)){
        //Are there results?
        if(mysqli_num_rows($result) > 0){
          //While there is rows
            while($row = mysqli_fetch_array($result)){
              $mysql_tax_ID = $row['term_id'];
              //Updates
              $mysql_tax_update = "UPDATE adv_term_taxonomy SET taxonomy='taxonomy_michigan_works', description='$cat_description' WHERE term_id = '$mysql_tax_ID'";
              mysqli_query($adv_conn, $mysql_tax_update);
                    //Link post to category
                    //Fetch the Post ID
                    $mysql_tax_create = "SELECT ID FROM adv_posts WHERE post_name = '$post_slug'";
                    if($result = mysqli_query($adv_conn, $mysql_tax_create)){
                      //Are there results?
                      if(mysqli_num_rows($result) > 0){
                        //While there is rows
                        while($row = mysqli_fetch_array($result)){
                      $mysql_post_ID = $row['ID'];
                        }}}
  
                        //Fetch the category ID by slug
                        $mysql_tax_create = "SELECT term_id FROM adv_terms WHERE slug = '$cat_slug'";
                        if($result = mysqli_query($adv_conn, $mysql_tax_create)){
                          //Are there results?
                          if(mysqli_num_rows($result) > 0){
                            //While there is rows
                            while($row = mysqli_fetch_array($result)){
                          $mysql_new_ID = $row['term_id'];
                            }}}
                
                        //set the relationship post to term
                        $mysql_tax_create = "INSERT INTO adv_term_relationships(object_id, term_taxonomy_id) VALUES ($mysql_post_ID, $mysql_new_ID)";  
                        mysqli_query($adv_conn, $mysql_tax_create);
  
  
  
            }
        }else{
          //Create tax if none
          $mysql_tax_create = "INSERT INTO adv_terms(name, slug) VALUES ('$cat_name', '$cat_slug')";
          mysqli_query($adv_conn, $mysql_tax_create);
          //Snag new ID
          $mysql_tax_create = "SELECT term_id FROM adv_terms WHERE slug = '$cat_slug'";
  
          if($result = mysqli_query($adv_conn, $mysql_tax_create)){
            //Are there results?
            if(mysqli_num_rows($result) > 0){
              //While there is rows
              while($row = mysqli_fetch_array($result)){
            $mysql_new_ID = $row['term_id'];
              }}}
  
          //Update meta
          $mysql_tax_create = "INSERT INTO adv_term_taxonomy(term_taxonomy_id, term_id, taxonomy, description) VALUES ('$mysql_new_ID','$mysql_new_ID','$term_name', '$cat_description')";  
          mysqli_query($adv_conn, $mysql_tax_create);
          //Link post to category
              //Fetch the Post ID
              $mysql_tax_create = "SELECT ID FROM adv_posts WHERE post_name = '$post_slug'";
              if($result = mysqli_query($adv_conn, $mysql_tax_create)){
                //Are there results?
                if(mysqli_num_rows($result) > 0){
                  //While there is rows
                  while($row = mysqli_fetch_array($result)){
                $mysql_post_ID = $row['ID'];
                  }}}
  
                  //set the relationship post to term
                  $mysql_tax_create = "INSERT INTO adv_term_relationships(object_id, term_taxonomy_id) VALUES ($mysql_post_ID, $mysql_new_ID)";  
                  mysqli_query($adv_conn, $mysql_tax_create);
          
  
        }
      }
  }

  //Close Connection
  $adv_conn->close();
  
  }
  /* END MI BRIGHT FUTURE *****/
    } // If no syndication options are chosen
} // If post type is not post or event
} // Close the function

?>