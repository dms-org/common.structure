<?php

namespace Dms\Common\Structure\DateTime\Form;

use Dms\Core\Exception\NotImplementedException;
use Dms\Core\Form\Builder\Form;
use Dms\Core\Form\Field\Builder\Field;
use Dms\Core\Form\Field\Processor\CustomProcessor;
use Dms\Core\Form\Field\Type\InnerFormType;
use Dms\Core\Form\IForm;
use Dms\Core\Model\Type\IType;

/**
 * The date/time range field type base class
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
abstract class DateOrTimeRangeType extends InnerFormType
{
    const START_FIELD_NAME = 'start';
    const END_FIELD_NAME = 'end';
    const ATTR_FORMAT = 'format';

    /**
     * TimeRangeType constructor.
     *
     * @param string $format
     */
    public function __construct($format)
    {
        parent::__construct($this->form($format));
        $this->attributes[self::ATTR_FORMAT] = $format;
    }

    /**
     * @param string $format
     *
     * @return IForm
     * @throws NotImplementedException
     */
    public function form($format)
    {
        return Form::create()
                ->section('Range', [
                        $this->buildRangeInput(Field::name(self::START_FIELD_NAME)->label('Start'), $format)
                                ->required(),
                        $this->buildRangeInput(Field::name(self::END_FIELD_NAME)->label('End'), $format)
                                ->required(),
                ])
                ->fieldLessThanOrEqualAnother(self::START_FIELD_NAME, self::END_FIELD_NAME)
                ->build();
    }

    /**
     * @param Field  $field
     * @param string $format
     *
     * @return Field
     */
    abstract protected function buildRangeInput(Field $field, $format);

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->attributes[self::ATTR_FORMAT];
    }


    /**
     * @inheritDoc
     */
    protected function buildProcessors()
    {
        return array_merge(parent::buildProcessors(), [
                new CustomProcessor(
                        $this->processedRangeType(),
                        function ($input) {
                            return $this->buildRangeObject(
                                    $input[self::START_FIELD_NAME],
                                    $input[self::END_FIELD_NAME]
                            );
                        },
                        function ($range) {
                            return [
                                    self::START_FIELD_NAME => $this->getRangeStart($range),
                                    self::END_FIELD_NAME   => $this->getRangeEnd($range),
                            ];
                        }
                )
        ]);
    }

    /**
     * @return IType
     */
    abstract protected function processedRangeType();

    /**
     * @param mixed $start
     * @param mixed $end
     *
     * @return mixed
     */
    abstract protected function buildRangeObject($start, $end);

    /**
     * @param mixed $range
     *
     * @return mixed
     */
    abstract protected function getRangeStart($range);

    /**
     * @param mixed $range
     *
     * @return mixed
     */
    abstract protected function getRangeEnd($range);
}