<?php if(!defined('ABSPATH')) {die('You are not allowed to call this page directly.');} ?>

<?php
// ACF custom field for District
$user_district = get_field('user_district', 'user_' . $mepr_current_user->ID);
$user_state = get_field('user_state', 'user_' . $mepr_current_user->ID);
$user_school = get_field('user_school', 'user_' . $mepr_current_user->ID);
$user_city = get_field('user_city', 'user_' . $mepr_current_user->ID);
?>

<div class="mp_wrapper mp_content">
  <?php if(!empty($welcome_message)): ?>
    <div id="mepr-account-welcome-message">
      <?php echo MeprHooks::apply_filters('mepr-account-welcome-message', do_shortcode($welcome_message), $mepr_current_user); ?>
    </div>
  <?php endif; ?>

  <?php if( !empty($mepr_current_user->user_message) ): ?>
    <div id="mepr-account-user-message">
      <?php echo MeprHooks::apply_filters('mepr-user-message', wpautop(do_shortcode($mepr_current_user->user_message)), $mepr_current_user); ?>
    </div>
  <?php endif; ?>

  <?php MeprView::render('/shared/errors', get_defined_vars()); ?>

  <form class="mepr-account-form mepr-form" id="mepr_account_form" action="" method="post" enctype="multipart/form-data" novalidate>
    <input type="hidden" name="mepr-process-account" value="Y" />
    <?php wp_nonce_field( 'update_account', 'mepr_account_nonce' ); ?>

    <?php MeprHooks::do_action('mepr-account-home-before-name', $mepr_current_user); ?>
    <div class="single form-row">
        <?php syrMP::render_custom_fields(['mepr_profile_picture']); ?>
    </div>
    <div class="triple form-row">
        <?php syrMP::render_custom_fields(['mepr_title']); ?>
        <?php if($mepr_options->show_fname_lname): ?>
            <div class="mp-form-row mepr_first_name<?php echo ($mepr_options->require_fname_lname) ? ' mepr-field-required' : ''; ?>">
                <div class="mp-form-label">
                    <label for="user_first_name"><?php _ex('First Name:', 'ui', 'memberpress'); echo ($mepr_options->require_fname_lname)?'*':''; ?></label>
                    <span class="cc-error"><?php _ex('First Name Required', 'ui', 'memberpress'); ?></span>
                </div>
                <input type="text" name="user_first_name" id="user_first_name" class="mepr-form-input" value="<?php echo esc_attr($mepr_current_user->first_name); ?>" <?php echo ($mepr_options->require_fname_lname)?'required':''; ?> />
            </div>
            <div class="mp-form-row mepr_last_name<?php echo ($mepr_options->require_fname_lname) ? ' mepr-field-required' : ''; ?>">
                <div class="mp-form-label">
                    <label for="user_last_name"><?php _ex('Last Name:', 'ui', 'memberpress'); echo ($mepr_options->require_fname_lname)?'*':''; ?></label>
                    <span class="cc-error"><?php _ex('Last Name Required', 'ui', 'memberpress'); ?></span>
                </div>
                <input type="text" id="user_last_name" name="user_last_name" class="mepr-form-input" value="<?php echo esc_attr($mepr_current_user->last_name); ?>" <?php echo ($mepr_options->require_fname_lname)?'required':''; ?> />
            </div>
        <?php else: ?>
            <input type="hidden" name="user_first_name" value="<?php echo esc_attr($mepr_current_user->first_name); ?>" />
            <input type="hidden" name="user_last_name" value="<?php echo esc_attr($mepr_current_user->last_name); ?>" />
        <?php endif; ?>
    </div>
    <div class="double form-row">
        <div class="mp-form-row mepr_email mepr-field-required">
            <div class="mp-form-label">
                <label for="user_email"><?php _ex('Email:*', 'ui', 'memberpress');  ?></label>
                <span class="cc-error"><?php _ex('Invalid Email', 'ui', 'memberpress'); ?></span>
            </div>
            <input type="email" id="user_email" name="user_email" class="mepr-form-input" value="<?php echo esc_attr($mepr_current_user->user_email); ?>" required />
        </div>
        <?php
            syrMP::render_custom_fields(['mepr_phone_number', 'mepr_gender']);
            MeprHooks::do_action('mepr-account-home-fields', $mepr_current_user);
        ?>
    </div>

    <div class="user_profile_show">
        <div class="mp-form-row mepr_user_district">
            <div class="mp-form-label">
                <label for="user_district"><?php _e('District', 'your-textdomain'); ?></label>
            </div>

            <input type="text" id="user_district" name="user_district" class="mepr-form-input" value="<?php echo esc_attr($user_district); ?>" />
        </div>
        <div class="mp-form-row mepr_user_state">
            <div class="mp-form-label">
                <label for="user_state"><?php _e('State', 'your-textdomain'); ?></label>
            </div>

            <input type="text" id="user_state" name="user_state" class="mepr-form-input" value="<?php echo esc_attr($user_state); ?>" />
        </div>
        <div class="mp-form-row mepr_user_school">
            <div class="mp-form-label">
                <label for="user_school"><?php _e('School', 'your-textdomain'); ?></label>
            </div>

            <input type="text" id="user_school" name="user_school" class="mepr-form-input" value="<?php echo esc_attr($user_school); ?>" />
        </div>
        <div class="mp-form-row mepr_user_city">
            <div class="mp-form-label">
                <label for="user_city"><?php _e('City', 'your-textdomain'); ?></label>
            </div>

            <input type="text" id="user_city" name="user_city" class="mepr-form-input" value="<?php echo esc_attr($user_city); ?>" />
        </div>
    </div>

    <div class="mepr_spacer">&nbsp;</div>

    <input type="submit" name="mepr-account-form" value="<?php _ex('Save Profile', 'ui', 'memberpress'); ?>" class="mepr-submit mepr-share-button" />
    <img src="<?php echo admin_url('images/loading.gif'); ?>" alt="<?php _e('Loading...', 'memberpress'); ?>" style="display: none;" class="mepr-loading-gif" />
    <?php MeprView::render('/shared/has_errors', get_defined_vars()); ?>
  </form>

  <div class="mepr_spacer">&nbsp;</div>

  <?php MeprHooks::do_action('mepr_account_home', $mepr_current_user); ?>
</div>
