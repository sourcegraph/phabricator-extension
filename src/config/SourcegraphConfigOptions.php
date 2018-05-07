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
        return 'fa-asterisk';
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
                null)
                ->setDescription(pht('URL to Sourcegraph.'))
                ->addExample('https://sourcegraph.example.com', pht('Valid Setting')),
        );
   }
}
