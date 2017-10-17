<?php
namespace Base\Acl\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;

class Aco extends Entity {

    protected $_virtual=['info'];

    protected function _getInfo(){
        $info='';
        $infos=Configure::read('Base.Acl.Aco.info');

        foreach($infos as $field=>$face){
            if(isset($this->$field)){
                $info.=!empty($info)?' ':'';

                if(is_callable($face)){
                    $info.=call_user_func($face,$this,$info);
                }
                else {
                    $info.=$face;
                }
            }
        }

        if($this->aco_name){
            $info.=' ['.$this->aco_name->name.']';
        }

        return($info);
    }

}