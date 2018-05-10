<?php

/**
 * Defines Sourcegraph's static resources.
 */
final class CeleritySourcegraphResources extends CelerityResourcesOnDisk
{

    public function getName()
    {
        return 'sourcegraph';
    }

    public function getPathToResources()
    {
        return $this->getSourcegraphPath('../rsrc');
    }

    public function getPathToMap()
    {
        return $this->getSourcegraphPath('celerity/map.php');
    }

    /**
     * @param string $to_file
     */
    private function getSourcegraphPath($to_file)
    {
        return (phutil_get_library_root('sourcegraph')) . '/' . $to_file;
    }
}
