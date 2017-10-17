<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;

class AclAroLinkTable extends Table {

    public function initialize(array $config){
        $this->table('acl_aro_link');
        $this->primaryKey(['acl_aro_id','acl_sub_aro_id']);
        $this->belongsTo('Base/Acl.AclAro');
        $this->belongsTo('AclSubAro',['className'=>'Base/Acl.AclAro','foreignKey'=>'acl_sub_aro_id']);
        $this->addBehavior('Base.Link',[
            'pred'=>'acl_aro_id',
            'succ'=>'acl_sub_aro_id',
            'item'=>'item',
            'node'=>'Base/Acl.AclAro'
        ]);
        $this->addBehavior('Timestamp');
    }

}