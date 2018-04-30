<?php
final class SourcegraphProxyController extends PhabricatorController { 
    public function handleRequest(AphrontRequest $request) {
        // Check for specific HTTP header to protect against CSRF (if the request got here and has this header, then it couldn't
        // be a CORS "simple request" and our existing CORS policy blocks "non-simple requests", so therefore it is same origin).
        if (AphrontRequest::getHTTPHeader("X-Requested-With") === null) {
            return id(new AphrontPlainTextResponse())
                ->setHTTPResponseCode(403)
                ->setContent(pht('Proxied Sourcegraph HTTP requests must have an X-Requested-With header.'));
        }

        // Ensure that proxying is enabled.
        $baseURL = PhabricatorEnv::getEnvConfig('sourcegraph.url');
        if ($baseURL === null) {
            return id(new AphrontPlainTextResponse())
                ->setHTTPResponseCode(404)
                ->setContent(pht('Sourcegraph request was rejected because "sourcegraph.url" is not configured in Phabricator.'));
        }

        // Construct HTTP request to send to Sourcegraph.
        $uri = new PhutilURI($baseURL);
        $forwardPath = explode('/', $request->getPath(), 3)[2];
        $uri->setPath('/' . $forwardPath);
        $uri->setQueryParams(AphrontRequest::flattenData($_GET));
        $input = PhabricatorStartup::getRawInput();
        $future = id(new HTTPSFuture($uri))
                ->setMethod($_SERVER['REQUEST_METHOD'])
                ->write($input);
        id($future)
            ->addHeader('Host', $uri->getDomain())
            ->addHeader('Origin', PhabricatorEnv::getEnvConfig('phabricator.base-uri'));

        // Annotate request with Phabricator user metadata.
        $viewer = $request->getViewer();
        if ($viewer) {
            id($future)
                ->addHeader('X-Phabricator-Forwarded-Username', $viewer->getUserName())
                ->addHeader('X-Phabricator-Forwarded-UserPHID', $viewer->getPHID());
        }

        // Add access token to request.
        $token = PhabricatorEnv::getEnvConfig('sourcegraph.accessTokenExperimentalAndInsecure');
        if ($token !== null) {
            $future->addHeader('Authorization', 'token ' . $token);
        }
        
        // Forward other (whitelisted) request headers.
            $forwardHeaders = array(
				"Accept",
				"Accept-Encoding",
				"Accept-Language",
				"Content-Length",
				"Content-Type",
				"Cache-Control",
                "Pragma",
                "DNT",
                "X-Requested-With",
                "X-Sourcegraph-Client",
                "User-Agent",
                "Referer",
            );
            foreach ($forwardHeaders as $name) {
                $value = AphrontRequest::getHTTPHeader($name);
                if ($value !== null) {
                    $future->addHeader($name, $value);
                }
            }
            
        return id(new AphrontHTTPProxyResponse())
            ->setHTTPFuture($future);
    }
}
