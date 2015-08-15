<?php
namespace System\Collections;

trait Prueba{
    public function fPrueba(){
        echo "Se hizo una prueba";
    }
}

class Collectionable implements \Iterator, \ArrayAccess, \Countable{
    use Prueba;
    private $array = array();
    private $index = 0;
    
    public function current(){
        return $this->array[$this->index];
    }
    
    public function next(){
        $this->index++;
    }
    
    public function key(){
        return $this->index;
    }
    
    public function valid(){
        return isset($this->array[$this->index]);
    }
    
    public function rewind(){
        $this->index = 0;
    }
    
    public function reverse(){
        $this->array = array_reverse($this->array);
        $this->index = 0;
    }
    
    public function offsetSet($offset, $value){
        if(is_null($offset)){
            $this->array[] = $value;
        }else{
            $this->array[$offset] = $value;
        }
    }
    
    public function offsetExists($offset){
        return isset($this->array[$offset]);
    }
    
    public function offsetUnset($offset){
        unset($this->array[$offset]);
    }
    
    public function offsetGet($offset){
        if(is_int($offset)){
            if(isset($this->array[$offset])){
                return $this->array[$offset];
            }else{
                $keys = array_keys($this->array);
                $key = $keys[$offset];
                if(isset($this->array[$key])){
                    return $this->array[$keys[$offset]];
                }else{
                    return null;
                }
            }
        }
        return isset($this->array[$offset]) ? $this->array[$offset] : null;
    }
    
    public function Count(){
        return count($this->array);
    }
}