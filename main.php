<?php
/*
Plugin Name: Article JSON-LD
Plugin URI: https://github.com/nash-ye/wp-article-json-ld
Description: A simple and clean solution to add Schema.org microdata as a JSON-LD script on your site posts.
Author: Nashwan Doaqan
Author URI: http://nashwan-d.com
Version: 0.2.1
*/

namespace ArticleJsonLd;

add_action( 'init', 'ArticleJsonLd\add_post_types_support', 15 );

/**
 * @return void
 * @since 0.1
 */
function add_post_types_support() {
    add_post_type_support( 'post', 'article-json-ld' );
}

add_action( 'wp_head', 'ArticleJsonLd\singular_post_json_ld', 25 );

/**
 * @return void
 * @since 0.1
 */
function singular_post_json_ld() {
    if ( ! is_singular() ) {
	return;
    }

    echo get_post_json_ld();
}

/**
 * Get post JSON-LD script.
 *
 * @return string
 * @since 0.1
 */
function get_post_json_ld( $post = null ) {
    $jsonld = '';
    $data = get_post_json_ld_data( $post );

    if ( empty( $data ) ) {
	return $jsonld;
    }

    $jsonld = json_encode( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );
    $jsonld = '<script type="application/ld+json">' . "\n". $jsonld . "\n" . '</script>' . "\n";
    return $jsonld;
}

/**
 * Get post JSON-LD data.
 *
 * @return array
 * @since 0.1
 */
function get_post_json_ld_data( $post = null ) {
    $data = array();
    $post = get_post( $post );

    if ( empty( $post ) ) {
	return $data;
    }

    if ( ! post_type_supports( $post->post_type, 'article-json-ld' ) ) {
	return $data;
    }

    $data['@context'] = 'https://schema.org';
    $data['@id'] = "#post-{$post->ID}";
    $data['@type'] = 'Article';

    $data['headline'] = get_the_title( $post );
    $data['url'] = get_the_permalink( $post );
    $data['mainEntityOfPage'] = true;

    if ( has_excerpt( $post ) ) {
	$data['description'] = get_the_excerpt( $post );
    }

    $post_author = get_post_author_json_ld_data( $post );
    if ( ! empty( $post_author ) ) {
	$data['author'] = $post_author;
    }

    $post_publisher = get_post_publisher_json_ld_data( $post );
    if ( ! empty( $post_publisher ) ) {
	$data['publisher'] = $post_publisher;
    }

    $post_taxonomies = get_post_taxonomies( $post );

    if ( in_array( 'post_tag', $post_taxonomies, true ) ) {
	$post_tags = get_the_tags( $post );
	if ( $post_tags && ! is_wp_error( $post_tags ) ) {
	    $data['keywords'] = array();
	    foreach ( $post_tags as $post_tag ) {
		$data['keywords'][] = $post_tag->name;
	    }
	}
    }

    if ( in_array( 'category', $post_taxonomies, true ) ) {
	$post_categories = get_the_terms( $post, 'category' );
	if ( $post_categories && ! is_wp_error( $post_categories ) ) {
	    $data['articleSection'] = reset( $post_categories )->name;
	}
    }

    $data['datePublished'] = get_the_date( 'c', $post );
    $data['dateModified'] = get_the_modified_date( 'c', $post );

    $post_thumbnail_id = get_post_thumbnail_id( $post );
    if ( ! empty( $post_thumbnail_id ) ) {
	$post_thumbnail_src = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
	if ( ! empty( $post_thumbnail_src ) ) {
	    $data['image'] = array(
		'@type'   => 'ImageObject',
		'url'    => $post_thumbnail_src[0],
		'width'  => $post_thumbnail_src[1],
		'height' => $post_thumbnail_src[2],
	    );
	}
    }

    $data = apply_filters( 'ArticleJsonLd\post_json_ld_data', $data, $post );
    return $data;
}

/**
 * Get post author JSON-LD data.
 *
 * @return array
 * @since 0.2
 */
function get_post_author_json_ld_data( $post = null ) {
    $data = array();
    $post = get_post( $post );

    if ( empty( $post ) ) {
	return $data;
    }

    $post_author = get_userdata( $post->post_author );

    if ( empty( $post_author ) ) {
	return $data;
    }

    $data['@type'] = 'Person';
    $data['name'] = $post_author->display_name;

    $data = apply_filters( 'ArticleJsonLd\post_author_json_ld_data', $data, $post );
    return $data;
}

/**
 * Get post publisher JSON-LD data.
 *
 * @return array
 * @since 0.1
 */
function get_post_publisher_json_ld_data( $post = null ) {
    $data = array();
    $post = get_post( $post );

    if ( empty( $post ) ) {
	return $data;
    }

    /* WordPress SEO plugin integration */
    if ( defined( 'WPSEO_VERSION' ) ) {
	$wpseo_options = \WPSEO_Options::get_options( array( 'wpseo' ) );
	if ( 'company' === $wpseo_options['company_or_person'] ) {
	    $data['@type'] = 'Organization';
	    $data['url'] = home_url( '/' );
	    $data['name'] = $wpseo_options['company_name'];
	    $data['logo'] = array(
		'@type' => 'ImageObject',
		'url'   => $wpseo_options['company_logo'],
	    );
	} elseif ( 'person' === $wpseo_options['company_or_person'] ) {
	    $data['@type'] = 'Person';
	    $data['url'] = home_url( '/' );
	    $data['name'] = $wpseo_options['person_name'];
	}
    }

    if ( empty( $data ) ) {
	$data['@type'] = 'Organization';
	$data['url'] = home_url( '/' );
	$data['name'] = get_bloginfo( 'name', 'display' );

	if ( current_theme_supports( 'custom-logo' ) ) {
	    $custom_logo_id = get_theme_mod( 'custom_logo' );
	    if ( ! empty( $custom_logo_id ) ) {
		$custom_logo_src = wp_get_attachment_image_src( $custom_logo_id, 'full' );
		if ( ! empty( $custom_logo_src ) ) {
		    $data['logo'] = array(
			'@type'   => 'ImageObject',
			'url'    => $custom_logo_src[0],
			'width'  => $custom_logo_src[1],
			'height' => $custom_logo_src[2],
		    );
		}
	    }
	}
    }

    $data = apply_filters( 'ArticleJsonLd\post_publisher_json_ld_data', $data, $post );
    return $data;
}
