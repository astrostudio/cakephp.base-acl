<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;

class AclAroNameTable extends Table {

    public function initialize(array $config){
        $this->table('acl_aro_name');
        $this->primaryKey('id');
        $this->belongsTo('Base/Acl.AclAro',['foreignKey'=>'id']);
        $this->addBehavior('Timestamp');
    }

}