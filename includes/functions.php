<?php

// Funzione per mostrare gli ultimi post di un tipo di post personalizzato
function show_last_cpt($atts)
{
    $atts = shortcode_atts(array(
        'tipo' => 'post',
        'numero' => 5,
        'show_thumbnail' => true,
        'thumbnail_size' => 'thumbnail',
    ), $atts, 'last_cpt');

    $args = array(
        'post_type' => $atts['tipo'],
        'posts_per_page' => $atts['numero'],
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $output = '<ul class="last-cpt-list">';
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<li>';
            if ($atts['show_thumbnail'] && has_post_thumbnail()) {
                $output .= '<div class="post-thumbnail"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_post_thumbnail(get_the_ID(), $atts['thumbnail_size']) . '</a></div>';
            }
            $output .= '<a class="post-title" href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>';
            $output .= '</li>';
        }
        $output .= '</ul>';
        wp_reset_postdata();
    } else {
        $output = '<p>' . __('No posts found', 'last_cpt') . '</p>';
    }

    return $output;
}
add_shortcode('last_cpt', 'show_last_cpt');

// Funzione di rendering del blocco
function render_last_cpt_block($attributes)
{
    return show_last_cpt($attributes);
}
