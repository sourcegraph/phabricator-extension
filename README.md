# Sourcegraph extension for Phabricator

Get code intelligence on Phabricator with Sourcegraph.

Check out our [docs site](https://about.sourcegraph.com/docs/features/phabricator-extension) for more information.

## [Installation](https://https://about.sourcegraph.com/docs/features/phabricator-extension#option-a-single-installation-script)

1. To install Sourcegraph on your Phabricator instance run `./install.sh <path/to/phabricator/root> <sourcegraph url>` inside your Phabricator instance.
2. Restart Phabricator instance.

Requires PHP 5.5 or newer and `php-tokenizer` (a default PHP extension).

*You may delete this repository after installation*

## [Manual Installation](https://about.sourcegraph.com/docs/features/phabricator-extension#option-b-manual-installation)

1. To manually install Sourcegraph view our [documentation](https://about.sourcegraph.com/docs/features/phabricator-extension)

## Uninstall

1. To uninstall Sourcegraph on your Phabricator instance run `./uninstall.sh <path/to/phabricator/root>` inside your Phabricator instance.
2. Restart Phabricator instance.

## Requirements

The installation script requires PHP 5.5 or newer and `php-tokenizer` (a default PHP extension).

If you installed Phabricator using [RedpointGames/phabricator](https://github.com/RedpointGames/phabricator)
Docker command your instance will not have the default extension enabled. The installation script will prompt you to install.
