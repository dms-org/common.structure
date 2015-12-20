<?php

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\DateTime\TimeRange;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\IForm;

/**
 * The time range field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimeRangeType extends DateOrTimeRangeType
{
    /**
     * @param string $format
     *
     * @return IForm
     */
    public static function form($format)
    {
        return Form::create()
                ->section('Time Range', [
                        Field::name('start_time')->label('Start')
                                ->time($format)
                                ->required(),
                        Field::name('end_time')->label('End')
                                ->time($format)
                                ->required(),
                ])
                ->fieldLessThanOrEqualAnother('start_time', 'end_time')
                ->build();
    }

    /**
     * @inheritDoc
     */
    protected function buildProcessors()
    {
        return array_merge(parent::buildProcessors(), [
                new CustomProcessor(
                        TimeRange::type(),
                        function ($input) {
                            return new TimeRange(
                                    TimeOfDay::fromNative($input['start_time']),
                                    TimeOfDay::fromNative($input['end_time'])
                            );
                        },
                        function (TimeRange $range) {
                            return [
                                    'start_time' => $range->getStart()->getNativeDateTime(),
                                    'end_time'   => $range->getEnd()->getNativeDateTime(),
                            ];
                        }
                )
        ]);
    }
}