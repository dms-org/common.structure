<?php

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\DateTimeRange;
use Dms\Common\Structure\DateTime\TimezonedDateTimeRange;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\IForm;

/**
 * The timezoned datetime range field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeRangeType extends DateOrTimeRangeType
{
    /**
     * @param string $format
     *
     * @return IForm
     */
    public static function form($format)
    {
        return Form::create()
                ->section('Date/Time Range', [
                        Field::name('start')->label('Start')
                                ->type(new TimezonedDateTimeType($format))
                                ->required(),
                        Field::name('end')->label('End')
                                ->type(new TimezonedDateTimeType($format))
                                ->required(),
                ])
                ->fieldLessThanOrEqualAnother('start', 'end')
                ->build();
    }

    /**
     * @inheritDoc
     */
    protected function buildProcessors()
    {
        return array_merge(parent::buildProcessors(), [
                new CustomProcessor(
                        DateTimeRange::type(),
                        function ($input) {
                            return new TimezonedDateTimeRange(
                                    $input['start'],
                                    $input['end']
                            );
                        },
                        function (TimezonedDateTimeRange $range) {
                            return [
                                    'start' => $range->getStart(),
                                    'end'   => $range->getEnd(),
                            ];
                        }
                )
        ]);
    }
}