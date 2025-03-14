<?php

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
        $categoria = !empty($instance['categoria']) ? $instance['categoria'] : '';
        $randomize = isset($instance['randomize']) ? (bool) $instance['randomize'] : false;

        echo $args['before_widget'];
        if (!empty($title)) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
        echo show_last_cpt(array(
            'tipo' => $tipo,
            'numero' => $numero,
            'show_thumbnail' => $show_thumbnail,
            'thumbnail_size' => $thumbnail_size,
            'categoria' => $categoria,
            'randomize' => $randomize
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
        $categoria = !empty($instance['categoria']) ? $instance['categoria'] : '';
        $randomize = isset($instance['randomize']) ? (bool) $instance['randomize'] : false;

        $categories = get_categories(array('hide_empty' => false));

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
        <p>
            <input class="checkbox" type="checkbox" <?php checked($randomize); ?> id="<?php echo $this->get_field_id('randomize'); ?>" name="<?php echo $this->get_field_name('randomize'); ?>" />
            <label for="<?php echo $this->get_field_id('randomize'); ?>">Casuale</label>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('categoria')); ?>">Categoria:</label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('categoria')); ?>" name="<?php echo esc_attr($this->get_field_name('categoria')); ?>">
                <option value=""><?php _e('Tutte le categorie', 'text_domain'); ?></option>
                <?php foreach ($categories as $cat) : ?>
                    <option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($categoria, $cat->slug); ?>><?php echo esc_html($cat->name); ?></option>
                <?php endforeach; ?>
            </select>
        </p>

<?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['tipo'] = (!empty($new_instance['tipo'])) ? strip_tags($new_instance['tipo']) : 'post';
        $instance['numero'] = (!empty($new_instance['numero'])) ? intval($new_instance['numero']) : 5;
        $instance['show_thumbnail'] = isset($new_instance['show_thumbnail']) ? (bool) $new_instance['show_thumbnail'] : false;
        $instance['thumbnail_size'] = (!empty($new_instance['thumbnail_size'])) ? strip_tags($new_instance['thumbnail_size']) : 'thumbnail';
        $instance['categoria'] = (!empty($new_instance['categoria'])) ? strip_tags($new_instance['categoria']) : '';
        $instance['randomize'] = isset($new_instance['randomize']) ? (bool) $new_instance['randomize'] : false;
        return $instance;
    }
}

function register_last_cpt_widget()
{
    register_widget('Last_CPT_Widget');
}
add_action('widgets_init', 'register_last_cpt_widget');
