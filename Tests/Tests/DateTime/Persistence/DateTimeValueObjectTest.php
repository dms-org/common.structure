<?php

namespace Dms\Common\Structure\Tests\DateTime\Persistence;

use Dms\Common\Structure\DateTime\DateTime;
use Dms\Common\Structure\Tests\DateTime\Persistence\Fixtures\DateTimeValueObject\EntityWithDateTime;
use Dms\Common\Structure\Tests\DateTime\Persistence\Fixtures\DateTimeValueObject\EntityWithDateTimeMapper;
use Dms\Core\Persistence\Db\Mapping\CustomOrm;
use Dms\Core\Persistence\Db\Mapping\IOrm;
use Dms\Core\Tests\Persistence\Db\Integration\Mapping\DbIntegrationTest;

/**
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class DateTimeValueObjectTest extends DbIntegrationTest
{
    /**
     * @return IOrm
     */
    protected function loadOrm()
    {
        return CustomOrm::from([EntityWithDateTime::class => EntityWithDateTimeMapper::class]);
    }

    public function testPersist()
    {
        $entity = new EntityWithDateTime(null, DateTime::fromString('2000-01-01 10:11:12'));

        $this->repo->save($entity);

        $this->assertDatabaseDataSameAs([
                'entities' => [
                        ['id' => 1, 'datetime' => '2000-01-01 10:11:12']
                ]
        ]);
    }

    public function testLoad()
    {
        $this->db->setData([
                'entities' => [
                        ['id' => 1, 'datetime' => '2000-01-01 10:11:12']
                ]
        ]);

        $entity = new EntityWithDateTime(1, DateTime::fromString('2000-01-01 10:11:12'));

        $this->assertEquals($entity, $this->repo->get(1));
    }

    public function testRemove()
    {
        $this->db->setData([
                'entities' => [
                        ['id' => 1, 'datetime' => '2000-01-01 10:11:12']
                ]
        ]);

        $this->repo->removeById(1);

        $this->assertDatabaseDataSameAs([
                'entities' => [
                ]
        ]);
    }

    public function testLoadPartial()
    {
        $this->db->setData([
                'entities' => [
                        ['id' => 1, 'datetime' => '2000-01-01 10:11:12']
                ]
        ]);

        $this->assertEquals(
                [
                        ['datetime' => DateTime::fromString('2000-01-01 10:11:12')]
                ],
                $this->repo->loadMatching(
                        $this->repo->loadCriteria()
                                ->load('datetime')
                )
        );
    }
}