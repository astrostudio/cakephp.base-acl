<?php
namespace Base\Acl\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;

class AclAloTable extends Table {

    public function initialize(array $config){
        $this->table('acl_alo');
        $this->primaryKey('id');
        $this->hasOne('Base/Acl.AclAloName',['foreignKey'=>'id']);
        $this->hasMany('Base/Acl.AclAloLink');
        $this->addBehavior('Timestamp');

        $entityClass=Configure::read('Base.Acl.Alo.entity');

        if(!empty($entityClass)){
            $this->entityClass($entityClass);
        }

        $associations=Configure::read('Base.Acl.Alo.association');

        if(isset($associations) and is_array($associations)){
            $this->addAssociations($associations);
        }
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options){
        if($entity->isNew()){
            $link=$this->AclAloLink->newEntity(['acl_alo_id'=>$entity->id,'acl_sub_alo_id'=>$entity->id,'item'=>0]);

            if(!$this->AclAloLink->save($link)){
            }
        }
    }

}