<?php
namespace Base\Acl\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;

class AclAcoTable extends Table {

    public function initialize(array $config){
        $this->table('acl_aco');
        $this->primaryKey('id');
        $this->hasOne('Base/Acl.AclAcoName',['foreignKey'=>'id','dependent'=>true]);
        $this->hasMany('Base/Acl.AclAcoLink');
        $this->addBehavior('Timestamp');

        $entityClass=Configure::read('Base.Acl.Aco.entity');

        if(!empty($entityClass)){
            $this->entityClass($entityClass);
        }

        $associations=Configure::read('Base.Acl.Aco.association');

        if(isset($associations) and is_array($associations)){
            $this->addAssociations($associations);
        }
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options){
        if($entity->isNew()){
            $link=$this->AclAcoLink->newEntity(['acl_aco_id'=>$entity->id,'acl_sub_aco_id'=>$entity->id,'item'=>0]);

            if(!$this->AclAcoLink->save($link)){
            }
        }
    }
}