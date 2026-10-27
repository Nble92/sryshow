<?php
/**
 * Render the Frontend layout for Advanced Posts module.
 *
 * @package UABB Advanced Posts Module
 */

/* @var syrCourseLessons $module */

// Force lessoncompleted CPT
$args = [
    'post_type'      => 'lessoncompleted',
    'posts_per_page' => -1,
];

$the_query = new WP_Query($args);

$earned_posts   = [];
$unearned_posts = [];
$user_id        = get_current_user_id();

if ($the_query->have_posts()) {
    while ($the_query->have_posts()) {
        $the_query->the_post();
        $post_id = get_the_ID();

        $has_earned = function_exists('gamipress_has_user_earned_achievement') &&
            gamipress_has_user_earned_achievement($post_id, $user_id);

        if ($has_earned) {
            $earned_posts[] = get_post();
            echo "<script>console.log('User {$user_id} HAS earned post {$post_id}');</script>";
        } else {
            $unearned_posts[] = get_post();
            echo "<script>console.log('User {$user_id} has NOT earned post {$post_id}');</script>";
        }
    }
}
wp_reset_postdata();

// Put earned first, then unearned
$ordered_posts = array_merge($earned_posts, $unearned_posts);

global $post;

if (!empty($ordered_posts)) {
    $post = $ordered_posts[0]; // set global post for template context
}

$supported_type = match ($post->post_type ?? null) {
    'lessoncompleted' => 'lesson',
    'mpcs-course'     => 'course',
    default           => false,
};

if ($supported_type):
    // Determine grid/columns
    $col = ('carousel' === $settings->is_carousel) ? $settings->post_per_grid_desktop : (('feed' === $settings->is_carousel) ? 1 : $settings->post_per_grid);
    ?>
    <div class="uabb-module-content uabb-blog-posts <?php echo wp_kses_post(('carousel' === $settings->is_carousel) ? 'uabb-blog-posts-carousel' : (('grid' === $settings->is_carousel) ? 'uabb-blog-posts-grid' : '')); ?> uabb-post-grid-<?php echo esc_attr($col); ?> <?php echo ('masonary' === $settings->is_carousel) ? ' uabb-blog-posts-masonary ' : ''; ?>">
        
        <?php foreach ($ordered_posts as $post): ?>
            <?php setup_postdata($post);

            $post_id   = get_the_ID();
            $post_type = get_post_type($post_id);
            $content   = get_the_content();
            $image_url = get_the_post_thumbnail_url($post_id, 'full');

            $has_earned = function_exists('gamipress_has_user_earned_achievement') &&
                gamipress_has_user_earned_achievement($post_id, $user_id);
            ?>
            <div class="uabb-blog-posts-col uabb-post-wrapper syr-record-card <?php echo $has_earned ? 'earned' : 'unearned'; ?>">
                <div class="uabb-blog-posts-shadow clearfix">
                    <div class="uabb-blog-post-inner-wrap">
                        <?php include plugin_dir_path(__FILE__) . 'dashboard-frontend.php'; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php wp_reset_postdata(); ?>
    </div>

    <!-- GLOBAL Popup Structure -->
    <div id="global-custom-popup" class="custom-popup-records" style="display:none;">
        <div class="popup-records-message" id="global-popup-message"></div>
        <button class="CloseButtonRecordtape" onclick="closeGlobalPopup()">+</button>
    </div>
    <div class="popup-records-overlay" id="global-popup-overlay" style="display:none;" onclick="closeGlobalPopup()"></div>

    <!-- Popup Scripts -->
    <script>
    function showPopup(postId) {
        var content = document.getElementById('popup-content-' + postId).innerHTML;
        document.getElementById('global-popup-message').innerHTML = content;
        document.getElementById('global-custom-popup').style.display = 'flex';
        document.getElementById('global-popup-overlay').style.display = 'block';

        // Remove existing MediaElement.js instances
        document.querySelectorAll('#global-popup-message .mejs-controls').forEach(el => el.remove());

        // Initialize MediaElement.js player for any audio inside the popup
        const players = document.querySelectorAll('#global-popup-message audio');
        players.forEach(function (player) {
            new MediaElementPlayer(player, {
                features: ['playpause', 'volume', 'progress'],
                success: function (media) {},
                error: function (error) {
                    console.error("Error initializing media player:", error);
                }
            });
        });
    }

    function closeGlobalPopup() {
        document.getElementById('global-custom-popup').style.display = 'none';
        document.getElementById('global-popup-overlay').style.display = 'none';
    }
    </script>
<?php
endif;
?>
