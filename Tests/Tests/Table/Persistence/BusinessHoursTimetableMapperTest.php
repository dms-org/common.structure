<?php

namespace Iddigital\Cms\Common\Structure\Tests\Table\Persistence;

use Iddigital\Cms\Common\Structure\Table\Row;
use Iddigital\Cms\Common\Structure\Table\TableData;
use Iddigital\Cms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableData;
use Iddigital\Cms\Common\Structure\Tests\Table\Persistence\Fixtures\BusinessHours\TestBusinessHoursEntity;
use Iddigital\Cms\Common\Structure\Tests\Table\Persistence\Fixtures\BusinessHours\TestBusinessHoursOrm;
use Iddigital\Cms\Core\Persistence\Db\Mapping\IOrm;
use Iddigital\Cms\Core\Tests\Helpers\Comparators\IgnorePropertyComparator;
use Iddigital\Cms\Core\Tests\Persistence\Db\Integration\Mapping\DbIntegrationTest;
use SebastianBergmann\Comparator\Comparator;
use SebastianBergmann\Comparator\Factory;

/**
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class BusinessHoursTimetableMapperTest extends DbIntegrationTest
{
    /**
     * @var Comparator[]
     */
    private static $comparators = [];

    public static function setUpBeforeClass()
    {
        self::$comparators[] = new IgnorePropertyComparator(Row::class, ['columnCellIndexMap']);
        self::$comparators[] = new IgnorePropertyComparator(TableData::class, ['columnCellIndexMap']);

        foreach (self::$comparators as $comparator) {
            Factory::getInstance()->register($comparator);
        }
    }

    public static function tearDownAfterClass()
    {
        foreach (self::$comparators as $comparator) {
            Factory::getInstance()->unregister($comparator);
        }
    }

    /**
     * @return IOrm
     */
    protected function loadOrm()
    {
        return new TestBusinessHoursOrm();
    }

    /**
     * @return array
     */
    private function loadDefaultTimetableDataRows()
    {
        $expectedDataRows = [];
        $id               = 1;

        foreach (range(1, 7) as $day) {
            foreach (range(0, 23) as $hour) {
                $expectedDataRows[] = [
                        'id'                => $id++,
                        'business_hours_id' => 1,
                        'day'               => $day,
                        'time'              => str_pad($hour, 2, 0, STR_PAD_LEFT) . ':00:00',
                        'status'            =>
                                $day <= 5 && $hour >= TestBusinessHoursTimetableData::OPENING_HOUR && $hour <= TestBusinessHoursTimetableData::CLOSING_HOUR
                                        ? 'open'
                                        : 'closed',
                ];
            }
        }

        return $expectedDataRows;
    }

    public function testSave()
    {
        $this->repo->save(new TestBusinessHoursEntity(null, TestBusinessHoursTimetableData::defaultTimetable()));

        $expectedDataRows = $this->loadDefaultTimetableDataRows();

        $this->assertDatabaseDataSameAs([
                'business_hours'      => [
                        ['id' => 1]
                ],
                'business_hours_data' => $expectedDataRows,
        ]);
    }

    public function testLoad()
    {
        $dataRows = $this->loadDefaultTimetableDataRows();

        $this->db->setData([
                'business_hours'      => [
                        ['id' => 1]
                ],
                'business_hours_data' => $dataRows,
        ]);

        $expectedEntity = new TestBusinessHoursEntity(1, TestBusinessHoursTimetableData::defaultTimetable());

        $this->assertEquals($expectedEntity, $this->repo->get(1));
    }
}