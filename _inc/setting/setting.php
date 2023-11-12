<?php
function wp_ls_like_post_admin_layout()
{
    if (!current_user_can('manage_options')) {
        return;
    }
    if (isset($_GET['settings-update'])) {
        add_settings_error('setting', 'setting-message', 'تنظیمات ذخیره گردید', 'update');
    }
    settings_errors('setting-message');
?>
    <div class="wrap rp-wrapper">
        <form action="options.php" method="post" class="related-posts">
            <h1><?php echo esc_html(get_admin_page_title()) ?></h1>
            <?php
            settings_fields('like-post');
            do_settings_sections('like-post-html');
            var_dump(get_option('_like_post'));
            submit_button()
            ?>
        </form>
    </div>
<?php
}

function wp_ls_setting_init()
{
    // $args = [
    //     'type' => 'string',
    //     'sanitize_callback' => '_sanitize_text_fields',
    //     'defult' => null
    // ];
    // register_setting('related-post', '_rp_title', $args);
    // register_setting('related-post', '_rp_number', $args);
    // register_setting('related-post', '_rp_according_to', $args);
    // register_setting('related-post', '_rp_order_by', $args);
    // register_setting('related-post', '_rp_show_type', $args);

    // $settings_array = [
    //     '_rp_title',
    //     '_rp_number',
    //     '_rp_according_to',
    //     '_rp_order_by',
    //     '_rp_show_type',
    // ];

    register_setting('like-post', '_like_post', 'form_sanitize_input');

    add_settings_section('ls_settings_section', '', '', 'like-post-html');
    add_settings_field('ls_settings_field', '', 'ls_render_form', 'like-post-html', 'ls_settings_section');
}

add_action('admin_init', 'wp_ls_setting_init');

function ls_render_form()
{
    // $rp_title = get_option('_rp_title');
    // $rp_number = get_option('_rp_number');
    // $rp_according_to = get_option('_rp_according_to');
    // $rp_order_by = get_option('_rp_order_by');
    // $rp_show_type = get_option('_rp_show_type');
    $ls_settings = get_option('_like_post');
?>
    <div class="element-wrapper">

        <label class="label-group" for="position-type">نحوه نمایش</label>
        <select id="position-type" name="_like_post[_ls_position_type]">
            <option value="static" class="static" <?php echo selected($ls_settings['_ls_position_type'], 'static') ?>>ثابت</option>
            <option value="fixed" class="fixed" <?php echo selected($ls_settings['_ls_position_type'], 'fixed') ?>>شناور</option>
        </select>

        <label class="label-group" for="color-range">رنگ پس زمینه</label>
        <input id="color-range" type="color" name="_like_post[_ls_bg_color]" value="<?php echo isset($ls_settings['_ls_bg_color']) ? esc_attr($ls_settings['_ls_bg_color']) : '' ?>">

        <div class="input-group">
            <label class="label-group" for="border-r">گردی گوشه ها</label>
            <div>
                <input id="border-r" type="range" name="_like_post[_ls_border_radius]" min="0" max="100" value="<?php echo isset($ls_settings['_ls_border_radius']) ? esc_attr($ls_settings['_ls_border_radius']) : '' ?>">
                <output class="br-range-output"></output>
            </div>
        </div>
        <div class="<?php echo $ls_settings['_ls_position_type'] == 'static' ? 'fixed-position-option' : '' ?>">
            <div class="input-group">
                <label class="label-group" for="border-r">محل نمایش افقی</label>
                <select id="disply-type" name="_like_post[_ls_direction_x]">
                    <option value="right:" <?php echo selected($ls_settings['_ls_direction_x'], 'right:') ?>>سمت راست محتوا (پیشفرض)</option>
                    <option value="left:" <?php echo selected($ls_settings['_ls_direction_x'], 'left:') ?>>سمت چپ محتوا</option>
                </select>
                <label class="label-group" for="">حاشیه از سمت چپ و راست</label>
                <div>
                    <input id="offset-x" type="range" name="_like_post[_ls_offset_x]" min="-1000" max="1000" value="<?php echo isset($ls_settings['_ls_offset_x']) ? esc_attr($ls_settings['_ls_offset_x']) : '' ?>">
                    <output class="offset-x-output"></output>
                </div>
            </div>

            <div class="input-group">
                <label class="label-group" for="border-r">محل نمایش عمودی</label>
                <select id="disply-type" name="_like_post[_ls_direction_y]">
                    <option value="top:" <?php echo selected($ls_settings['_ls_direction_y'], 'top:') ?>>بالا (پیشفرض)</option>
                    <option value="bottom:" <?php echo selected($ls_settings['_ls_direction_y'], 'bottom:') ?>>پایین</option>
                </select>
                <label for="">حاشیه از بالا و پایین</label>
                <div>
                    <input id="offset-y" type="range" name="_like_post[_ls_offset_y]" min="-1000" max="1000" value="<?php echo isset($ls_settings['_ls_offset_y']) ? esc_attr($ls_settings['_ls_offset_y']) : '' ?>">
                    <output class="offset-y-output"></output>
                </div>
            </div>
        </div>
    </div>
<?php
}
// Sanitize Input
function form_sanitize_input($input)
{
    $input['_ls_position_type'] = sanitize_text_field($input['_ls_position_type']);
    $input['_ls_bg_color'] = sanitize_text_field($input['_ls_bg_color']);
    $input['_ls_border_radius'] = sanitize_text_field($input['_ls_border_radius']);
    $input['_ls_direction_x'] = sanitize_text_field($input['_ls_direction_x']);
    $input['_ls_offset_x'] = sanitize_text_field($input['_ls_offset_x']);
    $input['_ls_direction_y'] = sanitize_text_field($input['_ls_direction_y']);
    $input['_ls_offset_y'] = sanitize_text_field($input['_ls_offset_y']);
    return $input;
}
