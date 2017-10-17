<?php
namespace Base\Acl\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;

class AcoTable extends Table {

    public function initialize(array $config){
        $this->table('acl_aco');
        $this->primaryKey('id');
        $this->hasOne('Base/Acl.AcoName',['foreignKey'=>'id','dependent'=>true]);
        $this->hasMany('Base/Acl.AcoLink');
        $this->addBehavior('Timestamp');

        $associations=Configure::read('Base.Acl.Aco.association');

        if(isset($associations) and is_array($associations)){
            $this->addAssociations($associations);
        }
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options){
        if($entity->isNew()){
            $link=$this->AcoLink->newEntity(['acl_aco_id'=>$entity->id,'acl_sub_aco_id'=>$entity->id,'item'=>0]);

            if(!$this->AcoLink->save($link)){
            }
        }
    }
}