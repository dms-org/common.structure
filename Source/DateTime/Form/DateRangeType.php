<?php

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\DateRange;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\IForm;

/**
 * The date range field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateRangeType extends DateOrTimeRangeType
{
    /**
     * @param string $format
     *
     * @return IForm
     */
    public static function form($format)
    {
        return Form::create()
                ->section('Date Range', [
                        Field::name('start_date')->label('Start')
                                ->date($format)
                                ->required(),
                        Field::name('end_date')->label('End')
                                ->date($format)
                                ->required(),
                ])
                ->fieldLessThanOrEqualAnother('start_date', 'end_date')
                ->build();
    }

    /**
     * @inheritDoc
     */
    protected function buildProcessors()
    {
        return array_merge(parent::buildProcessors(), [
                new CustomProcessor(
                        DateRange::type(),
                        function ($input) {
                            return new DateRange(
                                    Date::fromNative($input['start_date']),
                                    Date::fromNative($input['end_date'])
                            );
                        },
                        function (DateRange $range) {
                            return [
                                    'start_date' => $range->getStart()->getNativeDateTime(),
                                    'end_date'   => $range->getEnd()->getNativeDateTime(),
                            ];
                        }
                )
        ]);
    }
}