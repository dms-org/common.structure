<?php declare(strict_types = 1);

namespace Dms\Common\Structure\Geo\Form;

use Dms\Common\Structure\Geo\LatLng;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\InnerFormType;
use Dms\Core\Form\IForm;

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

    /**
     * @return IForm
     */
    public static function form() : \Dms\Core\Form\IForm
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
    protected function buildProcessors() : array
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