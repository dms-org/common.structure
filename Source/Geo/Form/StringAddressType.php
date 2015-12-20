<?php

namespace Iddigital\Cms\Common\Structure\Geo\Form;

use Iddigital\Cms\Common\Structure\Geo\LatLng;
use Iddigital\Cms\Common\Structure\Geo\StringAddress;
use Iddigital\Cms\Core\Form\Field\Processor\CustomProcessor;
use Iddigital\Cms\Core\Form\Field\Type\StringType;

/**
 * The string address field type.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StringAddressType extends StringType
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
                            return new StringAddress($input);
                        },
                        function (StringAddress $address) {
                            return $address->asString();
                        }
                )
        ]);
    }


}