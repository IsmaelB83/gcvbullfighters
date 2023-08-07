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
                $pilot_query = $wpdb->get_results( "
                    SELECT
                        m.nickname AS nickname, 
                        m.avatar AS avatar, 
                        m.capacitaciones AS capacitaciones, 
                        MIN(r.flight_date), DATE_FORMAT(MIN(r.flight_date), '%d-%m-%Y') AS primer_vuelo,
                        MAX(r.flight_date), DATE_FORMAT(MAX(r.flight_date), '%d-%m-%Y') AS ultimo_vuelo,
                        m.avatar AS avatar, 
                        m.role AS role, 
                        SUM(CASE WHEN r.flight_type = 'Mision' THEN 1 ELSE 0 END) AS misiones, 
                        SUM(CASE WHEN r.flight_type = 'Entrenamiento' THEN 1 ELSE 0 END) AS entrenamientos, 
                        COUNT(r.flight_type) as total,
                        SUM(CASE WHEN r.result = 'EYECTADO' THEN 1 ELSE 0 END) AS eyectado,
                        SUM(CASE WHEN r.result LIKE 'RTB%' THEN 1 ELSE 0 END) AS rtb,
                        SUM(CASE WHEN r.result = 'KIA' THEN 1 ELSE 0 END) AS kia,
                        SUM(CASE WHEN r.result = 'MIA' THEN 1 ELSE 0 END) AS mia,
                        SUM(CASE WHEN r.result = 'DISCONNECT' THEN 1 ELSE 0 END) AS disconnect,
                        SUM(CASE WHEN r.aparato = 'PATO' THEN 1 ELSE 0 END) AS patito,
                        SUM(r.editor) AS editor,
                        SUM(r.aa) AS aa, 
                        SUM(r.ag) AS ag,
                        SUM(r.aar) AS aar,
                        SUM(r.apontaje) AS apontaje,
                        SUM(r.bonb) AS bonb,
                        SUM(r.naval) AS naval
                    FROM 
                        gcv_zmembers AS m
                        INNER JOIN gcv_zroster AS r ON m.nickname = r.nickname 
                    WHERE
                        m.nickname = '$callsign'" 
                );

                // Get the data for the pilot
                $avatar = $pilot_query[0]->avatar;
                $nickname = $pilot_query[0]->nickname;
                $capacitaciones = explode(" | ", $pilot_query[0]->capacitaciones);
                $primer_vuelo = $pilot_query[0]->primer_vuelo;
                $ultimo_vuelo = $pilot_query[0]->ultimo_vuelo;
                $role = $pilot_query[0]->role;
                $misiones = $pilot_query[0]->misiones;
                $entrenamientos = $pilot_query[0]->entrenamientos;
                $horas_vuelo = ($misiones * 120 + $entrenamientos * 90) / 60;
                $vuelos = $pilot_query[0]->misiones + $pilot_query[0]->entrenamientos;
                $eyectado = $pilot_query[0]->eyectado;
                $rtb = $pilot_query[0]->rtb;
                $kia = $pilot_query[0]->kia;
                $mia = $pilot_query[0]->mia;
                $disconnect = $pilot_query[0]->disconnect;
                $patito = $pilot_query[0]->patito;
                $editor = $pilot_query[0]->editor;
                $aa = $pilot_query[0]->aa;
                $ag = $pilot_query[0]->ag;
                $aar = $pilot_query[0]->aar;
                $apontaje = $pilot_query[0]->apontaje;
                $bonb = $pilot_query[0]->bonb;
                $naval = $pilot_query[0]->naval;
                
                // Query the rosterview table
                $condecoraciones = $wpdb->get_results( "
                SELECT c.descripcion as descripcion, c.imagen as imagen, DATE_FORMAT(mc.fecha, '%d-%m-%Y') as fecha, mc.observaciones as observaciones
                FROM gcv_zmemcond AS mc
                INNER JOIN gcv_zcondecoraciones AS c ON mc.condecoracion = c.condecoracion
                WHERE mc.nickname = '$callsign'
                ORDER BY fecha DESC" 
                );

                // Generate the HTML for the pilot info using the data
                echo '<div class="pilot-info">';
                echo '    <h2 class="title">HOJA DE SERVICIO</h2>';
                echo '    <div class="pilot-main">';
                echo '        <div class="pilot-main-text">';
                echo '            <p class="desc">Callsign<span> '. $callsign .'</span></p>';
                echo '            <p class="desc">Rol<span> '. $role .'</span></p>';
                echo '            <p class="desc">Horas de vuelo oficial<span> '. $horas_vuelo .'</span></p>';
                echo '            <p class="desc">Primer vuelo<span>'. $primer_vuelo .'</span></p>';
                echo '            <p class="desc">Último vuelo<span> '. $ultimo_vuelo .'</span></p>';
                if ($editor > 0) {
                echo '            <p class="desc">Editor<span> '. $editor .' vuelos</span></p>';
                }
                echo '        </div>';
                echo '        <div class="pilot-main-avatar">';
                echo '            <img src="'. $avatar .'" alt="profile-pic" class="profile">';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
                echo '<div class="pilot-info">';
                echo '    <h2 class="title">Capacitaciones</h2>';
                echo '    <div class="pilot-stats pilot-stats--start">';
                foreach ($capacitaciones as $capacitacion) {
                    $sanitizedCapacitacion = str_replace(array('/', '-', '(', ')', ' '), '', $capacitacion);
                echo '        <div class="stat">';
                echo '            <img class="capacitaciones-plane" src="http://localhost/wp-content/uploads/2023/08/'. $sanitizedCapacitacion .'-icon.png" alt="">';
                echo '            <h2 class="title title-stats">'. $capacitacion .'</h2>';
                echo '        </div>';
                }
                echo '    </div>';
                echo '</div>';
                echo '<div class="pilot-info">';
                echo '    <h2 class="title">Vuelos</h2>';
                echo '    <div class="pilot-stats">';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-plane-arrival"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $rtb .'</h2>';
                echo '            <p class="text-stats">RTB</p>  ';
                echo '        </div>';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-skull-crossbones"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $kia .'</h2>';
                echo '            <p class="text-stats">KIA</p>  ';
                echo '        </div>';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-search-location"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $mia .'</h2>';
                echo '            <p class="text-stats">MIA</p>  ';
                echo '        </div>';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-parachute-box"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $eyectado .'</h2>';
                echo '            <p class="text-stats">Eyectado</p>  ';
                echo '        </div>';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-satellite-dish"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $disconnect .'</h2>';
                echo '            <p class="text-stats">DISCONNECT</p>  ';
                echo '        </div>';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-kiwi-bird"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $patito .'</h2>';
                echo '            <p class="text-stats">Patito</p>  ';
                echo '        </div>';
                echo '    </div>';
                echo '</div>';
                echo '<div class="pilot-info">';
                echo '    <h2 class="title">Estadísticas</h2>';
                echo '    <div class="pilot-stats">';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-oil-can"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $aar .'</h2>';
                echo '            <p class="text-stats">AAR</p>  ';
                echo '        </div>';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-water"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $apontaje .'</h2>';
                echo '            <p class="text-stats">Apontaje</p>  ';
                echo '        </div>';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-fighter-jet"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $aa .'</h2>';
                echo '            <p class="text-stats">A/A</p>  ';
                echo '        </div>';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-crosshairs"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $ag .'</h2>';
                echo '            <p class="text-stats">A/G</p>  ';
                echo '        </div>';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-ship"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $naval .'</h2>';
                echo '            <p class="text-stats">Naval</p>  ';
                echo '        </div>';
                echo '        <div class="stat">';
                echo '            <button class="btn-stats"> ';
                echo '                <i class="fas fa-users-slash"></i>';
                echo '            </button>';
                echo '            <h2 class="title title-stats">'. $bonb .'</h2>';
                echo '            <p class="text-stats">BonB</p>  ';
                echo '        </div>';
                echo '    </div>     ';
                echo '</div>';
                if (count($condecoraciones) > 0) {
                echo '<div class="pilot-info">';
                echo '    <h2 class="title">Condecoraciones</h2>';
                echo '    <div class="pilot-stats">';
                    foreach ($condecoraciones as $condecoracion) {
                echo '        <div class="medal">';
                echo '            <img src='. $condecoracion->imagen .' alt="img-condecoracion">';
                echo '            <div class="medal-info">';
                echo '                <p class="medal-info-bold">'. $condecoracion->fecha .'</p>';
                echo '                <p class="medal-info-bold">'. $condecoracion->descripcion .'</p>';
                echo '                <p>'. $condecoracion->observaciones .'</p>';
                echo '            </div>';
                echo '        </div>';
                    }
                echo '    </div>';
                echo '</div>';
                }
            ?>
            
            </div>
		</main><!-- #main -->
                
        <?php if ( ( is_page() && ! inspiro_is_frontpage() ) && ! has_post_thumbnail( get_queried_object_id() ) ) : ?>

	</div><!-- #primary -->
</div><!-- .inner-wrap -->

<?php endif ?>

<?php
get_footer();