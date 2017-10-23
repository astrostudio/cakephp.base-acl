<?php
namespace Base\Acl\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;

class AclAroTable extends AclTable {

    public function initialize(array $config){
        $this->table('acl_aro');
        $this->primaryKey('id');
        $this->hasOne('Base/Acl.AclAroName',['foreignKey'=>'id','dependent'=>true]);
        $this->hasMany('Base/Acl.AclAroLink');
        $this->addBehavior('Timestamp');

        $this->_initializeAcl('Aro');
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options){
        if($entity->isNew()){
            $link=$this->AclAroLink->newEntity(['acl_aro_id'=>$entity->id,'acl_sub_aro_id'=>$entity->id,'item'=>0]);

            if(!$this->AclAroLink->save($link)){
            }
        }
    }

}