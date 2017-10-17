<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;

class AclAloLinkTable extends Table {

    public function initialize(array $config){
        $this->table('acl_alo_link');
        $this->primaryKey(['acl_alo_id','acl_sub_alo_id']);
        $this->belongsTo('Base/Acl.AclAlo');
        $this->belongsTo('AclSubAlo',['className'=>'Base/Acl.AclAlo','foreignKey'=>'acl_sub_alo_id']);
        $this->addBehavior('Base.Link',[
            'pred'=>'acl_alo_id',
            'succ'=>'acl_sub_alo_id',
            'item'=>'item',
            'node'=>'Base/Acl.AclAlo'
        ]);
        $this->addBehavior('Timestamp');
    }

}