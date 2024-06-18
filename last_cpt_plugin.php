<?php
/*
Plugin Name: Last CPT Plugin
Description: Last CPT Plugin is a WordPress plugin that allows you to display the latest posts of a custom post type.
Version: 1.1
Author: Marco Traina
*/

// Impedisce l'accesso diretto al file
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function show_last_cpt($atts) {
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
function last_cpt_register_block() {
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
class Last_CPT_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'last_cpt_widget',
            'Last CPT Widget',
            array('description' => 'Mostra gli ultimi post di un tipo di post personalizzato.')
        );
    }

    public function widget($args, $instance) {
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

    public function form($instance) {
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
                    <option value="<?php echo esc_attr($post_type->name); ?>" <?php selected($tipo, $post_type->name); ?>><?php echo esc_html($post_type->labels->singular_name); ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('numero'); ?>">Numero di post:</label>
            <input class="tiny-text" id="<?php echo $this->get_field_id('numero'); ?>" name="<?php echo $this->get_field_name('numero'); ?>" type="number" step="1" min="1" value="<?php echo esc_attr($numero); ?>" size="3" />
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_thumbnail); ?> id="<?php echo $this->get_field_id('show_thumbnail'); ?>" name="<?php echo $this->get_field_name('show_thumbnail'); ?>" />
            <label for="<?php echo $this->get_field_id('show_thumbnail'); ?>">Mostra thumbnail</label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('thumbnail_size'); ?>">Dimensione thumbnail:</label>
            <select class="widefat" id="<?php echo $this->get_field_id('thumbnail_size'); ?>" name="<?php echo $this->get_field_name('thumbnail_size'); ?>">
                <option value="thumbnail" <?php selected($thumbnail_size, 'thumbnail'); ?>>Thumbnail</option>
                <option value="full" <?php selected($thumbnail_size, 'full'); ?>>Full</option>
            </select>
        </p>
        <?php
    }

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['tipo'] = (!empty($new_instance['tipo'])) ? strip_tags($new_instance['tipo']) : 'post';
        $instance['numero'] = (!empty($new_instance['numero'])) ? intval($new_instance['numero']) : 5;
        $instance['show_thumbnail'] = isset($new_instance['show_thumbnail']) ? (bool) $new_instance['show_thumbnail'] : false;
        $instance['thumbnail_size'] = (!empty($new_instance['thumbnail_size'])) ? strip_tags($new_instance['thumbnail_size']) : 'thumbnail';
        return $instance;
    }
}
function register_last_cpt_widget() {
    register_widget('Last_CPT_Widget');
}
add_action('widgets_init', 'register_last_cpt_widget');

// Aggiungi la pagina delle impostazioni
function last_cpt_add_admin_menu() {
    add_options_page(
        'Last CPT Settings', // Titolo della pagina
        'Last CPT', // Nome del menu
        'manage_options', // Capacità richiesta
        'last_cpt', // Slug del menu
        'last_cpt_options_page' // Funzione callback per la pagina delle impostazioni
    );
}
add_action('admin_menu', 'last_cpt_add_admin_menu');

// Registra le impostazioni
function last_cpt_settings_init() {
    register_setting('lastCpt', 'last_cpt_settings');

    add_settings_section(
        'last_cpt_section', 
        __('Custom CSS Settings', 'last_cpt'), 
        'last_cpt_settings_section_callback', 
        'lastCpt'
    );

    add_settings_field(
        'last_cpt_custom_css', 
        __('Custom CSS', 'last_cpt'), 
        'last_cpt_custom_css_render', 
        'lastCpt', 
        'last_cpt_section'
    );
}
add_action('admin_init', 'last_cpt_settings_init');

// Callback per la sezione delle impostazioni
function last_cpt_settings_section_callback() {
    echo __('Enter your custom CSS to style the list of posts.', 'last_cpt');
}

// Campo per inserire il CSS personalizzato
function last_cpt_custom_css_render() {
    $options = get_option('last_cpt_settings');
    ?>
    <textarea cols='60' rows='10' name='last_cpt_settings[last_cpt_custom_css]'><?php echo $options['last_cpt_custom_css']; ?></textarea>
    <?php
}

// Funzione callback per la pagina delle impostazioni
function last_cpt_options_page() {
    ?>
    <form action='options.php' method='post'>
        <h2>Last CPT Settings</h2>
        <?php
        settings_fields('lastCpt');
        do_settings_sections('lastCpt');
        submit_button();
        ?>
    </form>
    <?php
}

// Carica il CSS personalizzato dalle impostazioni
function last_cpt_custom_css() {
    $options = get_option('last_cpt_settings');
    if (!empty($options['last_cpt_custom_css'])) {
        echo '<style type="text/css">' . $options['last_cpt_custom_css'] . '</style>';
    }
}
add_action('wp_head', 'last_cpt_custom_css');
?>
