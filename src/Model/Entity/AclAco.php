<?php
namespace Base\Acl\Model\Entity;

class AclAco extends AclEntity {

    protected $_virtual=['info'];

    protected function _getInfo(){
        $info=$this->_createInfo('Aco');

        if($this->acl_aco_name){
            $info.=' ['.$this->acl_aco_name->name.']';
        }

        return($info);
    }

}