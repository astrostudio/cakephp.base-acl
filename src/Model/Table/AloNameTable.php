<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;

class AloNameTable extends Table {

    public function initialize(array $config){
        $this->table('acl_alo_name');
        $this->primaryKey('id');
        $this->belongsTo('Base/Acl.Alo',['foreignKey'=>'id']);
        $this->addBehavior('Timestamp');
    }

}