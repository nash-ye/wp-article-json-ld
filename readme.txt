=== Article JSON-LD ===
Contributors: alex-ye
Tags: seo, microdata, json-ld, rich snippets, schema.org, structured data
Requires at least: 4.4
Tested up to: 4.6.1
Stable tag: 0.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A simple and clean solution to add Schema.org microdata as a JSON-LD script on your site posts.

== Description ==

Article JSON-LD, yet another solution to add Schema.org microdata as a JSON-LD script on your site posts. it will automatically insert the JSON-LD script in your site `<head>` tag.

= Custom-Post-Types Support =
By default the plugin supports the `post` post-type, add support for other custom-post-types by a code snippet as the example below:

`
add_action( 'init', 'add_article_json_ld_post_type_support', 15 );

/**
 * @return void
 */
function add_article_json_ld_post_type_support() {
    add_post_type_support( 'custom', 'article-json-ld' );
}
`

You can use [Code Snippets](https://wordpress.org/plugins/code-snippets) plugin to add the code snippets to your site.

= WordPress Filters =

- `ArticleJsonLd\post_json_ld_data` A filter for a post JSON-LD data.
- `ArticleJsonLd\post_author_json_ld_data` A filter for a post author JSON-LD data.
- `ArticleJsonLd\post_publisher_json_ld_data` A filter for a post publisher JSON-LD data.

= Contributing =
Developers can contribute to the source code on the [Github Repository](https://github.com/nash-ye/wp-article-json-ld).

= Requirements =
The plugin requires PHP 5.4+ and WordPress 4.4+.

== Installation ==

1. Upload and install the plugin
2. Use the plugin WP filters to customize the data.

== Changelog ==

= 0.2 =
* The Initial version.
