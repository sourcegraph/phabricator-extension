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
        $enabled = PhabricatorEnv::getEnvConfig('sourcegraph.enabled');
        if (!$enabled) {
            return;
        }
        $enableIAP = PhabricatorEnv::getEnvConfig('sourcegraph.enableIAP');

        $url = PhabricatorEnv::getEnvConfig('sourcegraph.url');
        if (!isset($url) || trim($url) === '') {
            return;
        }
        $url = rtrim(PhabricatorEnv::getEnvConfig('sourcegraph.url'), '/');
        $bundleUrl = $url . '/.assets/extension/scripts/phabricator.bundle.js';
        $callsignMappings = PhabricatorEnv::getEnvConfig('sourcegraph.callsignMappings');

        // In order to load the Sourcegraph Phabricator bundle and to fetch content from a Sourcegraph Server
        // instance, the CSP policy must include the Sourcegraph Server instance url.
        $resource = new CelerityStaticResourceResponse();
        if (method_exists($resource, 'addContentSecurityPolicyURI') && is_callable(array($resource, 'addContentSecurityPolicyURI'))) {
            CelerityAPI::getStaticResourceResponse()
                ->addContentSecurityPolicyURI('connect-src', $url)
                ->addContentSecurityPolicyURI('frame-src', $url)
                ->addContentSecurityPolicyURI('script-src', $url);
        }

        Javelin::initBehavior('sourcegraph-config', array(
            'bundleUrl' => $bundleUrl,
            'url' => $url,
            'callsignMappings' => $callsignMappings,
            'enableIAP' => $enableIAP,
        ), 'sourcegraph');
        require_celerity_resource('sourcegraph', 'sourcegraph');
    }
}
