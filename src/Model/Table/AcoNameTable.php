<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;

class AcoNameTable extends Table {

    public function initialize(array $config){
        $this->table('acl_aco_name');
        $this->primaryKey('id');
        $this->belongsTo('Base/Acl.Aco',['foreignKey'=>'id']);
        $this->addBehavior('Timestamp');
    }

}