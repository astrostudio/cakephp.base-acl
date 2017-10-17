<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;

class AroLinkTable extends Table {

    public function initialize(array $config){
        $this->table('acl_aro_link');
        $this->primaryKey(['acl_aro_id','acl_sub_aro_id']);
        $this->belongsTo('Base/Acl.Aro');
        $this->belongsTo('SubAro',['className'=>'Base/Acl.Aro','foreignKey'=>'acl_sub_aro_id']);
        $this->addBehavior('Base.Link',[
            'pred'=>'acl_aro_id',
            'succ'=>'acl_sub_aro_id',
            'item'=>'item',
            'node'=>'AclAro'
        ]);
        $this->addBehavior('Timestamp');
    }

}