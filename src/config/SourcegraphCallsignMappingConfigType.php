<?php

final class SourcegraphCallsignMappingConfigType extends PhabricatorJSONConfigType
{

    const TYPEKEY = 'sourcegraph.callsignMapping';

    public function validateStoredValue(
        PhabricatorConfigOption $option,
        $value) {
        foreach ($value as $index => $spec) {
            if (!is_array($spec)) {
                throw $this->newException(
                    pht(
                        'Sourcegraph callsign mapping configuration is not valid: each entry in ' .
                        'the list must be a dictionary describing a callsign mapping, but ' .
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
                  'Sourcegraph callsign mapping configuration has an invalid mapping '.
                  'specification (at index "%s"): %s.',
                  $index,
                  $ex->getMessage()));
            }
        }
    }
}