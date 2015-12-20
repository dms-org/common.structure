<?php

namespace Dms\Common\Structure\Geo\Form;

use Dms\Common\Structure\Geo\LatLng;
use Dms\Common\Structure\Geo\StreetAddress;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\StringType;

/**
 * The string address field type.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressType extends StringType
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @inheritDoc
     */
    protected function buildProcessors()
    {
        return array_merge(parent::buildProcessors(), [
                new CustomProcessor(
                        LatLng::type(),
                        function ($input) {
                            return new StreetAddress($input);
                        },
                        function (StreetAddress $address) {
                            return $address->asString();
                        }
                )
        ]);
    }


}