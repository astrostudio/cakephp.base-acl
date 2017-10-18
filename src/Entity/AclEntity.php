<?php
namespace Base\Acl\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;

class AclEntity extends Entity {

    protected function _createInfo($key){
        $info='';
        $property=Configure::read('Base.Acl.'.$key.'.property');

        if(isset($property) and is_array($property)){
            foreach($property as $field=>$value){
                if(isset($this->$field)){
                    $info.=!empty($info)?' ':'';

                    if(is_callable($value)){
                        $info.=call_user_func($value,$this->$field);
                    }
                    else {
                        $info.=$value;
                    }
                }
            }
        }

        if(empty($info)){
            $info='#'.$this->id.' ('.__d('acl',mb_strtoupper($key)).')';
        }

        return($info);
    }

}