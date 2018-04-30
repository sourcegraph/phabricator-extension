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
        $accessToken = PhabricatorEnv::getEnvConfig('sourcegraph.accessToken');
		// Use PhabricatorEnv::getEnvConfig() to get config values
		$results = array(
			'url' => $url,
			'accessToken' => $accessToken
		);

        return $results;
    }

}

