<?php
/**
 * Axeptio (Axeptio Support) for gtm4wp
 *
 * This integration added Axeptio support
 *
 * @author  Olivier Gorzalka <https://github.com/AmphiBee/>
 * @package GTM4WP
 */

add_action('wp_head', function () {
	$gtm4wp_options = $GLOBALS['gtm4wp_options'];
	$axeptioSettings = array(
		'clientId' => $gtm4wp_options[GTM4WP_OPTION_INTEGRATE_AXEPTIO . '-projectID'],
		'cookiesVersion' => $gtm4wp_options[GTM4WP_OPTION_INTEGRATE_AXEPTIO . '-version']
	);

	if (isset($GLOBALS['gtm4wp_options'][GTM4WP_OPTION_INTEGRATE_CONSENTMODE]) && $GLOBALS['gtm4wp_options'][GTM4WP_OPTION_INTEGRATE_CONSENTMODE]) {
		$axeptioSettings['googleConsentMode'] = array(
			'default' => array(
				'ad_storage' => $gtm4wp_options[ GTM4WP_OPTION_INTEGRATE_CONSENTMODE_ANALYTICS ] ? 'granted' : 'denied',
				'ad_user_data' => $gtm4wp_options[ GTM4WP_OPTION_INTEGRATE_CONSENTMODE_AD_USER_DATA ] ? 'granted' : 'denied',
				'ad_personalization' => $gtm4wp_options[ GTM4WP_OPTION_INTEGRATE_CONSENTMODE_AD_PERSO ] ? 'granted' : 'denied',
				'functionality_storage' => $gtm4wp_options[ GTM4WP_OPTION_INTEGRATE_CONSENTMODE_FUNC ] ? 'granted' : 'denied',
				'security_storage' => $gtm4wp_options[ GTM4WP_OPTION_INTEGRATE_CONSENTMODE_SECURUTY ] ? 'granted' : 'denied',
				'personalization_storage' => $gtm4wp_options[ GTM4WP_OPTION_INTEGRATE_CONSENTMODE_PERSO ] ? 'granted' : 'denied',
				'wait_for_update' => 500
			)
		);
	}

	?>
	<script>
		window.axeptioSettings = <?php echo wp_json_encode($axeptioSettings); ?>;

		(function (d, s) {
			var t = d.getElementsByTagName(s)[0], e = d.createElement(s);
			e.async = true;
			e.src = "//static.axept.io/sdk.js";
			t.parentNode.insertBefore(e, t);
		})(document, "script");
	</script>
	<?php
});
