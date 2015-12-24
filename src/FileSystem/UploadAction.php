<?php

namespace Dms\Common\Structure\FileSystem;

use Dms\Core\Model\Object\Enum;
use Dms\Core\Model\Object\PropertyTypeDefiner;

/**
 * The file upload action enum.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
class UploadAction extends Enum
{
    const STORE_NEW = 'store-new';
    const KEEP_EXISTING = 'keep-existing';
    const DELETE_EXISTING = 'delete-existing';

    /**
     * @return UploadAction
     */
    public static function storeNew()
    {
        return new self(self::STORE_NEW);
    }

    /**
     * @return UploadAction
     */
    public static function keepExisting()
    {
        return new self(self::KEEP_EXISTING);
    }

    /**
     * @return UploadAction
     */
    public static function deleteExisting()
    {
        return new self(self::DELETE_EXISTING);
    }

    /**
     * Defines the type of the options contained within the enum.
     *
     * @param PropertyTypeDefiner $values
     *
     * @return void
     */
    protected function defineEnumValues(PropertyTypeDefiner $values)
    {
        $values->asString();
    }
}