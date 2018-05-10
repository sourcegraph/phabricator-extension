# Sourcegraph Phabricator integration

Sourcegraph's Phabricator integration adds Sourcegraph code intelligence and search to Phabricator diffs and code files, so you get go-to-definition, find-references, hover tooltips, and code search embedded natively into Phabricator.

Check out our [docs site](https://about.sourcegraph.com/docs/features/phabricator-extension) for more information.

## [Installation](https://https://about.sourcegraph.com/docs/features/phabricator-extension#option-a-single-installation-script)

1. Clone this repository to `phabricator/src/extensions/sourcegraph` (inside your Phabricator installation directory).

```
git clone -b release-v1.0 https://github.com/sourcegraph/phabricator-extension-install.git phabricator/src/extensions/sourcegraph
```

2. Run `bin/celerity map` to [add the static CSS/JS assets](https://secure.phabricator.com/book/phabcontrib/article/adding_new_css_and_js/).

3. [Restart Phabricator](https://secure.phabricator.com/book/phabricator/article/restarting/).

## Quickstart

1. [Update the Sourcegraph site configuration](https://about.sourcegraph.com/docs/config/) to allow scripts on your Phabricator instance to communicate with your Sourcegraph instance:

```
{
   // ...
   "corsOrigin": "$PHABRICATOR_URL"
   // ...
}
```

2. Set the Phabricator `sourcegraph.url` configuration value to your Sourcegraph URL.

## [Full Documentation](https://about.sourcegraph.com/docs/features/phabricator-extension)

Additional configuration details and troubleshooting steps are in our [full documentation](https://about.sourcegraph.com/docs/features/phabricator-extension).

## Reporting issues

For issues with or feature requests for this integration, [file an issue](https://github.com/sourcegraph/phabricator-extension-install/issues). For any other issues or feedback related to Sourcegraph, use [sourcegraph/issues](https://github.com/sourcegraph/issues).