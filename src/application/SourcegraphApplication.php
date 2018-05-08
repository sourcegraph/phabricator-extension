<?php

final class SourcegraphApplication extends PhabricatorApplication
{

    public function getName()
    {
        return pht('Sourcegraph');
    }

    public function getShortDescription()
    {
        return pht('Code Intelligence and Search');
    }

    public function getRoutes()
    {
        return array();
    }

    public function __construct()
    {
        $url = rtrim(PhabricatorEnv::getEnvConfig('sourcegraph.url'), '/');
        $bundleUrl = $url . '/.assets/extension/scripts/phabricator.bundle.js';
        $repos = PhabricatorEnv::getEnvConfig('sourcegraph.repos');

        // In order to load the Sourcegraph Phabricator bundle and to fetch content from a Sourcegraph Server
        // instance, the CSP policy must include the Sourcegraph Server instance url.
        CelerityAPI::getStaticResourceResponse()
            ->addContentSecurityPolicyURI('connect-src', $url)
            ->addContentSecurityPolicyURI('script-src', $url);

        Javelin::initBehavior('sourcegraph-config', array(
            'bundleUrl' => $bundleUrl,
            'url' => $url,
            'repos' => $repos
        ), 'sourcegraph');
        require_celerity_resource('sourcegraph', 'sourcegraph');
    }
}
