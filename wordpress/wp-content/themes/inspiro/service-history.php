<?php
/**
 * Template name: Service-History
 */

function my_custom_template_styles() {
    wp_enqueue_style( 'my-custom-template-style', get_template_directory_uri() . '/css/service-history.css', array(), '1.0', 'all' );
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
        <div class="roster">
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
                        m.nickname = '$callsign'" 
                );

                // Get the data for the pilot
                $avatar = $roster_query[0]->avatar;
                $nickname = $roster_query[0]->nickname;
                $capacitaciones = $roster_query[0]->capacitaciones;
                $ultimo_vuelo = $roster_query[0]->ultimo_vuelo;
                $role = $roster_query[0]->role;
                $misiones = $roster_query[0]->misiones;
                $entrenamientos = $roster_query[0]->entrenamientos;
                $vuelos = $roster_query[0]->misiones + $roster_query[0]->entrenamientos;
                $rtb = $roster_query[0]->rtb;
                $kia = $roster_query[0]->kia;
                $mia = $roster_query[0]->mia;
                $editor = $roster_query[0]->editor;
                $aa = $roster_query[0]->aa;
                $ag = $roster_query[0]->ag;
                    
                // Generate the HTML for the pilot info using the data
                echo '<div class="pilot-main">';
                echo '    <div class="pilot-main-avatar">';
                echo '        <img src="../../images/avatars/avatares_macaci.webp" alt="profile-pic" class="profile">';
                echo '        <h1 class="callsign">Macaci</h1>    ';
                echo '        <p class="role">bullfighter</p>     ';
                echo '    </div>';
                echo '    <div class="pilot-main-info">';
                echo '        <p class="desc">Miembro desde<span> 01/11/2022</span></p>';
                echo '        <p class="desc">Último vuelo<span> 01/07/2023</span></p>';
                echo '        <p class="desc">Capacitaciones</p>';
                echo '        <div class="capacitaciones">';
                echo '            <div class="capacitaciones-plane">';
                echo '                <img src="../../images/icons-v2/f18-icon.png" alt="">';
                echo '            </div>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
                echo '<div class="pilot-stats">';
                echo '    <h2 class="title">Vuelos</h2>';
                echo '    <div class="stats">';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-plane-arrival"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">RTB</p>  ';
                echo '        </div>';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-parachute-box"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">Eyectado</p>  ';
                echo '        </div>';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-search-location"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">MIA</p>  ';
                echo '        </div>';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-skull-crossbones"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">KIA</p>  ';
                echo '        </div>';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-kiwi-bird"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">Patito</p>  ';
                echo '        </div>';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-pencil-alt"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">Editor</p>  ';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
                echo '<div class="pilot-stats">';
                echo '    <h2 class="title">Estadísticas</h2>';
                echo '    <div class="stats">';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-oil-can"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">AAR</p>  ';
                echo '        </div>';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-water"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">Apontaje</p>  ';
                echo '        </div>';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-fighter-jet"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">A/A</p>  ';
                echo '        </div>';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-crosshairs"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">A/G</p>  ';
                echo '        </div>';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-ship"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">Naval</p>  ';
                echo '        </div>';
                echo '        <div class="stat-column">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-users-slash"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">30</h2>';
                echo '            <p class="text-stats">BonB</p>  ';
                echo '        </div>';
                echo '    </div>     ';
                echo '</div>';
                echo '<div class="pilot-stats">';
                echo '    <h2 class="title">Condecoraciones</h2>';
                echo '    <div class="stats">';
                echo '        <div class="medal">';
                echo '            <img src="../../images/medals/Medalla_01.jpg" alt="">';
                echo '            <div class="medal-info">';
                echo '                <p>14/04/2023</p>';
                echo '                <p>Medalla al honor</p>';
                echo '                <p>Obtenida por salvar a 3 pilotos en combate</p>';
                echo '            </div>';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
            ?>
            
            </div>
		</main><!-- #main -->
                
        <?php if ( ( is_page() && ! inspiro_is_frontpage() ) && ! has_post_thumbnail( get_queried_object_id() ) ) : ?>

	</div><!-- #primary -->
</div><!-- .inner-wrap -->

<?php endif ?>

<?php
get_footer();