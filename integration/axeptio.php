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
