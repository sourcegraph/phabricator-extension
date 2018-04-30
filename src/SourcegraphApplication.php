<?php

final class Sourcegraph extends PhabricatorApplication {

  public function getName() {
      // require_celerity_resource("sourcegraph");
    return pht('Sourcegraph');
  }

    public function getIcon() {
        return 'fa-asterisk';
    }

    public function getShortDescription()    {
        return pht('Code Intelligence and Search');
    }

    public function getBaseURI() {
        return '/sourcegraph-proxy';
    }

    public function getRoutes() {
        return array(
            '/sourcegraph-proxy/.api/(graphql|xlang|telemetry)(/.*)?' => 'SourcegraphProxyController'
        );
    }

}
