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
        $repo_type = 'sourcegraph.repo';
        $repo_example = array(
            array(
                'path' => 'gorilla/mux',
                'callsign' => 'MUX',
            ),
        );

        $repo_example = id(new PhutilJSON())->encodeAsList(
            $repo_example);

        return array(
            $this->newOption(
                'sourcegraph.url',
                'string',
                null)
                ->setDescription(pht('URL to Sourcegraph.'))
                ->addExample('https://sourcegraph.example.com', pht('Valid Setting')),
            $this->newOption('sourcegraph.repos', $repo_type, array())
                ->setDescription(pht(
                    'This option is only required for repositories defined in `%s` array found in your Sourcegraph site admin configuration.' .
                    "\n\n" .
                    'The object is an array with all elements of the type object. The array object has the following properties:' .
                    "\n\n" .
                    '`%s` (string, required) Display path for the url e.g. `%s`' .
                    "\n\n" .
                    '`%s` (string, required) The unique Phabricator identifier for the repository, like `%s.`'
                    , 'phabricator.repos', 'path', 'my/repo', 'callsign', 'MUX'))
                ->addExample(
                    $repo_example,
                    pht('Simple Example')
                ),
        );
    }
}
