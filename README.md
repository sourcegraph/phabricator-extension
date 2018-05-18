# Sourcegraph Phabricator integration

Sourcegraph's Phabricator integration adds Sourcegraph code intelligence and search to Phabricator diffs and code files, so you get go-to-definition, find-references, hover tooltips, and code search embedded natively into Phabricator.

## [Installation]

1. Clone this repository to `phabricator/src/extensions/sourcegraph` (inside your Phabricator installation directory). See [Phabricator's adding new classes and extensions docs](https://secure.phabricator.com/book/phabcontrib/article/adding_new_classes/) for more information.

```
git clone -b release-v1.0 https://github.com/sourcegraph/phabricator-extension.git phabricator/src/extensions/sourcegraph
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

## Configuration

You can update the Phabricator integration's configuration via the command line or **Application Settings** in your Phabricator instance.

### `sourcegraph.url` (string)

URL to Sourcegraph Server.

For example:

```shell
'https://sourcegraph.example.com'
```

### `sourcegraph.repos` (array)

If your Phabricator installation mirrors repositories from a different origin than Sourcegraph, you must specify a list of repository `paths`s (as displayed on Sourcegraph)
and their corresponding Phabricator `callsign`s.

An array of objects, each mapping a Phabricator repository\'s callsign to the corresponding repository on Sourcegraph. Each object contains the following properties:

* `path` **(string, required)** The path of the repository on Sourcegraph.

* `callsign` **(string, required)** The Phabricator callsign for the repository.

For example:

```shell
'[{"path": "gitolite.example.org/foobar", "callsign": "FOO"}]'
```

### Restarting Phabricator

How to restart Phabricator depends on how you installed it. Usually it is one of the following commands:

* `sudo service apache2 restart`
* `supervisorctl -c /app/supervisord.conf restart php-fpm`
* `supervisorctl -c /app/supervisord.conf restart nginx`
* `supervisorctl -c /app/supervisord.conf restart nginx-ssl`

If Phabricator is running via [Bitnami's docker image](https://github.com/bitnami/bitnami-docker-phabricator) use:

* `bin/phd restart` inside your Phabricator installation directory.

See [Phabricator's restart
docs](https://secure.phabricator.com/book/phabricator/article/restarting/) for more information.

## Supported Versions

* [Phabricator](https://github.com/phacility/phabricator) stable builds after January 2017
* [Bitnami](https://github.com/bitnami/bitnami-docker-phabricator) Docker tags after 2017.09-r1
* [RedpointGames](https://github.com/RedpointGames/phabricator) Docker images

## Known issues

### Staging areas

When you commit a code change and run `arc diff` to push your changes to Phabricator, only the change's diff gets pushed.
This means unless you run `git push` on your own, your commits won't be pushed to your remote repo. Because of this, Sourcegraph
and other tools using this diff's information won't be able to find the contents of the diff. To get around this, Phabricator has an experimental
feature called **staging areas**.

Staging areas are Git repositories that store all of the information for a given diff so that its position in a Git repository's
history isn't lost. [Learn more about Phabricator staging areas and how to enable them.](https://secure.phabricator.com/book/phabricator/article/harbormaster/#change-handoff)

If there is no staging area enabled and we can't resolve the commit, Sourcegraph tries to apply the diff's patch set to simulate a staging area.
This will work _most_ of the time. However, there are several cases where this will fail. Two examples of cases where this would fail is when you
run `arc diff` on a base that isn't in master or if you created a diff from the Phabricator UI. The only way to ensure reliable code intelligence
on all Phabricator diffs is to enable staging areas for your repositories.

## Reporting issues

For issues with or feature requests for this integration, [file an issue](https://github.com/sourcegraph/phabricator-extension-install/issues). For any other issues or feedback related to Sourcegraph, use [sourcegraph/issues](https://github.com/sourcegraph/issues).