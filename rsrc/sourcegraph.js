/**
* @provides sourcegraph
*/

window.SOURCEGRAPH_PHABRICATOR_EXTENSION = true;

/**
 * To prevent loading the extension for all users, specifify a user whitelist
 * by changing this line to `var userWhitelist = { "username": true, ... };`
 */
var userWhitelist = undefined;

var sourcegraphURL = window.SOURCEGRAPH_URL || window.localStorage.SOURCEGRAPH_URL

/**
 * Scrapes a Phabricator username from the DOM.
 */
function getPhabricatorUsername() {
  var USERNAME_URL_PATTERN = /\/p\/([A-Z0-9-_]+)/i;
  var coreMenuItems = document.getElementsByClassName(
    'phabricator-core-user-menu'
  );
  for (var i = 0; i < coreMenuItems.length; i++) {
    var coreMenuItem = coreMenuItems.item(i);
    var possiblePersonUrl = coreMenuItem.getAttribute('href');
    if (!possiblePersonUrl) {
      continue;
    }
    var match = USERNAME_URL_PATTERN.exec(possiblePersonUrl);
    if (!match) {
      continue;
    }
    return match[1];
  }
  console.warn('Unable to getPhabricatorUsername from DOM.');
  return null;
}

function injectIAPHandler() {
  let iapRefresher = document.getElementById('sourcegraph-iap-refresh');
  if (!iapRefresher) {
    iapRefresher = document.createElement('iframe');
    iapRefresher.style = 'width:0;height:0;border:0; border:none;';
    iapRefresher.id = 'sourcegraph-iap-refresh';
    iapRefresher.src = `${sourcegraphURL}/_gcp_iap/session_refresher`;
    document.body.appendChild(iapRefresher);
  }
}

function inject() {
  if (document.readyState === 'complete' || document.readyState === 'interactive') {
    load();
  } else {
    document.addEventListener('DOMContentLoaded', load);
  }
}

function load() {
  if (window.ENABLE_IAP || window.localStorage.ENABLE_IAP) {
    injectIAPHandler();
  }

  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.defer = true;
  script.src =
    sourcegraphURL + '/.assets/extension/scripts/phabricator.bundle.js';
  document.getElementsByTagName('head')[0].appendChild(script);
}

if (userWhitelist) {
  // Load the extension iff the current user is on the whitelist.
  var username = getPhabricatorUsername();
  if (username && userWhitelist[username]) {
    inject();
  }
} else {
  inject();
}
