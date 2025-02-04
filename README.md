# Last CPT Plugin

Last CPT Plugin is a WordPress plugin that allows you to display the latest posts of a custom post type with advanced filtering options.

## Features

- Display the latest posts of a custom post type using a shortcode, widget, or Gutenberg block.
- Customize display options, including:
  - Show or hide thumbnails.
  - Define thumbnail size.
  - Filter posts by category.
- Integration with the Gutenberg editor for a visual editing experience.
- Advanced customization options through support for custom CSS.

## Installation

1. Download the plugin ZIP file from the WordPress plugins page or GitHub repository.
2. Upload the plugin ZIP file via the Plugins > Add New > Upload Plugin menu.
3. Activate the plugin from the list of installed plugins.

## Tested With WordPress and PHP

This plugin has been tested with:

- WordPress version 6.5
- PHP version 8.0

## Usage

### Shortcode

Use the `[last_cpt]` shortcode in your content to display the latest posts of a custom post type. You can customize the shortcode options using the following attributes:

- `type`: specify the post type to display (default: "post").
- `number`: specify the number of posts to display (default: 5).
- `show_thumbnail`: specify whether to show or hide thumbnails (accepted values: true or false, default: true).
- `thumbnail_size`: specify the thumbnail size (accepted values: "thumbnail" or "full", default: "thumbnail").
- `category`: specify the category to filter posts by (optional).

Example:
```shortcode
[last_cpt type="custom_post_type_name" number="5" show_thumbnail="true" thumbnail_size="full" category="news"]

### Widget
After activating the plugin, you'll find the "Last CPT Widget" available in the WordPress widget area. Add the widget to the desired area and customize its display options, including post type, category, and thumbnail display.

### Gutenberg Block
The plugin provides a custom Gutenberg block called "Last CPT." You can add and configure the block directly in the Gutenberg editor. The block supports filtering by post type and category, as well as thumbnail display options.

## Customization
You can further customize the plugin's style using custom CSS. Modify the custom-last-cpt-styles.css file included in the plugin to add your CSS rules.

## Contributions
We welcome contributions and suggestions for improving the plugin. If you have ideas for new features or suggestions for improvements, feel free to share them in the GitHub repository's issue area.

## License
This plugin is released under the MIT license. See the LICENSE file for details.