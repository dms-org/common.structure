<?php

namespace Iddigital\Cms\Common\Structure\Table;

use Iddigital\Cms\Common\Structure\DateTime\DayOfWeek;
use Iddigital\Cms\Common\Structure\DateTime\TimeOfDay;
use Iddigital\Cms\Core\Model\Type\Builder\Type;

/** @var TableData $table */
$table = table();

foreach ($table->getColumns() as $column) {
    echo $column->getLabel();
    echo $column->getKey();
}

foreach ($table->getRows() as $row) {
    echo $row->getLabel();
    echo $row->getKey();

    foreach ($table->getColumns() as $column) {
        $someValueObject = $row[$column];
    }
}

$table->withCell($rowKey, $columnKey, $newCellValue);

$table->asCellCollection();

$data = SomeTableData::fromCellCollection($dfsfsd);


// new

new LapLanesTimetable([
    new Row(new TimeOfDay(9), [new AvailableLanes(1)])
]);

new CsvTable([
    ['abc', 'dfsd', 'fdsf']
]);