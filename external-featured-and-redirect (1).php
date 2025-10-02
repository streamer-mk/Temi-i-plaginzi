<?php
/*
Plugin Name: External Featured Image & Redirect for PenNews
Description: Автоматски користи прва слика од содржината како Featured Image (без да ја зачувува локално) и пренасочува кон првиот линк.
Author: ChatGPT
Version: 1.0
*/

// --- 1. Пренасочување кон првиот линк ---
add_action('template_redirect', function () {
    if (is_single()) {
        global $post;
        if ($post) {
            preg_match('/<a\s+href=["\']([^"\']+)["\']/', $post->post_content, $matches);
            if (!empty($matches[1])) {
                wp_redirect($matches[1], 301);
                exit;
            }
        }
    }
});

// --- 2. Прикажување на external featured image ---
add_filter('post_thumbnail_html', function ($html, $post_id, $post_thumbnail_id, $size, $attr) {
    $external_url = get_post_meta($post_id, '_external_featured_image', true);
    if ($external_url) {
        $alt = esc_attr(get_the_title($post_id));
        return sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url($external_url), $alt);
    }
    return $html;
}, 10, 5);

// --- 3. Земање на прва слика од содржината и снимање во post meta ---
add_action('save_post', function ($post_id) {
    // Прескокни ако е auto-save или revision
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (wp_is_post_revision($post_id)) return;

    $post = get_post($post_id);
    if (!$post) return;

    // Најди ја првата слика во содржината
    if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $post->post_content, $matches)) {
        $image_url = esc_url_raw($matches[1]);
        update_post_meta($post_id, '_external_featured_image', $image_url);
    }
});
