/**
 * @provides javelin-behavior-sourcegraph-config
 */

JX.behavior('sourcegraph-config', function(config) {
	if (config.url) {
			window.SOURCEGRAPH_URL = config.url;
			window.localStorage.SOURCEGRAPH_URL = config.url;
	}
	if (config.bundleUrl) {
			window.SOURCEGRAPH_BUNDLE_URL = config.bundleUrl;
			window.localStorage.SOURCEGRAPH_BUNDLE_URL = config.bundleUrl;
	}
	if (config.callsignMappings) {
		window.PHABRICATOR_CALLSIGN_MAPPINGS = JSON.stringify(config.callsignMappings);
		window.localStorage.PHABRICATOR_CALLSIGN_MAPPINGS = JSON.stringify(config.callsignMappings);
	}
	console.log(`config`, config);
	if (config.enableIAP) {
		console.log(`enableIAP`, config.enableIAP);
	}
});
