<?php
/* @var syrRecordsDisplay $module */

$user_id = get_current_user_id();

// Get earned achievements
$earned = function_exists('gamipress_get_user_achievements') ? gamipress_get_user_achievements(array(
    'user_id'          => $user_id,
    'achievement_type' => 'lessoncompleted',
)) : array();

$earned_ids = wp_list_pluck($earned, 'post_id');

// Debug: log earned IDs
echo "<script>console.log('Earned IDs for user {$user_id}: " . json_encode($earned_ids) . "');</script>";

// Query ALL lessoncompleted posts
$args = $module->get_args();
$args['post_type'] = 'lessoncompleted';
$args['posts_per_page'] = -1;

$query = new WP_Query($args);

// Separate posts into earned / not earned
$earned_posts = [];
$not_earned_posts = [];

while($query->have_posts()) {
    $query->the_post();
    $post_id = get_the_ID();

    if (in_array($post_id, $earned_ids)) {
        $earned_posts[] = $post_id;
    } else {
        $not_earned_posts[] = $post_id;
    }
}
wp_reset_postdata();

// Reverse earned order (latest earned first)
$earned_posts = array_reverse($earned_posts);

// Split earned into first + others
$first_earned = !empty($earned_posts) ? array_slice($earned_posts, 0, 1) : [];
$other_earned = count($earned_posts) > 1 ? array_slice($earned_posts, 1) : [];

// Merge: first earned → other earned → not earned
$all_posts = array_merge($first_earned, $other_earned, $not_earned_posts);
?>

<style>
    .overlay-tag.cld-tag {
        display: none !important;
    }
    .mejs-container {
        width: auto !important;
        height: auto !important;
    }
</style>

<div class="syr-records-wrapper">
    <div class="record-row">
        <?php 
        $i = 1;
        foreach ($all_posts as $post_id) :
            $post = get_post($post_id);
            setup_postdata($post);

            $content    = get_the_content(null, false, $post);
            $image_url  = get_the_post_thumbnail_url($post_id, 'full');
            $disc_image = get_field("lesson_completed_disc_image", $post_id);

            $has_earned = in_array($post_id, $earned_ids);

            // Debug log each record
            echo "<script>console.log('Post {$post_id} (" . get_the_title($post_id) . ") earned? " . ($has_earned ? "YES" : "NO") . "');</script>";
        ?>

        <div class="record" <?php if($has_earned): ?> onclick="showPopup('<?php echo $post_id; ?>')" <?php endif; ?>>
            <div class="record-image">
                <?php if ($has_earned && $image_url) : ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt="Record Image" width="165" height="162">
                <?php else : ?>
                    <img src="<?php echo esc_url(SYR_MODULES_URL . 'modules/records-archive/images/empty-record.png'); ?>" alt="Locked Record" width="165" height="162">
                <?php endif; ?>
            </div>

            <div class="record-disc">
                <?php if ($has_earned && $disc_image) : ?>
                    <div class="record-disc-achieved">
                        <img src="<?php echo esc_url($disc_image); ?>" alt="Disc Image" width="82" height="160">
                    </div>
                <?php else : ?>
                    <div class="record-disc-empty">
                        <img src="<?php echo esc_url(SYR_MODULES_URL . 'modules/records-archive/images/disc.png'); ?>" alt="Empty Disc">
                    </div>
                <?php endif; ?>
            </div>

            <?php if ($has_earned): ?>
                <div id="popup-content-<?php echo $post_id; ?>" style="display:none;">
                    <?php echo do_shortcode($content); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Popup Modal -->
        <?php if ($has_earned): ?>
            <div class="custom-popup-records" id="custom-popup-<?php echo $post_id; ?>">
                <div class="popup-records-message" id="popup-message-<?php echo $post_id; ?>"></div>
                <button class="CloseButtonRecordtape" onclick="closePopup(<?php echo $post_id; ?>)">+</button>
            </div>
            <div class="popup-records-overlay" id="popup-overlay-<?php echo $post_id; ?>" onclick="closePopup(<?php echo $post_id; ?>)"></div>
        <?php endif; ?>

        <?php 
        if ($i % 4 === 0 && count($all_posts) > 4): ?>
    </div>
    <div class="record-row">
        <?php endif;
        ++$i;
        endforeach; 
        wp_reset_postdata();
        ?>
    </div>
</div>

<script>
function showPopup(postId) {
    var content = document.getElementById('popup-content-' + postId).innerHTML;
    document.getElementById('popup-message-' + postId).innerHTML = content;
    document.getElementById('custom-popup-' + postId).style.display = 'flex';
    document.getElementById('popup-overlay-' + postId).style.display = 'block';

    // Remove existing MediaElement.js instances
    document.querySelectorAll('#popup-message-' + postId + ' .mejs-controls').forEach(el => el.remove());

    // Initialize MediaElement.js player for audio
    const players = document.querySelectorAll('#popup-message-' + postId + ' audio');
    players.forEach(function (player) {
        new MediaElementPlayer(player, {
            features: ['playpause', 'volume', 'progress'],
            success: function (media) {
                console.log("Media player initialized:", media);
            },
            error: function (error) {
                console.error("Error initializing media player:", error);
            }
        });
    });
}

function closePopup(postId) {
    document.getElementById('custom-popup-' + postId).style.display = 'none';
    document.getElementById('popup-overlay-' + postId).style.display = 'none';
}
</script>
