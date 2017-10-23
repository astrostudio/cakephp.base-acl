<?php
namespace Base\Acl\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;
use Cake\Utility\Hash;

class AclEntity extends Entity {

    protected function _createInfo($key){
        $info='';
        $extends=Configure::read('Base.Acl.'.$key);

        foreach($extends as $alias=>$extend){
            $pp=Hash::get($extend,'property',[]);

            foreach($pp as $name=>$value){
                if(isset($this->$name)){
                    $info.=!empty($info)?' ':'';

                    if(is_callable($value)){
                        $info.=call_user_func($value,$this->$name);
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