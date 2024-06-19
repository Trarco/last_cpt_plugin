<?php

// Aggiunge una voce al menu di amministrazione
function last_cpt_add_admin_menu()
{
    add_options_page(
        'Last CPT Settings',
        'Last CPT Settings',
        'manage_options',
        'last-cpt-settings',
        'last_cpt_settings_page'
    );
}
add_action('admin_menu', 'last_cpt_add_admin_menu');

// Callback per la pagina delle impostazioni
function last_cpt_settings_page()
{
?>
    <div class="wrap">
        <h1>Last CPT Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('last_cpt_settings_group');
            do_settings_sections('last-cpt-settings');
            submit_button();
            ?>
        </form>
    </div>
<?php
}

// Inizializza le impostazioni
function last_cpt_settings_init()
{
    register_setting('last_cpt_settings_group', 'last_cpt_custom_css');

    add_settings_section(
        'last_cpt_settings_section',
        __('Custom CSS', 'last_cpt'),
        null,
        'last-cpt-settings'
    );

    add_settings_field(
        'last_cpt_custom_css',
        __('Custom CSS', 'last_cpt'),
        'last_cpt_custom_css_callback',
        'last-cpt-settings',
        'last_cpt_settings_section'
    );
}
add_action('admin_init', 'last_cpt_settings_init');

// Callback per il campo di input del CSS
function last_cpt_custom_css_callback()
{
    $custom_css = get_option('last_cpt_custom_css');
    echo '<textarea name="last_cpt_custom_css" rows="10" cols="50" class="large-text code">' . esc_textarea($custom_css) . '</textarea>';
}

// Enqueue il CSS personalizzato
function last_cpt_enqueue_custom_css()
{
    $custom_css = get_option('last_cpt_custom_css');
    if ($custom_css) {
        echo '<style type="text/css">' . $custom_css . '</style>';
    }
}
add_action('wp_head', 'last_cpt_enqueue_custom_css');
