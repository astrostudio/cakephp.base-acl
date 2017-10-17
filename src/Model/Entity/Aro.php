<?php
namespace Base\Acl\Model\Entity;

use Cake\ORM\Entity;
use Cake\Core\Configure;

class Aro extends Entity {

    protected $_virtual=['info'];

    protected function _getInfo(){
        $info='';
        $infos=Configure::read('Base.Acl.Aro.info');

        foreach($infos as $field=>$face){
            if(isset($this->$field)){
                $info.=!empty($info)?' ':'';

                if(is_callable($face)){
                    $info.=call_user_func($face,$this);
                }
                else {
                    $info.=$face;
                }
            }
        }

        if($this->aro_name){
            $info.=' ['.$this->aro_name->name.']';
        }

        return($info);
    }

}