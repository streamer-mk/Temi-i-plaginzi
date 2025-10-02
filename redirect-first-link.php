<?php
/**
 * 1) Извади го првиот URL од содржината (href во <a> или „гол“ линк).
 */
function my_get_first_url_from_content( $content ) {
    // Прво пробај со <a href="...">
    if ( preg_match( '#<a[^>]+href=[\'"]([^\'"]+)[\'"]#i', $content, $m ) ) {
        return esc_url_raw( $m[1] );
    }
    // Резерва: најди „гол“ http/https URL
    if ( preg_match( '#https?://[^\s"\']+#i', $content, $m ) ) {
        return esc_url_raw( $m[0] );
    }
    return false;
}

/**
 * 2) На листи/архиви – направи насловите/сликите да линкуваат директно кон надворешниот URL,
 *    наместо кон single постот (ако постои линк во содржината).
 */
function my_external_permalink_for_posts( $permalink, $post, $leavename = false ) {
    if ( $post instanceof WP_Post && $post->post_type === 'post' ) {
        $url = my_get_first_url_from_content( $post->post_content );
        if ( $url ) {
            return $url;
        }
    }
    return $permalink;
}
add_filter( 'post_link', 'my_external_permalink_for_posts', 10, 3 );

/**
 * 3) Ако некој сепак отвори single пост – пренасочи веднаш кон првиот линк.
 */
function my_redirect_single_post_to_external() {
    // Не редиректирај во админ, фидови, преглед, AJAX/REST итн.
    if ( is_admin() || is_feed() || is_preview() || is_trackback() || is_search() || wp_doing_ajax() || ( function_exists( 'wp_is_json_request' ) && wp_is_json_request() ) ) {
        return;
    }

    if ( is_singular( 'post' ) ) {
        global $post;
        if ( $post instanceof WP_Post ) {
            $url = my_get_first_url_from_content( $post->post_content );
            if ( $url ) {
                // Ако линкот е ист домен со сајтот – нема потреба од редирект.
                $host      = parse_url( $url, PHP_URL_HOST );
                $site_host = parse_url( home_url(), PHP_URL_HOST );
                if ( $host && $site_host && strcasecmp( $host, $site_host ) === 0 ) {
                    return;
                }

                // Дозволи wp_safe_redirect да редиректира кон овој надворешен хост
                if ( $host ) {
                    add_filter( 'allowed_redirect_hosts', function ( $hosts ) use ( $host ) {
                        $hosts[] = $host;
                        return array_unique( $hosts );
                    } );
                }

                wp_safe_redirect( $url, 302 );
                exit;
            }
        }
    }
}
add_action( 'template_redirect', 'my_redirect_single_post_to_external' );
