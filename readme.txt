=== Article JSON-LD ===
Contributors: alex-ye
Tags: seo, microdata, json-ld, rich snippets, schema.org, structured data
Requires at least: 5.0
Tested up to: 5.4
Stable tag: 0.3
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

A straightforward solution to add Schema.org microdata as a JSON-LD script on your site posts.

== Description ==

Article JSON-LD is an extendable and straightforward solution to enhance your site SEO by adding Schema.org microdata as a JSON-LD script on your site posts. 

It will automatically insert the JSON-LD script in your site `<head>` tag by using the standard information provided by WordPress, such as the title, description, featured image, publish date, author, categories..etc.

You can support your custom post types or modify the data easily by using the plugin's hooks.

= Custom-Post-Types Support =
By default, the plugin supports the `post` post-type. Add support for other custom-post-types using a code snippet as the example below:

`
add_action('init', 'add_article_json_ld_post_type_support', 15);

/**
 * @return void
 */
function add_article_json_ld_post_type_support()
{
    add_post_type_support('custom-post-type', 'article-json-ld');
}
`

You can use [Code Snippets](https://wordpress.org/plugins/code-snippets) plugin to add the code snippets to your site.

An active demo is available on [Arageek](https://www.arageek.com/) articles.

= Plugin's Hooks =

- `ArticleJsonLd\post_json_ld_data` A filter for a post JSON-LD data.
- `ArticleJsonLd\post_author_json_ld_data` A filter for a post author JSON-LD data.
- `ArticleJsonLd\post_publisher_json_ld_data` A filter for a post publisher JSON-LD data.

= Contributing =
Developers can contribute to the source code on the [Github Repository](https://github.com/nash-ye/wp-article-json-ld).

== Installation ==

1. Upload and install the plugin
2. Use the plugin WP filters to customize the data.

== Changelog ==

= 0.3 =
* Add compatibility for latest version of WordPress SEO by Yoast.

= 0.2.1 =
* Add the 'description' property and use `get_the_excerpt()` to get the value.
* Use the ISO 8601 format for 'datePublished' and 'dateModified' properties.
* Use `get_the_title()` to get the `headline' property value.
* Some fixes and minor enhancements.

= 0.2 =
* The Initial version.
