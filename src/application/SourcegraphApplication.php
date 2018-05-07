<?php

final class SourcegraphApplication extends PhabricatorApplication
{

    public function getName()
    {
        return pht('Sourcegraph');
    }

    public function getRoutes()
    {
        return array();
    }

    public function __construct()
    {
        $url = rtrim(PhabricatorEnv::getEnvConfig('sourcegraph.url'), '/');
        $bundleUrl = $url . '/.assets/extension/scripts/phabricator.bundle.js';

        CelerityAPI::getStaticResourceResponse()
            ->addContentSecurityPolicyURI('connect-src', $url)
            ->addContentSecurityPolicyURI('script-src', $url);

        Javelin::initBehavior('sourcegraph-config', array(
            'bundleUrl' => $bundleUrl,
            'url' => $url,
        ), 'sourcegraph');
        require_celerity_resource('sourcegraph', 'sourcegraph');
    }
}
