<?php
namespace Base\Acl\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;

class AloTable extends Table {

    public function initialize(array $config){
        $this->table('acl_alo');
        $this->primaryKey('id');
        $this->hasOne('Base/Acl.AloName',['foreignKey'=>'id']);
        $this->hasMany('Base/Acl.AloLink');
        $this->addBehavior('Timestamp');

        $associations=Configure::read('Base.Acl.Alo.association');

        if(isset($associations) and is_array($associations)){
            $this->addAssociations($associations);
        }
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options){
        if($entity->isNew()){
            $link=$this->AloLink->newEntity(['acl_alo_id'=>$entity->id,'acl_sub_alo_id'=>$entity->id,'item'=>0]);

            if(!$this->AloLink->save($link)){
            }
        }
    }

}