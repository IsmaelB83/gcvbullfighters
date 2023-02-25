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
                        SUM(r.aa) AS aa, 
                        SUM(r.ag) AS ag
                    FROM 
                        members AS m
                        INNER JOIN roster AS r ON m.nickname = r.nickname 
                    WHERE
                        r.aparato <> 'PATO'
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
                    $aa = $roster->aa;
                    $ag = $roster->ag;

                    // Generate the HTML for the card using the data
                    echo '<div class="card">';
                    echo '    <img src="'. $avatar .'" alt="profile-pic" class="profile">';
                    echo '    <h1 class="callsign">' . $nickname . '</h1>';
                    echo '    <p class="role">'. $role .'</p>';
                    echo '    <p class="desc">'. $capacitaciones . '</p>';
                    echo '    <button class="btn color-button">Ver más</button>                ';
                    echo '    <hr>';
                    echo '    <div class="card-content">';
                    echo '        <div class="stat-column">';
                    echo '            <button class="btn-stats"> <i class="fas fa-bullseye"></i></button>';
                    echo '            <h2 class="title title-stats">'. $vuelos .'</h2>';
                    echo '            <p class="text-stats">Vuelos</p>';
                    echo '        </div>';
                    echo '        <div class="stat-column">';
                    echo '            <button class="btn-stats"><i class="fas fa-fighter-jet"></i></button>';
                    echo '            <h2 class="title title-stats">'. $aa .'</h2>';
                    echo '            <p class="text-stats">A/A Kills</p>';
                    echo '        </div>';
                    echo '        <div class="stat-column">';
                    echo '            <button class="btn-stats"><i class="fas fa-crosshairs"></i></button>';
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

/* <div class="card card-bullfighter">
    <img src="https://gcvbullfighters.com/wp-content/uploads/2023/02/avatares-paco.webp" alt="profile-pic" class="profile">
    <h1 class="title text-bullfighter">PACO</h1>
    <p class="role">BULLFIGHTER</p>
    <div class="desc">
        <p>F/A-18C | F-16C | F-14A/B (P)</p>
    </div>
    <button class="btn color-button">Ver más</button>                
    <hr>
    <div class="card-content">
        <div class="stat-column">
            <button class="btn-stats"> <i class="fas fa-crosshairs fa-2x"></i></button>
            <h2 class="title text-bullfighter">16</h2>
            <p class="text-stats">Vuelos</p>
        </div>
        <div class="stat-column">
            <button class="btn-stats"><i class="fas fa-fighter-jet fa-2x"></i></button>
            <h2 class="title text-bullfighter">12</h2>
            <p class="text-stats">A/A Kills</p>
        </div>
        <div class="stat-column">
            <button class="btn-stats"><i class="fas fa-bullseye fa-2x"></i></button>
            <h2 class="title text-bullfighter">12</h2>
            <p class="text-stats">A/G Kills</p>
        </div>
    </div>
    <div class="desc">
        <p>Último vuelo 12/02/2022</p>
    </div>
</div> */