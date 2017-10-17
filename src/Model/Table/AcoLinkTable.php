<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;

class AcoLinkTable extends Table {

    public function initialize(array $config){
        $this->table('acl_aco_link');
        $this->primaryKey(['acl_aco_id','acl_sub_aco_id']);
        $this->belongsTo('Base/Acl.Aco');
        $this->belongsTo('SubAco',['className'=>'Base/Acl.Aco','foreignKey'=>'acl_sub_aco_id']);
        $this->addBehavior('Base.Link',[
            'pred'=>'acl_aco_id',
            'succ'=>'acl_sub_aco_id',
            'item'=>'item',
            'node'=>'AclAco'
        ]);
        $this->addBehavior('Timestamp');
    }

}