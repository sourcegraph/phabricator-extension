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
});
