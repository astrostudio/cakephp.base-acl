<?php
namespace Base\Acl\Model\Table;

use Cake\Core\Configure;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use ArrayObject;

class AroTable extends Table {

    public function initialize(array $config){
        $this->table('acl_aro');
        $this->primaryKey('id');
        $this->hasOne('Base/Acl.AroName',['foreignKey'=>'id','dependent'=>true]);
        $this->hasMany('Base/Acl.AroLink');
        $this->addBehavior('Timestamp');

        $associations=Configure::read('Base.Acl.Aro.association');

        if(isset($associations) and is_array($associations)){
            $this->addAssociations($associations);
        }
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options){
        if($entity->isNew()){
            $link=$this->AroLink->newEntity(['acl_aro_id'=>$entity->id,'acl_sub_aro_id'=>$entity->id,'item'=>0]);

            if(!$this->AroLink->save($link)){
            }
        }
    }

}