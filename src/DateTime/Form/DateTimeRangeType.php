<?php

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\DateTimeRange;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\IForm;

/**
 * The datetime range field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeRangeType extends DateOrTimeRangeType
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
                        Field::name('start_datetime')->label('Start')
                                ->datetime($format)
                                ->required(),
                        Field::name('end_datetime')->label('End')
                                ->datetime($format)
                                ->required(),
                ])
                ->fieldLessThanOrEqualAnother('start_datetime', 'end_datetime')
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
                            return new DateTimeRange(
                                    new DateTime($input['start_datetime']),
                                    new DateTime($input['end_datetime'])
                            );
                        },
                        function (DateTimeRange $range) {
                            return [
                                    'start_datetime' => $range->getStart()->getNativeDateTime(),
                                    'end_datetime'   => $range->getEnd()->getNativeDateTime(),
                            ];
                        }
                )
        ]);
    }
}