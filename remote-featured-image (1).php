<?php
/*
Plugin Name: Remote Featured Image for PenNews (Force Override)
Description: Always use external image URL from post content as featured image.
Version: 1.1
Author: ChatGPT
*/

// Extract first image from content and use it as featured image HTML
add_filter('post_thumbnail_html', function ($html, $post_id, $post_thumbnail_id, $size, $attr) {
    $post = get_post($post_id);
    if (!$post) return $html;

    // Check for first image in content
    if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $post->post_content, $match)) {
        $url = esc_url($match[1]);
        $alt = esc_attr(get_the_title($post_id));
        return '<img src="' . $url . '" alt="' . $alt . '" loading="lazy" />';
    }

    return $html;
}, 10, 5);
