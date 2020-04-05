# Article JSON-LD

Article JSON-LD is an extendable and straightforward solution to enhance your site SEO by adding Schema.org microdata as a JSON-LD script on your site posts. 

It will automatically insert the JSON-LD script in your site `<head>` tag by using the standard information provided by WordPress, such as the title, description, featured image, publish date, author, categories..etc.

You can support your custom post types or modify the data easily by using the plugin's hooks.

## Custom-Post-Types Support
By default, the plugin supports the `post` post-type. Add support for other custom-post-types using a code snippet as the example below:

```php
add_action('init', 'add_article_json_ld_post_type_support', 15);

/**
 * @return void
 */
function add_article_json_ld_post_type_support()
{
    add_post_type_support('custom-post-type', 'article-json-ld');
}
```

## Plugin's Hooks

- `ArticleJsonLd\post_json_ld_data` A filter for a post JSON-LD data.
- `ArticleJsonLd\post_author_json_ld_data` A filter for a post author JSON-LD data.
- `ArticleJsonLd\post_publisher_json_ld_data` A filter for a post publisher JSON-LD data.

## Credits
Thanks to [Arageek](https://www.arageek.com) for the approval to publish this plugin as a free, open-source project.