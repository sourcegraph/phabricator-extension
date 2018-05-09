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
        $callsign_mapping_type = 'sourcegraph.callsignMapping';

        return array(
            $this->newOption(
                'sourcegraph.url',
                'string',
                null)
                ->setDescription(pht('URL to Sourcegraph.'))
                ->addExample('https://sourcegraph.example.com', pht('Valid Setting')),
            $this->newOption('sourcegraph.callsignMappings', $callsign_mapping_type, array())
                ->setDescription(pht(
                    'f your Phabricator installation mirrors repositories from a different origin than Sourcegraph, you must specify a list of repository `%s`s (as displayed on Sourcegraph)' .
                    'and their corresponding Phabricator `%s`s' .
                    "\n\n" .
                    'An array of objects, each mapping a Phabricator repository\'s callsign to the corresponding repository on Sourcegraph. Each object contains the following properties:' .
                    "\n\n" .
                    '`%s` (string, required) The path of the repository on Sourcegraph' .
                    "\n\n" .
                    '`%s` (string, required) The Phabricator callsign for the repository'
                    , 'path', 'callsign' , 'phabricator.repos', 'path', 'callsign'))
                ->addExample(
                    id(new PhutilJSON())->encodeAsList(
                        array(
                            array(
                                'path' => 'gitolite.example.org/foobar',
                                'callsign' => 'FOO',
                            ),
                        )
                    ),
                    pht('Simple Example')
                ),
        );
    }
}
