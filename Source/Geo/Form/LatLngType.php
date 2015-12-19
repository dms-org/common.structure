<?php

namespace Iddigital\Cms\Common\Structure\Geo\Form;

use Iddigital\Cms\Common\Structure\Geo\LatLng;
use Iddigital\Cms\Core\Form\Builder\Form;
use Iddigital\Cms\Core\Form\Field\Builder\Field;
use Iddigital\Cms\Core\Form\Field\Processor\CustomProcessor;
use Iddigital\Cms\Core\Form\Field\Type\InnerFormType;

/**
 * The lat/lng field type.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class LatLngType extends InnerFormType
{
    public function __construct()
    {
        parent::__construct(self::form());
    }

    public static function form()
    {
        return Form::create()
                ->section('Lat/lng', [
                        Field::name('lat')->label('Latitude')
                                ->decimal()
                                ->required()
                                ->min(-90)->max(90),
                        Field::name('lng')->label('Longitude')
                                ->decimal()
                                ->required()
                                ->min(-180)->max(180),
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
                        LatLng::type(),
                        function ($input) {
                            return new LatLng($input['lat'], $input['lng']);
                        },
                        function (LatLng $latLng) {
                            return [
                                    'lat' => $latLng->getLat(),
                                    'lng' => $latLng->getLng(),
                            ];
                        }
                )
        ]);
    }


}