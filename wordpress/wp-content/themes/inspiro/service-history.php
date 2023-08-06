<?php
/**
 * Template name: Service-History
 */

function my_custom_template_styles() {
    wp_enqueue_style( 'my-custom-template-style', get_template_directory_uri() . '/css/custom.css', array(), '1.0', 'all' );
}
add_action( 'wp_enqueue_scripts', 'my_custom_template_styles' );

get_header();

 ?>

<script>
    const queryString = window.location.search;
    const queryStringWithoutQuestionMark = queryString.substring(1);
    const keyValuePairs = queryStringWithoutQuestionMark.split('&');
    const params = {};
    keyValuePairs.forEach(keyValuePair => {
        const [key, value] = keyValuePair.split('=');
        params[key] = value;
    });
    const callsign = params.callsign;
    document.addEventListener("DOMContentLoaded", function() {
        var entryTitle = document.querySelector(".entry-title");
        if (entryTitle) {
        entryTitle.textContent = callsign.toUpperCase();
        }
    });
</script>

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
                // Get the callsign
                $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $url_parts = parse_url($current_url);
                $query_string = isset($url_parts['query']) ? $url_parts['query'] : '';
                parse_str($query_string, $query_parameters);
                $callsign = isset($query_parameters['callsign']) ? sanitize_text_field($query_parameters['callsign']) : 'NO NAME';

                // Query the rosterview table
                $roster_query = $wpdb->get_results( "
                    SELECT
                        m.nickname AS nickname, 
                        m.avatar AS avatar, 
                        m.capacitaciones AS capacitaciones, 
                        MAX(r.flight_date), DATE_FORMAT(MAX(r.flight_date), '%d-%m-%Y') AS ultimo_vuelo,
                        m.avatar AS avatar, 
                        m.role AS role, 
                        SUM(CASE WHEN r.flight_type = 'Mision' THEN 1 ELSE 0 END) AS misiones, 
                        SUM(CASE WHEN r.flight_type = 'Entrenamiento' THEN 1 ELSE 0 END) AS entrenamientos, 
                        COUNT(r.flight_type) as total,
                        SUM(CASE WHEN r.result = 'RTB' THEN 1 ELSE 0 END) AS rtb,
                        SUM(CASE WHEN r.result = 'KIA' THEN 1 ELSE 0 END) AS kia,
                        SUM(CASE WHEN r.result = 'MIA' THEN 1 ELSE 0 END) AS mia,
                        SUM(r.editor) AS editor,
                        SUM(r.aa) AS aa, 
                        SUM(r.ag) AS ag
                    FROM 
                        members AS m
                        INNER JOIN roster AS r ON m.nickname = r.nickname 
                    WHERE
                        r.aparato <> 'PATO' AND
                        m.role = 'bullfighter' AND
                        m.nickname = '$callsign'
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
                    $capacitaciones = $roster->capacitaciones;
                    $ultimo_vuelo = $roster->ultimo_vuelo;
                    $role = $roster->role;
                    $misiones = $roster->misiones;
                    $entrenamientos = $roster->entrenamientos;
                    $vuelos = $roster->misiones + $roster->entrenamientos;
                    $rtb = $roster->rtb;
                    $kia = $roster->kia;
                    $mia = $roster->mia;
                    $editor = $roster->editor;
                    $aa = $roster->aa;
                    $ag = $roster->ag;

                    $page_id = 468;
                    $permalink = get_permalink($page_id);
                    $link_with_callsign = add_query_arg(array('callsign' => $nickname), $permalink);
                    
                    // Generate the HTML for the card using the data
                    echo '<div class="card">';
                    echo '    <a href='. $link_with_callsign .'><img src="'. $avatar .'" alt="profile-pic" class="profile"></a>';
                    echo '    <h1 class="callsign">' . $nickname . '</h1>';
                    echo '    <p class="role">'. $role .'</p>';
                    echo '    <p class="desc">'. $capacitaciones . '</p>';
                    echo '    <a href='. $link_with_callsign .' class="btn color-button">Ver más</a>';
                    echo '    <hr>';
                    echo '    <div class="card-content">';
                    echo '        <div class="stat-column">';
                    echo '            <span class="btn-stats"><i class="fas fa-bullseye"></i></span>';
                    echo '            <h2 class="title title-stats">'. $vuelos .'</h2>';
                    echo '            <p class="text-stats">Vuelos</p>';
                    echo '        </div>';
                    if ($editor > 0) {
                    echo '        <div class="stat-column">';
                    echo '            <span class="btn-stats"><i class="fas fa-pencil-alt"></i></span>';
                    echo '            <h2 class="title title-stats">'. $editor .'</h2>';
                    echo '            <p class="text-stats">Editor</p>';
                    echo '        </div>';
                    }
                    echo '        <div class="stat-column">';
                    echo '            <span class="btn-stats"><i class="fas fa-fighter-jet"></i></span>';
                    echo '            <h2 class="title title-stats">'. $aa .'</h2>';
                    echo '            <p class="text-stats">A/A Kills</p>';
                    echo '        </div>';
                    echo '        <div class="stat-column">';
                    echo '            <span class="btn-stats"><i class="fas fa-crosshairs"></i></span>';
                    echo '            <h2 class="title title-stats">'. $ag .'</h2>';
                    echo '            <p class="text-stats">A/G Kills</p>';
                    echo '        </div>';
                    echo '    </div>';
                    echo '    <p class="desc lastflight">Último vuelo '. $ultimo_vuelo. '</p>';
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