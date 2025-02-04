<?php

// Funzione per registrare il blocco Gutenberg
function last_cpt_register_block()
{
    if (!function_exists('register_block_type')) {
        return;
    }

    register_block_type('last-cpt/block', array(
        'editor_script' => 'last-cpt-block-editor',
        'render_callback' => 'render_last_cpt_block', // Callback di rendering
    ));
}
add_action('init', 'last_cpt_register_block');

// Carica gli script del blocco
function last_cpt_block_editor_assets()
{
    wp_enqueue_script(
        'last-cpt-block-editor',
        plugins_url('../js/block.js', __FILE__),
        array('wp-blocks', 'wp-element', 'wp-editor', 'wp-components'),
        filemtime(plugin_dir_path(__FILE__) . '../js/block.js')
    );

    // Localizza lo script con i dati dei tipi di post e delle categorie
    wp_localize_script('last-cpt-block-editor', 'lastCptData', array(
        'postTypes' => get_post_types(array('public' => true), 'objects'),
        'categories' => get_categories(array('hide_empty' => false))
    ));
}
add_action('enqueue_block_editor_assets', 'last_cpt_block_editor_assets');
