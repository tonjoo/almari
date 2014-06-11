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

class AliasMapper
{
	/**
	 * Instance for this AliasLoader
	 */
	static $instance = null;

    /*
     * Bind Facade Class Alias
     */
    public function facadeClassAlias($alias)
    {

        foreach ($alias as $key => $value) {

            $facadeClass = new $value;

            // Throw Error on getFacadeAccessor method not found
            if(!method_exists($facadeClass,'getFacadeAccessor')){
                throw new \Exception("Facade class does not implement getFacadeAccessor method");
            }

            $accessorClass = $facadeClass->getFacadeAccessor();

            // Register Facade Alias Static Class
            class_alias($value,$key);
        
        }

    }

    /*
     * Bind Class Alias
     */
    public function classAlias($alias)
    {

        foreach ($alias as $key => $value) {

            // Register Class Alias
            class_alias($value,$key);
        
        }

    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * *Singleton* via the `new` operator from outside of this class.
     */
    protected function __construct()
    {

    }

    /**
     * Returns the *Singleton* instance of this class.
     */
    public static function getInstance()
    {

        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

}