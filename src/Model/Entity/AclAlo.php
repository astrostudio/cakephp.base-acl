<?php
namespace Base\Acl\Model\Entity;

class AclAlo extends AclEntity {

    protected $_virtual=['info'];

    protected function _getInfo(){
        $info=$this->_createInfo('Alo');

        if($this->acl_alo_name){
            $info.=' ['.$this->acl_alo_name->name.']';
        }

        return($info);
    }

}