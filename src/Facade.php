<?php
/**
* 
* @author  Todi Adiyatmo Wijoyo
* @link    http://www.todiadiyatmo.com
* @license MIT License Copyright (c) 2014 Todiadiyatmo
*
* Permission is hereby granted, free of charge, to any person obtaining a copy
* of this software and associated documentation files (the "Software"), to deal
* in the Software without restriction, including without limitation the rights
* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
* copies of the Software, and to permit persons to whom the Software is
* furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included in
* all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/

namespace Lotus\Almari;

abstract class Facade {

    /**
     * The container for facaded class
     */
    protected static $container;

    /**
     * Set the container instance
     */
    public static function setFacadeContainer($container)
    {
        static::$container = $container;
    }

    /*
     * Provided by the concrete class
     */
    protected static function getFacadeAccessor()
    {
        throw new \Exception('Facade does not implement getAliasAccessor method.');
    }

    public static function __callStatic($method, $args)
    {

        // Resolve instance from container
        $instance = static::$container->get(static::getFacadeAccessor());
      
        $name = get_class($instance);

        if ( !method_exists($instance, $method)) {
            throw new \Exception($name . ' does not implement ' . $method . ' method.');
        }

        return call_user_func_array([ $instance, $method ], $args);
    }

}