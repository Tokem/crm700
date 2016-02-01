
<?php

/**
 * Zend Image
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 *
 * @category  Zend
 * @package   Zend_Image
 * @author    Stanislav Seletskiy <s.seletskiy@gmail.com>
 * @author    Leonid Shagabutdinov <leonid@shagabutdinov.com>
 * @copyright Copyright (c) 2010
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   $Id$
 */

/**
 * Base class for loading and saving images.
 *
 * @category  Zend
 * @package   Zend_Image
 * @copyright Copyright (c) 2010
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class Zend_Image
{
    /**
     * Constructor for image.
     *
     * @param mixed $filename Filename, Zend_Image or binary.
     * @param Zend_Image_Driver_Abstract $driver Driver for image operations.
     */
    public function __construct( $filename, Zend_Image_Driver_Abstract $driver = null )
    {
        if( ! $filename instanceof Zend_Image ) {
            $this->_driver = $driver;
        }

        $this->load( $filename );
    }


    /**
     * Loads specified file, or Zend_Image or binary as
     * image source.
     *
     * @param  mixed $filename Filename or instance of Zend_Image.
     * @return Zend_Image
     */
    public function load( $filename )
    {
        if( $filename instanceof Zend_Image ) {
            $this->_driver = clone $filename->getDriver();
        } else {
            $this->_filename = $filename;
            $this->_driver->load( $this->_filename );
        }

        return $this;
    }

    /**
     * Save image to file to disk.
     * @param string filename
		 * @param $type
     * @return bool
     */
    public function save( $filename,$type='auto')
    {
        return $this->_driver->save( $filename ,$type);
    }

    /**
     * @return Zend_Image_Driver_Abstract
     */
    public function getDriver()
    {
        return $this->_driver;
    }


    /**
     * Get image is binary.
     *
     * @return binary
     */
    public function getBinary()
    {
        return $this->_driver->getBinary();
    }


    /**
     * Returns width of image.
     *
     * @throws Zend_Image_Driver_Exception
     * @return int Width of image.
     */
    public function getWidth()
    {
        $size = $this->_driver->getSize();
        return $size[ 0 ];
    }


    /**
     * Returns height of image.
     *
     * @throws Zend_Image_Driver_Exception
     * @return int Height of image.
     */
    public function getHeight()
    {
        $size = $this->_driver->getSize();
        return $size[ 1 ];
    }

    /**
     * Filename of image source.
     *
     * @var string
     */
    private $_filename = '';


    /**
     * Driver for image operations.
     *
     * @var Zend_Image_Driver
     */
    protected $_driver = null;
}
