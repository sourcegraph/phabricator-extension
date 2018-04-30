<?php

final class PhabricatorSourcegraphConfigOptions extends PhabricatorApplicationConfigOptions {
    public function getName() {
        return pht('Sourcegraph');
    }

    public function getDescription() {
        return pht('Configure Sourcegraph integration settings.');
    }

    public function getIcon() {
        return 'fa-asterisk';
    }

    public function getGroup() {
        return 'apps';
    }

    public function getOptions() {
        return array(
            $this->newOption('sourcegraph.url', 'string', null)
            	->setDescription(pht('URL to Sourcegraph.'))
				->addExample('https://sourcegraph.example.com', pht('Valid Setting')),
            $this->newOption(
                'sourcegraph.accessTokenExperimentalAndInsecure',
                'string',
                null)
                ->setDescription(pht('Sourcegraph personal access token used to authenticate all requests to the Sourcegraph API by all users. EXPERIMENTAL AND INSECURE: This lets any Phabricator user perform any action on Sourcegraph as the token\'s subject uer.')),
        );
    }
}
