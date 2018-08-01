/**
 * @provides javelin-behavior-sourcegraph-config
 */

JX.behavior('sourcegraph-config', function(config) {
	const url = config.url
	if (url) {
		window.SOURCEGRAPH_URL = url;
		window.localStorage.SOURCEGRAPH_URL = url;
	}
	if (config.bundleUrl) {
			window.SOURCEGRAPH_BUNDLE_URL = config.bundleUrl;
			window.localStorage.SOURCEGRAPH_BUNDLE_URL = config.bundleUrl;
	}
	if (config.callsignMappings) {
		window.PHABRICATOR_CALLSIGN_MAPPINGS = JSON.stringify(config.callsignMappings);
		window.localStorage.PHABRICATOR_CALLSIGN_MAPPINGS = JSON.stringify(config.callsignMappings);
	}
	window.ENABLE_IAP = config.enableIAP
	window.localStorage.ENABLE_IAP = config.enableIAP
});
