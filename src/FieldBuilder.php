<?php declare(strict_types = 1);

namespace Dms\Common\Structure;

use Dms\Common\Structure\Colour\Form\ColourType;
use Dms\Common\Structure\Colour\Form\TransparentColourType;
use Dms\Common\Structure\DateTime\Date;
use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\DateTime\Form\Builder\DateFieldBuilder;
use Dms\Common\Structure\DateTime\Form\Builder\DateTimeFieldBuilder;
use Dms\Common\Structure\DateTime\Form\Builder\TimeOfDayFieldBuilder;
use Dms\Common\Structure\DateTime\Form\Builder\TimezonedDateTimeFieldBuilder;
use Dms\Common\Structure\DateTime\Form\DateRangeType;
use Dms\Common\Structure\DateTime\Form\DateTimeRangeType;
use Dms\Common\Structure\DateTime\Form\DateTimeType;
use Dms\Common\Structure\DateTime\Form\DateType;
use Dms\Common\Structure\DateTime\Form\TimeOfDayType;
use Dms\Common\Structure\DateTime\Form\TimeRangeType;
use Dms\Common\Structure\DateTime\Form\TimezonedDateTimeRangeType;
use Dms\Common\Structure\DateTime\Form\TimezonedDateTimeType;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\DateTime\TimezonedDateTime;
use Dms\Common\Structure\FileSystem\Form\Builder\FileUploadFieldBuilder;
use Dms\Common\Structure\FileSystem\Form\Builder\ImageUploadFieldBuilder;
use Dms\Common\Structure\FileSystem\Form\FileUploadType;
use Dms\Common\Structure\FileSystem\Form\ImageUploadType;
use Dms\Common\Structure\Geo\Form\LatLngType;
use Dms\Common\Structure\Geo\Form\StreetAddressType;
use Dms\Common\Structure\Geo\Form\StreetAddressWithLatLngType;
use Dms\Common\Structure\Table\Form\Builder\TableCellClassDefiner;
use Dms\Common\Structure\Web\Form\EmailAddressType;
use Dms\Common\Structure\Web\Form\HtmlType;
use Dms\Common\Structure\Web\Form\IpAddressType;
use Dms\Common\Structure\Web\Form\UrlType;
use Dms\Core\Exception\InvalidArgumentException;
use Dms\Core\Form\Field\Builder\ArrayOfFieldBuilder;
use Dms\Core\Form\Field\Builder\BoolFieldBuilder;
use Dms\Core\Form\Field\Builder\DecimalFieldBuilder;
use Dms\Core\Form\Field\Builder\EntityArrayFieldBuilder;
use Dms\Core\Form\Field\Builder\EntityFieldBuilder;
use Dms\Core\Form\Field\Builder\Field as InnerFieldBuilder;
use Dms\Core\Form\Field\Builder\FieldBuilderBase;
use Dms\Core\Form\Field\Builder\InnerFormFieldBuilder;
use Dms\Core\Form\Field\Builder\IntFieldBuilder;
use Dms\Core\Form\Field\Builder\StringFieldBuilder;
use Dms\Core\Form\IField;
use Dms\Core\Form\IFieldProcessor;
use Dms\Core\Form\IForm;
use Dms\Core\Model\IEntitySet;
use Dms\Core\Model\Type\IType;

/**
 * The field builder class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class FieldBuilder
{
    /**
     * @var InnerFieldBuilder
     */
    protected $field;

    /**
     * FieldBuilder constructor.
     *
     * @param string $name
     * @param string $label
     */
    public function __construct(string $name, string $label)
    {
        $this->field = InnerFieldBuilder::name($name)->label($label);
    }

    //region String Fields

    /**
     * Validates the input as a string.
     *
     * @return StringFieldBuilder
     */
    public function string() : StringFieldBuilder
    {
        return $this->field->string();
    }

    /**
     * Validates the input as a email address and
     * converts it to an EmailAddress instance.
     *
     * @see \Dms\Common\Structure\Web\EmailAddress
     *
     * @return StringFieldBuilder
     */
    public function email() : StringFieldBuilder
    {
        return new StringFieldBuilder($this->field->type(new EmailAddressType()));
    }

    /**
     * Validates the input as html and
     * converts it to an Html instance.
     *
     * @see \Dms\Common\Structure\Web\Html
     *
     * @return StringFieldBuilder
     */
    public function html() : StringFieldBuilder
    {
        return new StringFieldBuilder($this->field->type(new HtmlType()));
    }

    /**
     * Validates the input as an ip address and
     * converts it to an IpAddress instance.
     *
     * @see \Dms\Common\Structure\Web\IpAddress
     *
     * @return StringFieldBuilder
     */
    public function ipAddress() : StringFieldBuilder
    {
        return new StringFieldBuilder($this->field->type(new IpAddressType()));
    }

    /**
     * Validates the input as a url and
     * converts it to an Url instance.
     *
     * @see \Dms\Common\Structure\Web\Url
     *
     * @return StringFieldBuilder
     */
    public function url() : StringFieldBuilder
    {
        return new StringFieldBuilder($this->field->type(new UrlType()));
    }
    //endregion

    //region Numeric Fields

    /**
     * Validates the input as a integer.
     *
     * @return IntFieldBuilder
     */
    public function int() : IntFieldBuilder
    {
        return $this->field->int();
    }

    /**
     * Validates the input as a decimal (float).
     *
     * @return DecimalFieldBuilder
     */
    public function decimal() : DecimalFieldBuilder
    {
        return $this->field->decimal();
    }
    //endregion

    //region Boolean Fields

    /**
     * Validates the input as a boolean.
     *
     * @return BoolFieldBuilder
     */
    public function bool() : BoolFieldBuilder
    {
        return $this->field->bool();
    }

    //endregion

    //region Date/Time Fields

    /**
     * Validates the input with the supplied format and
     * converts the input to a Date instance.
     *
     * @see \Dms\Common\Structure\DateTime\Date
     *
     * @param string $format
     *
     * @return DateFieldBuilder
     */
    public function date(string $format = Date::DEFAULT_FORMAT) : DateFieldBuilder
    {
        return new DateFieldBuilder($this->field->type(new DateType($format)));
    }

    /**
     * Validates the input with the supplied format and
     * converts the input to a DateTime instance.
     *
     * @see Dms\Common\Structure\DateTime\DateTime
     *
     * @param string $format
     *
     * @return DateTimeFieldBuilder
     */
    public function datetime(string $format = DateTime::DEFAULT_FORMAT) : DateTimeFieldBuilder
    {
        return new DateTimeFieldBuilder($this->field->type(new DateTimeType($format)));
    }

    /**
     * Validates the input with the supplied format and
     * converts the input to a TimeOfDay instance.
     *
     * @see Dms\Common\Structure\DateTime\TimeOfDay
     *
     * @param string $format
     *
     * @return TimeOfDayFieldBuilder
     */
    public function time(string $format = TimeOfDay::DEFAULT_FORMAT) : TimeOfDayFieldBuilder
    {
        return new TimeOfDayFieldBuilder($this->field->type(new TimeOfDayType($format)));
    }

    /**
     * Validates the input with the supplied format and
     * converts the input to a TimezonedDateTime instance.
     *
     * @see Dms\Common\Structure\DateTime\TimezonedDateTime
     *
     * @param string $format
     *
     * @return TimezonedDateTimeFieldBuilder
     */
    public function dateTimeWithTimezone(string $format = TimezonedDateTime::DEFAULT_FORMAT) : TimezonedDateTimeFieldBuilder
    {
        return new TimezonedDateTimeFieldBuilder($this->field->type(new TimezonedDateTimeType($format)));
    }

    /**
     * Validates the input as a date range and converts
     * it to an instance of DateRange.
     *
     * @see \Dms\Common\Structure\DateTime\DateRange
     *
     * @param string $format
     *
     * @return FieldBuilderBase
     */
    public function dateRange(string $format = Date::DEFAULT_FORMAT) : FieldBuilderBase
    {
        return $this->field->type(new DateRangeType($format));
    }

    /**
     * Validates the input with the supplied format and
     * converts the input to a DateTimeRange instance.
     *
     * @see Dms\Common\Structure\DateTime\DateTimeRange
     *
     * @param string $format
     *
     * @return FieldBuilderBase
     */
    public function datetimeRange(string $format = DateTime::DEFAULT_FORMAT) : FieldBuilderBase
    {
        return $this->field->type(new DateTimeRangeType($format));
    }

    /**
     * Validates the input with the supplied format and
     * converts the input to a TimeRange instance.
     *
     * @see Dms\Common\Structure\DateTime\TimeRange
     *
     * @param string $format
     *
     * @return FieldBuilderBase
     */
    public function timeRange(string $format = TimeOfDay::DEFAULT_FORMAT) : FieldBuilderBase
    {
        return $this->field->type(new TimeRangeType($format));
    }

    /**
     * Validates the input with the supplied format and
     * converts the input to a TimezonedDateTimeRange instance.
     *
     * @see Dms\Common\Structure\DateTime\TimezonedDateTimeRange
     *
     * @param string $format
     *
     * @return FieldBuilderBase
     */
    public function dateTimeWithTimezoneRange(string $format = TimezonedDateTime::DEFAULT_FORMAT) : FieldBuilderBase
    {
        return $this->field->type(new TimezonedDateTimeRangeType($format));
    }
    //endregion

    //region File Upload Fields

    /**
     * Validates the input as an uploaded file.
     *
     * @see IUploadedFile
     *
     * @return FileUploadFieldBuilder
     */
    public function file() : FileUploadFieldBuilder
    {
        return new FileUploadFieldBuilder($this->field->type(new FileUploadType()));
    }

    /**
     * Validates the input as an uploaded image.
     *
     * @see IUploadedImage
     *
     * @return ImageUploadFieldBuilder
     */
    public function image() : ImageUploadFieldBuilder
    {
        return new ImageUploadFieldBuilder($this->field->type(new ImageUploadType()));
    }
    //endregion

    //region Colour Fields

    /**
     * Defines a field that will map to Colour type
     *
     * @see Dms\Common\Structure\Colour\Colour
     *
     * @return FieldBuilderBase
     */
    public function colour() : FieldBuilderBase
    {
        return $this->field->type(new ColourType());
    }

    /**
     * Defines a field that will map to TransparentColour type
     *
     * @see Dms\Common\Structure\Colour\TransparentColour
     *
     * @return FieldBuilderBase
     */
    public function colourWithTransparency() : FieldBuilderBase
    {
        return $this->field->type(new TransparentColourType());
    }

    //endregion

    //region Geo Fields

    /**
     * Defines a field that will map to a LatLng type.
     *
     * @see Dms\Common\Structure\Geo\LatLng
     *
     * @return FieldBuilderBase
     */
    public function latLng() : FieldBuilderBase
    {
        return $this->field->type(new LatLngType());
    }

    /**
     * Defines a field that will map to a StreetAddress type.
     *
     * @see Dms\Common\Structure\Geo\StreetAddress
     *
     * @return FieldBuilderBase
     */
    public function streetAddress() : FieldBuilderBase
    {
        return $this->field->type(new StreetAddressType());
    }

    /**
     * Defines a field that will map to a StreetAddressWithLatLng type.
     *
     * @see Dms\Common\Structure\Geo\StreetAddressWithLatLng
     *
     * @return FieldBuilderBase
     */
    public function streetAddressWithLatLng() : FieldBuilderBase
    {
        return $this->field->type(new StreetAddressWithLatLngType());
    }
    //endregion

    //region Table Fields

    /**
     * Defines a table field that will map to a TableData type.
     *
     * @see Dms\Common\Structure\Table\TableData
     *
     * @return TableCellClassDefiner
     */
    public function table() : TableCellClassDefiner
    {
        return new TableCellClassDefiner($this->field);
    }
    //endregion

    //region Entity Fields

    /**
     * Validates the input as a entity id and will load the entity object instance.
     *
     * @param IEntitySet $entities
     *
     * @return EntityFieldBuilder
     */
    public function entityFrom(IEntitySet $entities) : EntityFieldBuilder
    {
        return $this->field->entityFrom($entities);
    }

    /**
     * Validates the input as a entity id.
     *
     * @param IEntitySet $entities
     *
     * @return EntityFieldBuilder
     */
    public function entityIdFrom(IEntitySet $entities) : EntityFieldBuilder
    {
        return $this->field->entityIdFrom($entities);
    }

    /**
     * Validates the input as an array of entity ids.
     *
     * @param IEntitySet $entities
     *
     * @return EntityArrayFieldBuilder
     */
    public function entityIdsFrom(IEntitySet $entities) : EntityArrayFieldBuilder
    {
        return $this->field->entityIdsFrom($entities);
    }

    /**
     * Validates the input as an array of entity ids
     * and will load the array of entities from the set.
     *
     * @param IEntitySet $entities
     *
     * @return EntityArrayFieldBuilder
     */
    public function entitiesFrom(IEntitySet $entities) : EntityArrayFieldBuilder
    {
        return $this->field->entitiesFrom($entities);
    }
    //endregion

    //region Misc. Fields

    /**
     * Validates the input as an array of elements.
     *
     * @param FieldBuilderBase $elementField
     *
     * @return ArrayOfFieldBuilder
     */
    public function arrayOf(FieldBuilderBase $elementField) : ArrayOfFieldBuilder
    {
        return $this->field->arrayOf($elementField);
    }

    /**
     * Validates the input as an array of elements.
     *
     * @param IField $elementField
     *
     * @return ArrayOfFieldBuilder
     */
    public function arrayOfField(IField $elementField) : ArrayOfFieldBuilder
    {
        return $this->field->arrayOfField($elementField);
    }

    /**
     * Validates the input as an an array only containing elements which
     * are in the supplied value map
     *
     * Example
     * <code>
     * ->multipleFrom([
     *      'value'         => 'Label',
     *      'another-value' => 'Another Label',
     * ])
     * </code>
     *
     * @param array $valueLabelMap
     *
     * @return ArrayOfFieldBuilder
     */
    public function multipleFrom(array $valueLabelMap) : ArrayOfFieldBuilder
    {
        return $this->arrayOf(
            Field::element()->string()->oneOf($valueLabelMap)->required()
        )->containsNoDuplicates();
    }

    /**
     * Validates the input as an submission to a inner form.
     *
     * @param IForm $form
     *
     * @return InnerFormFieldBuilder
     */
    public function form(IForm $form) : InnerFormFieldBuilder
    {
        return $this->field->form($form);
    }

    /**
     * Validates the input as one of the enum options maps the
     * value to an instance of the supplied enum class.
     *
     * @param string $enumClass
     * @param string[] $valueLabelMap
     *
     * @return FieldBuilderBase
     * @throws InvalidArgumentException
     */
    public function enum(string $enumClass, array $valueLabelMap) : FieldBuilderBase
    {
        return $this->field->enum($enumClass, $valueLabelMap);
    }

    /**
     * Sets the form as a custom object type.
     *
     * @param IType $inputType
     * @param IFieldProcessor[] $processors
     *
     * @return FieldBuilderBase
     */
    public function custom(IType $inputType, array $processors = []) : FieldBuilderBase
    {
        return $this->field->custom($inputType, $processors);
    }
    //endregion
}