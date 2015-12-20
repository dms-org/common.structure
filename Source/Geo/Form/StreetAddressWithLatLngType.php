<?php

namespace Iddigital\Cms\Common\Structure\Geo\Form;

use Iddigital\Cms\Common\Structure\Geo\StreetAddressWithLatLng;
use Iddigital\Cms\Core\Form\Builder\Form;
use Iddigital\Cms\Core\Form\Field\Builder\Field;
use Iddigital\Cms\Core\Form\Field\Processor\CustomProcessor;
use Iddigital\Cms\Core\Form\Field\Type\InnerFormType;
use Iddigital\Cms\Core\Form\IForm;

/**
 * The string address with lat/lng field type.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class StreetAddressWithLatLngType extends InnerFormType
{
    public function __construct()
    {
        parent::__construct(self::form());
    }

    /**
     * @return IForm
     */
    public static function form()
    {
        return Form::create()
                ->section('Address with lat/lng', [
                        Field::name('address')->label('Address')
                                ->string()
                                ->required(),
                        Field::name('coordinates')->label('Coordinates')
                                ->type(new LatLngType())
                                ->required(),
                ])
                ->build();
    }

    /**
     * @inheritDoc
     */
    protected function buildProcessors()
    {
        return array_merge(parent::buildProcessors(), [
                new CustomProcessor(
                        StreetAddressWithLatLng::type(),
                        function ($input) {
                            return new StreetAddressWithLatLng($input['address'], $input['coordinates']);
                        },
                        function (StreetAddressWithLatLng $address) {
                            return [
                                    'address'     => $address->getAddress(),
                                    'coordinates' => $address->getLatLng(),
                            ];
                        }
                )
        ]);
    }


}