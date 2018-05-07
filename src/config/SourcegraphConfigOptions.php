<?php

final class PhabricatorSourcegraphConfigOptions extends PhabricatorApplicationConfigOptions
{
    public function getName()
    {
        return pht('Sourcegraph');
    }

    public function getDescription()
    {
        return pht('Configure Sourcegraph Settings.');
    }

    public function getIcon()
    {
        return 'fa-cog';
    }

    public function getGroup()
    {
        return 'apps';
    }

    public function getOptions()
    {
        return array(
            $this->newOption(
                'sourcegraph.url',
                'string',
                'http://localhost:3080')
                ->setDescription(pht('Full URL for the Sourcegraph server.')),
            $this->newOption(
                'sourcegraph.accessToken',
                'string',
                '')
                ->setDescription(pht('Global access token (optional)')),
        );
   }
}
