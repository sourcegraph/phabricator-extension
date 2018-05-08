# Sourcegraph's Phabricator integration

Get code intelligence on Phabricator with Sourcegraph.

Check out our [docs site](https://about.sourcegraph.com/docs/features/phabricator-extension) for more information.

## [Installation](https://https://about.sourcegraph.com/docs/features/phabricator-extension#option-a-single-installation-script)

1. Clone this repository into a sourcegraph folder located in your Phabricator extension directory.

```
git clone -b v1.0 git@github.com:sourcegraph/phabricator-extension-install.git path/to/phabricator/src/extensions/sourcegraph
```

2. Regnerate your dependencies and packaging maps with `./bin/celerity map`. See [how to regenerate static resources](https://secure.phabricator.com/book/phabdev/article/celerity/).

3. [Restart Phabricator](https://secure.phabricator.com/book/phabricator/article/restarting/).

## Quickstart

Sourcegraph's Phabricator integration adds Sourcegraph code intelligence and search to Phabricator diffs and code files, so you get go-to-definition, find-references, hover tooltips, and code search embedded natively into Phabricator.

1. [Update your Sourcegraph site configuration](https://about.sourcegraph.com/docs/config/) to allow scripts on your Phabricator instance to communicate with your Sourcegraph instance:

```
{
   // ...
   "corsOrigin": "$PHABRICATOR_URL"
   // ...
}
```

2. Update the `sourcegraph.url` configuration value to the URL where your Sourcegraph instance is hosted via the Phabricator UI or via the command line.

```
./bin/config set sourcegraph.url https://sourcegraph.example.com
```

## [Full Documentation](https://about.sourcegraph.com/docs/features/phabricator-extension)

Additional configuration details and troubleshooting is located in our [full documentation](https://about.sourcegraph.com/docs/features/phabricator-extension).

## Reporting Issues

We welcome all types of feedback, including:

* Bug reports
* Questions about the product
* Feature requests
* General feedback

Let us know all the things you like, don't like, and would like to see!