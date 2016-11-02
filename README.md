# Article JSON-LD

Article JSON-LD, yet another solution to add Schema.org microdata as a JSON-LD script on your site posts. it will automatically insert the JSON-LD script in your site `<head>` tag.

## Custom-Post-Types Support
By default the plugin supports the `post` post-type, add support for other custom-post-types by a code snippet as the example below:

```php
add_action( 'init', 'add_article_json_ld_post_type_support', 15 );

/**
 * @return void
 */
function add_article_json_ld_post_type_support() {
    add_post_type_support( 'custom', 'article-json-ld' );
}
```

## WP Filters

- `ArticleJsonLd\post_json_ld_data` A filter for a post JSON-LD data.
- `ArticleJsonLd\post_author_json_ld_data` A filter for a post author JSON-LD data.
- `ArticleJsonLd\post_publisher_json_ld_data` A filter for a post publisher JSON-LD data.

## Requirements
The plugin requires PHP 5.4+ and WordPress 4.4+.
