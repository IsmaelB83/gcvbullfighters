<?php
/**
 * Template name: ROSTERVIEW
 */

function my_custom_template_styles() {
    wp_enqueue_style( 'my-custom-template-style', get_template_directory_uri() . '/css/rosterview.css', array(), '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'my_custom_template_styles' );

get_header(); ?>

<?php if ( ( is_page() && ! inspiro_is_frontpage() ) && ! has_post_thumbnail( get_queried_object_id() ) ) : ?>

<div class="inner-wrap">
	<div id="primary" class="content-area">

<?php endif ?>
        <main id="main" class="site-main" role="main">
			<?php
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/page/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			endwhile; // End the loop.
			?>

            <div class="roster">

            <?php
                // Get the database connection
                global $wpdb;

                // Query the rosterview table
                $roster_query = $wpdb->get_results( "
                    SELECT 
                        m.nickname AS nickname, 
                        m.avatar AS avatar, 
                        m.role AS role, 
                        SUM(CASE WHEN r.flight_type = 'Mision' THEN 1 ELSE 0 END) AS misiones, 
                        SUM(CASE WHEN r.flight_type = 'Entrenamiento' THEN 1 ELSE 0 END) AS entrenamientos, 
                        COUNT(r.flight_type) as total,
                        SUM(CASE WHEN r.result = 'RTB' THEN 1 ELSE 0 END) AS rtb,
                        SUM(CASE WHEN r.result = 'KIA' THEN 1 ELSE 0 END) AS kia,
                        SUM(CASE WHEN r.result = 'MIA' THEN 1 ELSE 0 END) AS mia,
                        SUM(r.aa) AS aa, 
                        SUM(r.ag) AS ag
                    FROM 
                        members AS m
                        INNER JOIN roster AS r ON m.nickname = r.nickname 
                    GROUP BY 
                        m.nickname
                    ORDER BY
                        total DESC" 
                );

                // Generate the HTML for each card
                foreach ( $roster_query as $roster ) {
                    // Get the data for each card
                    $avatar = $roster->avatar;
                    $nickname = $roster->nickname;
                    $role = $roster->role;
                    $misiones = $roster->misiones;
                    $entrenamientos = $roster->entrenamientos;
                    $rtb = $roster->rtb;
                    $kia = $roster->kia;
                    $mia = $roster->mia;

                    // Generate the HTML for the card using the data
                    echo '<div class="roster">';
                    echo '<div class="card roster-card">';
                    echo '<div class="avatar">';
                    echo '<img src="' . $avatar . '" alt="Avatar">';
                    echo '<div class="overlay">';
                    echo '<p>Ver más...</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<h2>' . $nickname . '</h2>';
                    echo '<p class="role role-'. $role .'">' . $role . '</p>';
                    echo '<p><i class="fas fa-crosshairs stats-icon stats-icon--blue"></i><span>Misiones:</span> ' . $misiones . '</p>';
                    echo '<p><i class="fas fa-crosshairs stats-icon stats-icon--blue"></i><span>Entrenamientos:</span> ' . $entrenamientos . '</p>';
                    echo '<p><i class="fas fa-fighter-jet stats-icon stats-icon--red"></i><span>RTB:</span> ' . $rtb. '</p>';
                    echo '<p><i class="fas fa-bullseye stats-icon stats-icon--red"></i><span>KIA:</span> ' . $kia . '</p>';
                    echo '<p><i class="fas fa-bullseye stats-icon stats-icon--red"></i><span>MIA:</span> ' . $mia . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            ?>
            
		</main><!-- #main -->
                
        <?php if ( ( is_page() && ! inspiro_is_frontpage() ) && ! has_post_thumbnail( get_queried_object_id() ) ) : ?>

	</div><!-- #primary -->
</div><!-- .inner-wrap -->

<?php endif ?>

<?php
get_footer();

/** <div class="card">
 *      <div class="avatar">
 *          <img src="https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares_paco.webp" alt="Avatar">
 *          <div class="overlay">
 *              <p>Ver más...</p>
 *          </div>
 *      </div>
 *      <h2>Paco</h2>
 *      <p class="role role-bullfighter">Bullfighter</p>
 *      <p><i class="fas fa-clock stats-icon stats-icon--green"></i><span>Flight Time:</span> 15 hours</p>
 *      <p><i class="fas fa-crosshairs stats-icon stats-icon--blue"></i><span>Missions:</span> 22</p>
 *      <p><i class="fas fa-fighter-jet stats-icon stats-icon--red"></i><span>A/A Kills:</span> 10</p>
 *      <p><i class="fas fa-bullseye stats-icon stats-icon--red"></i><span>A/G Kills:</span> 5</p>
 *      </div>
 * </div>-->
**/