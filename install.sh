#!/bin/sh

set -e

if [ -z "$1" ] || [ -z "$2" ]; then
	echo "Usage: ./install.sh /path/to/phabricator/root https://sourcegraph.mycompany.com"
	exit 1
fi

if ! php -m | grep -lq 'tokenizer'; then
	if hash zypper 2>/dev/null; then
		echo "PHP has built-in support for tokenizer, but your Phabricator instance does not include it."
		read -p "Install php-tokenizer? [y/n]" -n 1 -r
		echo ""
		if [[ $REPLY =~ ^[Yy]$ ]]; then
			zypper in php5-tokenizer
			echo ""
		else
			echo "Cancelled. See https://about.sourcegraph.com/docs/features/phabricator-extension#organization-wide-installation for more information."
			echo ""
			exit 1
		fi
	else
		echo "php-tokenizer is required for installation. See https://about.sourcegraph.com/docs/features/phabricator-extension#organization-wide-installation for more information."
	fi
fi

echo "Installing Sourcegraph Phabricator integration"
echo ""
./scripts/modify-controller.php $1 $2

cp ./loader.js /tmp/loader.js
echo -e "/**\n* @provides sourcegraph\n*/\n\nwindow.SOURCEGRAPH_PHABRICATOR_EXTENSION = true;\nwindow.SOURCEGRAPH_URL = '$(echo $2)';\n" >/tmp/base.js

pushd $1
mkdir -p ./webroot/rsrc/js/sourcegraph
cat /tmp/base.js /tmp/loader.js >./webroot/rsrc/js/sourcegraph/sourcegraph.js
./bin/celerity map
popd

echo "Success!"
echo ""
echo "You must now restart your Phabricator instance."
echo ""
echo "See https://secure.phabricator.com/book/phabricator/article/restarting/ for more information."
echo ""
echo "Examples:"
echo ""
echo "  sudo service apache2 restart"
echo "  supervisorctl -c /app/supervisord.conf restart php-fpm"
echo "  supervisorctl -c /app/supervisord.conf restart nginx"
echo "  supervisorctl -c /app/supervisord.conf restart nginx-ssl"
