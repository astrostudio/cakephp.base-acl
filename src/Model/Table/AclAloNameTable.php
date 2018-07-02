<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;

class AclAloNameTable extends Table {

    public function initialize(array $config){
        $this->table('acl_alo_name');
        $this->primaryKey('id');
        $this->belongsTo('Base/Acl.AclAlo',['foreignKey'=>'id']);
        $this->addBehavior('Timestamp');
    }

}
