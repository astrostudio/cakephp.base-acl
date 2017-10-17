<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;

class AclAcoNameTable extends Table {

    public function initialize(array $config){
        $this->table('acl_aco_name');
        $this->primaryKey('id');
        $this->belongsTo('Base/Acl.AclAco',['foreignKey'=>'id']);
        $this->addBehavior('Timestamp');
    }

}