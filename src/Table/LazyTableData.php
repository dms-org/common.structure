<?php declare(strict_types=1);

namespace Dms\Common\Structure\Table;

use Dms\Core\Persistence\Db\Mapping\Relation\Lazy\Collection\ILazyCollection;
use Dms\Core\Persistence\Db\Mapping\Relation\Lazy\Collection\LazyCollectionTrait;
use Pinq\Iterators\IIteratorScheme;

/**
 * The table cell data collection class.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class LazyTableData extends TableData implements ILazyCollection
{
    use LazyCollectionTrait;

    /**
     * @param string               $cellType
     * @param callable             $callback
     * @param IIteratorScheme|null $scheme
     */
    public function __construct(
        string $cellType,
        callable $callback,
        IIteratorScheme $scheme = null
    ) {
        parent::__construct($cellType, [], $scheme);

        $this->setLazyLoadingCallback($callback);
        $this->instanceMap = null;
    }
}