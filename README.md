# Article JSON-LD

A simple and clean solution to add Schema.org microdata as a JSON-LD script on your site posts.

## Usage
Install the plugin like any other WordPress plugin, it will automatically insert the JSON-LD script in your site <head> tag, By default it supports the `post` post-type. Add support for other custom-post-types by a code like this:
```php
add_action( 'init', 'add_article_json_ld_post_type_support', 15 );

/**
 * @return void
 * @since 0.1
 */
function add_article_json_ld_post_type_support() {
    add_post_type_support( 'custom', 'article-json-ld' );
}
```

## WP Filters

- `ArticleJsonLd\post_json_ld_data` A filter for the post JSON-LD data.
- `ArticleJsonLd\post_author_json_ld_data` A filter for the post author JSON-LD data.
- `ArticleJsonLd\post_publisher_json_ld_data` A filter for the post publisher JSON-LD data.

## Requirements
Article JSON-LD requires PHP 5.4+.
