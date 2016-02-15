<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Geo\Form;

use Dms\Common\Structure\Geo\StreetAddressWithLatLng;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\InnerFormType;
use Dms\Core\Form\IForm;

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
    public static function form() : \Dms\Core\Form\IForm
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
    protected function buildProcessors() : array
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