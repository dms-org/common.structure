<?php

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\InnerFormType;
use Dms\Core\Form\IForm;

/**
 * The timezoned datetime field type
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class TimezonedDateTimeType extends InnerFormType
{
    const ATTR_FORMAT = 'format';

    /**
     * DateTimeType constructor.
     *
     * @param string $format
     */
    public function __construct($format)
    {
        parent::__construct(self::form($format));
        $this->attributes[self::ATTR_FORMAT] = $format;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->attributes[self::ATTR_FORMAT];
    }


    /**
     * @param string $dateTimeFormat
     *
     * @return IForm
     */
    public static function form($dateTimeFormat)
    {
        static $timezoneIdentifiers;

        if (!$timezoneIdentifiers) {
            $timezoneIdentifiers = \DateTimeZone::listIdentifiers();
            $timezoneIdentifiers = array_combine($timezoneIdentifiers, $timezoneIdentifiers);
        }

        return Form::create()
                ->section('Datetime', [
                        Field::name('datetime')->label('Date/Time')
                                ->datetime($dateTimeFormat)
                                ->required(),
                        Field::name('timezone')->label('Timezone')
                                ->string()
                                ->oneOf($timezoneIdentifiers)
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
                        TimezonedDateTime::type(),
                        function ($input) {
                            return TimezonedDateTime::fromFormat(
                                    'Y-m-d H:i:s',
                                    $input['datetime']->format('Y-m-d H:i:s'),
                                    $input['timezone']
                            );
                        },
                        function (TimezonedDateTime $dateTime) {
                            return [
                                    'datetime' => $dateTime->getNativeDateTime(),
                                    'timezone' => $dateTime->getTimezone()->getName(),
                            ];
                        }
                )
        ]);
    }
}