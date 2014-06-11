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

class Container
{

    /**
     * Array to store service registered to container 
     */
    protected $instances = array();

    /**
     * Resolved service
     */
    protected $resolved= array();

    /**
     * Register singeleteon type to the container
     */
    public function share($name,$params)
    {

        $this->instances[$name] = $params;

        // Mark the type as not resolved
        $this->resolved[$name] = false;
  
    }

    /**
     * Register service to the container
     */
    public function register($name, $params)
    {

        $this->instances[$name] = $params;

        $this->resolved[$name] = true;

    }

    /**
     * Get type from container
     */
    public function get($name,$default=null)
    {

        // Return null if the type is not bind to container
        if(!isset($this->instances[$name]))
             return $default;

        // Check if the type has been resolved in the container
        if(!$this->resolved[$name]){

            $this->instances[$name] = $this->resolve($name);

            $this->resolved[$name] = true;

            return $this->instances[$name];
        }

        return $this->resolve($name);
    }

    /**
     * Try to resolve the type
     */ 
    private function resolve($name){

        // resolve the type
        if (is_string($this->instances[$name]) && class_exists($this->instances[$name])) {
            
            $object = $this->instances[$name];

            return new $object();

        }elseif(is_callable($this->instances[$name])){

            $callable = $this->instances[$name];

            return $callable();

        }    

        return $this->instances[$name];
    }
}
