<?php

final class SourcegraphConduitAPIMethod extends PhabricatorAuthConduitAPIMethod
{

    public function getAPIMethodName()
    {
        return 'sourcegraph.configuration';
    }

    public function getMethodDescription()
    {
        return pht('Query Sourcegraph Configuration.');
    }

    protected function defineParamTypes()
    {
        return array();
    }

    protected function defineReturnType()
    {
        return 'nonempty dict';
    }

    protected function execute(ConduitAPIRequest $request)
    {
        $url = PhabricatorEnv::getEnvConfig('sourcegraph.url');
        $callsignMappings = PhabricatorEnv::getEnvConfig('sourcegraph.callsignMappings');
        $enabled = PhabricatorEnv::getEnvConfig('sourcegraph.enabled');
        $results = array(
            'url' => $url,
            'callsignMappings' => $callsignMappings,
            'enabled' => $enabled,
        );

        return $results;
    }
}
