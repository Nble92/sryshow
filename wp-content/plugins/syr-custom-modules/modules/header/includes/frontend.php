<?php /* @var syrCustomHeader $module */ ?>
<?php
$user_id = get_current_user_id();
$custom_avatar = get_field('profile_image', 'user_' . $user_id);

if ($custom_avatar) {
    // If the field is an image (returns array), use the 'url' key
    $avatar_url = is_array($custom_avatar) ? $custom_avatar['url'] : $custom_avatar;
} else {
    // Fallback to default avatar
    $avatar_url = home_url('/wp-content/uploads/2025/04/avatar_image.png');
}
?>
<div class="syr-header-module">
    <div class="profile-menu">
        <div class="fl-menu">
            <ul class="menu">
                <li class="menu-item fl-has-submenu">
                    <div class="fl-has-submenu-container user-details">
                        <div class="meta">
                            <h4 class="name"><?php echo esc_html(wp_get_current_user()->first_name); ?></h4>
                        </div>
                        <div class="thumbnail">
                            <?php //echo get_avatar(get_current_user_id(), 64); ?>
                            <img src="<?php echo esc_url($avatar_url); ?>" alt="Avatar" width="64" height="64" />

                        </div>

                    </div>
                    <ul class="sub-menu">
                        <li class="menu-item">
                            <a href="<?php echo esc_url(home_url('/profile')); ?>"><?php _e( 'Profile', 'syr-lms' ); ?></a>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo esc_url(home_url('/settings')); ?>"><?php _e( 'Settings', 'syr-lms' ); ?></a>
                        </li>
                        <?php if (is_user_logged_in()): ?>
                            <li class="menu-item">
                                <a href="<?php echo esc_url(wp_logout_url(home_url('/login'))); ?>"><?php _e( 'Log Out', 'syr-lms' ); ?></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>