<?php

namespace Dms\Common\Structure\Tests\Table\Persistence;

use Dms\Common\Structure\DateTime\DayOfWeek;
use Dms\Common\Structure\DateTime\TimeOfDay;
use Dms\Common\Structure\Table\Row;
use Dms\Common\Structure\Table\TableData;
use Dms\Common\Structure\Tests\Table\Fixtures\TestBusinessAvailability;
use Dms\Common\Structure\Tests\Table\Fixtures\TestBusinessHoursTimetableCell;
use Dms\Common\Structure\Tests\Table\Persistence\Fixtures\BusinessHours\TestBusinessHoursEntity;
use Dms\Common\Structure\Tests\Table\Persistence\Fixtures\BusinessHours\TestBusinessHoursOrm;
use Dms\Core\Persistence\Db\Mapping\IOrm;
use Dms\Core\Tests\Helpers\Comparators\IgnorePropertyComparator;
use Dms\Core\Tests\Persistence\Db\Integration\Mapping\DbIntegrationTest;
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
    private function loadDefaultTimetableDataRows($businessHoursId = 1)
    {
        $expectedDataRows = [];
        $id               = 1;

        foreach (range(1, 7) as $day) {
            foreach (range(0, 23) as $hour) {
                $expectedDataRows[] = [
                        'id'                => $id++,
                        'business_hours_id' => $businessHoursId,
                        'day'               => $day,
                        'time'              => str_pad($hour, 2, 0, STR_PAD_LEFT) . ':00:00',
                        'status'            =>
                                $day <= 5 && $hour >= TestBusinessHoursTimetableCell::OPENING_HOUR && $hour <= TestBusinessHoursTimetableCell::CLOSING_HOUR
                                        ? 'open'
                                        : 'closed',
                ];
            }
        }

        return $expectedDataRows;
    }

    public function testSave()
    {
        $this->repo->save(new TestBusinessHoursEntity(null, TestBusinessHoursTimetableCell::defaultTimetable()));

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
        $this->db->setData([
                'business_hours'      => [
                        ['id' => 1]
                ],
                'business_hours_data' => $this->loadDefaultTimetableDataRows(),
        ]);

        $expectedEntity = new TestBusinessHoursEntity(1, TestBusinessHoursTimetableCell::defaultTimetable());

        $this->assertEquals($expectedEntity, $this->repo->get(1));
    }

    public function testCriteria()
    {
        $this->db->setData([
                'business_hours'      => [
                        ['id' => 1],
                        ['id' => 2],
                ],
                'business_hours_data' => array_merge($this->loadDefaultTimetableDataRows(1), [
                        [
                                'id'                => 200,
                                'business_hours_id' => 2,
                                'day'               => 3,
                                'time'              => '05:00:00',
                                'status'            => 'open',
                        ]
                ]),
        ]);

        $results = $this->repo->matching(
                $this->repo->criteria()
                        ->where('timetable.count()', '<', 100)
        );

        $this->assertEquals([
            new TestBusinessHoursEntity(2, TestBusinessHoursTimetableCell::collection([
                new TestBusinessHoursTimetableCell(DayOfWeek::wednesday(), new TimeOfDay(5), TestBusinessAvailability::open())
            ]))
        ], $results);
    }
}