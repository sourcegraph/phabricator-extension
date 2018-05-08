<?php

final class SourcegraphRepoConfigType extends PhabricatorJSONConfigType
{

    const TYPEKEY = 'sourcegraph.repo';

    public function validateStoredValue(
        PhabricatorConfigOption $option,
        $value) {
        foreach ($value as $index => $spec) {
            if (!is_array($spec)) {
                throw $this->newException(
                    pht(
                        'Sourcegraph repository configuration is not valid: each entry in ' .
                        'the list must be a dictionary describing a repository, but ' .
                        'the value with index "%s" is not a dictionary.',
                        $index));
            }
        }
        foreach ($value as $index => $spec) {
            try {
              PhutilTypeSpec::checkMap(
                $spec,
                array(
                  'callsign' => 'string',
                  'path' => 'string',
                ));
            } catch (Exception $ex) {
              throw $this->newException(
                pht(
                  'Sourcegraph repositority configuration has an invalid repository '.
                  'specification (at index "%s"): %s.',
                  $index,
                  $ex->getMessage()));
            }
        }
    }
}