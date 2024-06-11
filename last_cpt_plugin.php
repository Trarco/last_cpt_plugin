<?php
/*
Plugin Name: Last CPT Plugin
Description: Last CPT Plugin is a WordPress plugin that allows you to display the latest posts of a custom post type.
Version: 1.0
Author: Marco Traina
*/

// Impedisce l'accesso diretto al file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function show_last_cpt($atts)
{
    // Estrai gli attributi e imposta i valori di default
    $atts = shortcode_atts(
        array(
            'tipo' => 'post', // Default post type
            'numero' => 5, // Numero di post da mostrare
            'show_thumbnail' => true, // Mostra thumbnail
            'thumbnail_size' => 'thumbnail' // Dimensione della thumbnail
        ),
        $atts,
        'last_cpt'
    );

    // Prepara la query
    $args = array(
        'post_type' => $atts['tipo'],
        'posts_per_page' => $atts['numero'],
        'post_status' => 'publish',
    );

    // Esegui la query
    $query = new WP_Query($args);

    // Inizia l'output
    $output = '<ul class="last-cpt-list" id="last-cpt-list-' . $atts['tipo'] . '">';

    // Verifica se ci sono post da mostrare
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<li>';

            // Aggiungi l'immagine in evidenza, se disponibile e se impostato per mostrarla
            if ($atts['show_thumbnail'] && has_post_thumbnail()) {
                $output .= '<div class="post-thumbnail"><a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_post_thumbnail(get_the_ID(), $atts['thumbnail_size']) . '</a></div>';
            }

            $output .= '<a class="post-title" href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>';
            $output .= '</li>';
        }
    } else {
        $output .= '<li>Nessun post trovato.</li>';
    }

    // Resetta i dati della query
    wp_reset_postdata();

    // Chiudi l'output
    $output .= '</ul>';

    return $output;
}
// Registra lo shortcode
add_shortcode('last_cpt', 'show_last_cpt');

// Aggiungi il supporto per il blocco di Gutenberg
function last_cpt_register_block()
{
    // Registra l'editor script
    wp_register_script(
        'last-cpt-block',
        plugins_url('block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data')
    );

    // Passa i tipi di post e le impostazioni a JavaScript
    wp_localize_script(
        'last-cpt-block',
        'lastCptData',
        array(
            'postTypes' => get_post_types(array('public' => true), 'objects')
        )
    );

    // Registra il blocco
    register_block_type('last-cpt/block', array(
        'editor_script' => 'last-cpt-block',
        'render_callback' => 'show_last_cpt'
    ));
}
add_action('init', 'last_cpt_register_block');

// Crea il widget
class Last_CPT_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'last_cpt_widget',
            'Last CPT Widget',
            array('description' => 'Mostra gli ultimi post di un tipo di post personalizzato.')
        );
    }

    public function widget($args, $instance)
    {
        $tipo = !empty($instance['tipo']) ? $instance['tipo'] : 'post';
        $numero = !empty($instance['numero']) ? $instance['numero'] : 5;
        $show_thumbnail = isset($instance['show_thumbnail']) ? (bool) $instance['show_thumbnail'] : false;
        $thumbnail_size = !empty($instance['thumbnail_size']) ? $instance['thumbnail_size'] : 'thumbnail';
        $title = apply_filters('widget_title', $instance['title']);

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo show_last_cpt(array(
            'tipo' => $tipo,
            'numero' => $numero,
            'show_thumbnail' => $show_thumbnail,
            'thumbnail_size' => $thumbnail_size
        ));
        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $post_types = get_post_types(array('public' => true), 'objects');
        $tipo = !empty($instance['tipo']) ? $instance['tipo'] : 'post';
        $numero = !empty($instance['numero']) ? $instance['numero'] : 5;
        $show_thumbnail = isset($instance['show_thumbnail']) ? (bool) $instance['show_thumbnail'] : false;
        $thumbnail_size = !empty($instance['thumbnail_size']) ? $instance['thumbnail_size'] : 'thumbnail';
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';

?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('tipo')); ?>">Tipo di post:</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('tipo')); ?>" name="<?php echo esc_attr($this->get_field_name('tipo')); ?>">
                <?php foreach ($post_types as $post_type) : ?>
                    <option value="<?php echo esc_attr($post_type->name); ?>" <?php selected($tipo, $post_type->name); ?>>
                        <?php echo esc_html($post_type->labels->singular_name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('numero')); ?>">Numero di post:</label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('numero')); ?>" name="<?php echo esc_attr($this->get_field_name('numero')); ?>" type="number" value="<?php echo esc_attr($numero); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_thumbnail); ?> id="<?php echo esc_attr($this->get_field_id('show_thumbnail')); ?>" name="<?php echo esc_attr($this->get_field_name('show_thumbnail')); ?>" />
            <label for="<?php echo esc_attr($this->get_field_id('show_thumbnail')); ?>">Mostra thumbnail</label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('thumbnail_size')); ?>">Dimensione thumbnail:</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('thumbnail_size')); ?>" name="<?php echo esc_attr($this->get_field_name('thumbnail_size')); ?>">
                <option value="thumbnail" <?php selected($thumbnail_size, 'thumbnail'); ?>>Thumbnail</option>
                <option value="full" <?php selected($thumbnail_size, 'full'); ?>>Full</option>
            </select>
        </p>
<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['tipo'] = (!empty($new_instance['tipo'])) ? sanitize_text_field($new_instance['tipo']) : 'post';
        $instance['numero'] = (!empty($new_instance['numero'])) ? intval($new_instance['numero']) : 5;
        $instance['show_thumbnail'] = isset($new_instance['show_thumbnail']) ? (bool) $new_instance['show_thumbnail'] : false;
        $instance['thumbnail_size'] = (!empty($new_instance['thumbnail_size'])) ? sanitize_text_field($new_instance['thumbnail_size']) : 'thumbnail';
        $instance['title'] = (!empty($new_instance['title'])) ? sanitize_text_field($new_instance['title']) : '';
        return $instance;
    }
}

// Registra il widget
function register_last_cpt_widget()
{
    register_widget('Last_CPT_Widget');
}
add_action('widgets_init', 'register_last_cpt_widget');


function custom_last_cpt_styles()
{
    wp_enqueue_style('custom-last-cpt-styles', plugins_url('/custom-last-cpt-styles.css', __FILE__));
}
add_action('wp_enqueue_scripts', 'custom_last_cpt_styles');
