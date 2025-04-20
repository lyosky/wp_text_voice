<?php
/**
 * Plugin Name: 文本转语音
 * Description: 使用Web Speech API实现文章内容语音朗读功能
 * Version: 1.0.0
 * Author: lyosky
 */

add_filter('the_content', 'tts_shortcode_handler');

function tts_shortcode_handler($content) {
    if (is_single()) {
        // 生成播放器HTML
        $output = '<div class="tts-container">';
        $output .= '<div class="tts-controls">';
        $output .= '<button class="tts-play">播放</button>';
        $output .= '<button class="tts-pause">暂停</button>';
        $output .= '<button class="tts-stop">停止</button>';
        $output .= '</div>';
        $output .= '</div>';

        $content .= $output;
        
        // 加载前端资源
        add_action('wp_enqueue_scripts', 'tts_enqueue_scripts');
        // 传递参数到前端
        add_filter('wp_enqueue_scripts', function() {
            wp_localize_script('tts-script', 'ttsOptions', get_option('tts_options'));
        });
    }
  
    return $content;
}

function tts_enqueue_scripts() {
    wp_enqueue_style('tts-style', plugins_url('/css/tts-style.css', __FILE__));
    wp_enqueue_script('tts-script', plugins_url('/js/tts-frontend.js', __FILE__), array('jquery'), '1.0', true);
}

// 后台设置功能
add_action('admin_menu', 'tts_add_admin_menu');
add_action('admin_init', 'tts_settings_init');

function tts_add_admin_menu() {
    add_options_page(
        '文本转语音设置',
        'TTS设置',
        'manage_options',
        'tts_settings',
        'tts_options_page'
    );
}

function tts_settings_init() {
    register_setting('tts_settings_group', 'tts_options');

    add_settings_section(
        'tts_main_section',
        '语音合成设置',
        'tts_section_callback',
        'tts_settings'
    );

    add_settings_field(
        'tts_lang',
        '默认语言',
        'tts_lang_render',
        'tts_settings',
        'tts_main_section'
    );

    add_settings_field(
        'tts_rate',
        '语速 (0.1-10)',
        'tts_rate_render',
        'tts_settings',
        'tts_main_section'
    );

    add_settings_field(
        'tts_pitch',
        '音高 (0-2)',
        'tts_pitch_render',
        'tts_settings',
        'tts_main_section'
    );

    add_settings_field(
        'tts_volume',
        '音量 (0-1)',
        'tts_volume_render',
        'tts_settings',
        'tts_main_section'
    );

    add_settings_field(
        'tts_content_class',
        '内容容器Class',
        'tts_content_class_render',
        'tts_settings',
        'tts_main_section'
    );
}

function tts_section_callback() {
    echo '配置语音合成的默认参数';
}

function tts_lang_render() {
    $options = get_option('tts_options');
    echo "<input type='text' name='tts_options[lang]' value='" . esc_attr($options['lang'] ?? 'zh-CN') . "'>";
}

function tts_rate_render() {
    $options = get_option('tts_options');
    echo "<input type='number' min='0.1' max='10' step='0.1' name='tts_options[rate]' value='" . esc_attr($options['rate'] ?? 1) . "'>";
}

function tts_pitch_render() {
    $options = get_option('tts_options');
    echo "<input type='number' min='0' max='2' step='0.1' name='tts_options[pitch]' value='" . esc_attr($options['pitch'] ?? 1) . "'>";
}

function tts_volume_render() {
    $options = get_option('tts_options');
    echo "<input type='number' min='0' max='1' step='0.1' name='tts_options[volume]' value='" . esc_attr($options['volume'] ?? 1) . "'>";
}

function tts_content_class_render() {
    $options = get_option('tts_options');
    echo "<input type='text' name='tts_options[content_class]' value='" . esc_attr($options['content_class'] ?? 'tts-content') . "'>";
}

function tts_options_page() {
    ?>
    <div class='wrap'>
        <h2>文本转语音设置</h2>
        <form action='options.php' method='post'>
            <?php
            settings_fields('tts_settings_group');
            do_settings_sections('tts_settings');
            submit_button();
            ?>
        </form>
    </div>
    <?php
}


?>