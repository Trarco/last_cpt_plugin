# Last CPT Plugin (ENGLISH)

Last CPT Plugin is a WordPress plugin that allows you to display the latest posts of a custom post type.

## Features

- Display the latest posts of a custom post type using a shortcode or widget.
- Customize display options, including the ability to show or hide thumbnails, define the thumbnail size.
- Integration with the Gutenberg editor for a visual editing experience.
- Advanced customization options through support for custom CSS.

## Installation

1. Download the plugin ZIP file from the WordPress plugins page or GitHub repository.
2. Upload the plugin ZIP file via the Plugins > Add New > Upload Plugin menu.
3. Activate the plugin from the list of installed plugins.

## Usage

### Shortcode

Use the `[last_cpt]` shortcode in your content to display the latest posts of a custom post type. You can customize the shortcode options using the following attributes:

- `type`: specify the post type to display (default: "post").
- `number`: specify the number of posts to display (default: 5).
- `show_thumbnail`: specify whether to show or hide thumbnails (accepted values: true or false, default: true).
- `thumbnail_size`: specify the thumbnail size (accepted values: "thumbnail" or "full", default: "thumbnail").

Example:
[last_cpt type="custom_post_type_name" number="5" show_thumbnail="true" thumbnail_size="full"]

### Widget

After activating the plugin, you'll find the "Last CPT Widget" available in the WordPress widget area. Add the widget to the desired area and customize its display options.

### Gutenberg Block

The plugin also provides a custom Gutenberg block called "Last CPT." You can add and configure the block directly in the Gutenberg editor.

## Customization

You can further customize the plugin's style using custom CSS. Modify the `custom-last-cpt-styles.css` file included in the plugin to add your CSS rules.

## Contributions

We welcome contributions and suggestions for improving the plugin. If you have ideas for new features or suggestions for improvements, feel free to share them in the GitHub repository's issue area.

## License

This plugin is released under the MIT license. See the [LICENSE](LICENSE) file for details.


# Last CPT Plugin (ITALIANO)

Last CPT Plugin è un plugin per WordPress che consente di mostrare gli ultimi post di un tipo di post personalizzato.

## Caratteristiche

- Mostra gli ultimi post di un tipo di post personalizzato utilizzando uno shortcode o un widget.
- Personalizzazione delle opzioni di visualizzazione, inclusa la possibilità di mostrare o nascondere le thumbnail, di definire la dimensione della thumbnail.
- Integrazione con l'editor di Gutenberg per un'esperienza di modifica visiva.
- Opzioni avanzate di personalizzazione tramite il supporto per CSS personalizzato.

## Installazione

1. Scarica il file ZIP del plugin dalla pagina dei plugin di WordPress o dal repository GitHub.
2. Carica il file ZIP del plugin tramite il menu Plugin > Aggiungi nuovo > Carica plugin.
3. Attiva il plugin dall'elenco dei plugin installati.

## Utilizzo

### Shortcode

Utilizza lo shortcode `[last_cpt]` nei tuoi contenuti per visualizzare gli ultimi post di un tipo di post personalizzato. È possibile personalizzare le opzioni dello shortcode utilizzando i seguenti attributi:

- `tipo`: specifica il tipo di post da mostrare (predefinito: "post").
- `numero`: specifica il numero di post da mostrare (predefinito: 5).
- `show_thumbnail`: specifica se mostrare o nascondere le thumbnail (valori accettati: true o false, predefinito: true).
- `thumbnail_size`: specifica la dimensione della thumbnail (valori accettati: "thumbnail" o "full", predefinito: "thumbnail").

Esempio:
[last_cpt tipo="nome_custom_post_type" numero="5" show_thumbnail="true" thumbnail_size="full"]


### Widget

Dopo aver attivato il plugin, troverai il widget "Last CPT Widget" disponibile nell'area dei widget di WordPress. Aggiungi il widget all'area desiderata e personalizzane le opzioni di visualizzazione.

### Blocco di Gutenberg

Il plugin offre anche un blocco personalizzato di Gutenberg chiamato "Last CPT". È possibile aggiungere e configurare il blocco direttamente nell'editor di Gutenberg.

## Personalizzazione

Puoi personalizzare ulteriormente lo stile del plugin utilizzando CSS personalizzato. Modifica il file `custom-last-cpt-styles.css` incluso nel plugin per aggiungere le tue regole CSS.

## Contributi

Siamo aperti a contributi e suggerimenti per migliorare il plugin. Se hai idee su nuove funzionalità o suggerimenti per miglioramenti, non esitare a condividerli nell'area delle issue del repository GitHub.

## Licenza

Questo plugin è rilasciato sotto la licenza MIT. Vedi il file [LICENSE](LICENSE) per i dettagli.