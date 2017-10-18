<?php
namespace Base\Acl\Model\Entity;

class AclAro extends AclEntity {

    protected $_virtual=['info'];

    protected function _getInfo(){
        $info=$this->_createInfo('Aro');

        if($this->acl_aro_name){
            $info.=' ['.$this->acl_aro_name->name.']';
        }

        return($info);
    }

}