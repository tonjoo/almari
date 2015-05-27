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

namespace Tonjoo\Almari;
use ArrayAccess;

class Container implements ArrayAccess
{

    /**
     * Array to store service registered to container 
     */
    protected $instances = array();

    /**
     * Resolved service
     */
    protected $resolved = array();

    /**
     * Service bind to container
     */
    protected $bind = array();

    /**
     * Register service to the container
     */
    public function bind($name,$params) 
    {

        $this->instances[$name] = $params;
        $this->bind[$name] = true;

    }

    /**
     * Share singleton to the container (lazy load / defered)
     */
    public function shareDeferred($name,$params)
    {

        $this->instances[$name] = $params;

        // Mark the type as not resolved
        $this->resolved[$name] = false;
  
    }

    /**
     * Share singleton to the container (eager)
     */
    public function share($name,$params)
    {

        $this->instances[$name] = $params;
        $this->instances[$name] = $this->resolve($name);
    
    }

    /**
     * Get service from container
     */
    public function get($name,$default=null)
    {

        // Return null if the service is not in the container
        if(!isset($this->instances[$name]))
             return $default;

        if(array_key_exists($name,$this->bind))
            return $this->resolve($name);


        // Check if the service has been resolved in the container
        if(!$this->resolved[$name]){

            $this->instances[$name] = $this->resolve($name);
            

            return $this->instances[$name];
        }

        return $this->resolve($name);
    }

    /**
     * Try to resolve the service
     */ 
    private function resolve($name)
    {   
        // set as resolved
        $this->resolved[$name] = true;
        
        // resolve the service
        if (is_string($this->instances[$name]) && class_exists($this->instances[$name])) 
        {
            
            $object = $this->instances[$name];

            return new $object();

        }
        elseif(is_callable($this->instances[$name]))
        {

            $callable = $this->instances[$name];

            return $callable();

        }    

        return $this->instances[$name];
    }

    /**
     * Implementing Array Access
     */
    public function offsetExists($offset)
    {
         return isset($this->instances[$offset]);
    }
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }
    public function offsetSet($offset,$value)
    {
        $this->share($offset,$value);
    }
    public function offsetUnset($offset)
    {
        unset($this->resolved[$offset]);
        unset($this->instances[$offset]);
    }
}
