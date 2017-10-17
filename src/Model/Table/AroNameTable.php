<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;

class AroNameTable extends Table {

    public function initialize(array $config){
        $this->table('acl_aro_name');
        $this->primaryKey('id');
        $this->belongsTo('Base/Acl.Aro',['foreignKey'=>'id']);
        $this->addBehavior('Timestamp');
    }

}