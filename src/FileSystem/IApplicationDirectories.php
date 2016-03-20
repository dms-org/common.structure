<?php declare(strict_types = 1);

namespace Dms\Common\Structure\FileSystem;

/**
 * The application directories interface.
 *
 * @author Elliot Levin <elliotlevin@hotmail.com>
 */
interface IApplicationDirectories
{
    /**
     * Gets the root directory of the application.
     *
     * All source files, stored uploads etc should be within
     * this directory.
     *
     * @return Directory
     */
    public function getRootDirectory() : Directory;

    /**
     * Gets the private storage directory of the application.
     *
     * All *private* stored uploads etc should be within this directory.
     *
     * @return Directory
     */
    public function getPrivateStorageDirectory() : Directory;

    /**
     * Gets the public storage directory of the application.
     *
     * All *public* stored uploads etc should be within this directory.
     *
     * @return Directory
     */
    public function getPublicStorageDirectory() : Directory;
}