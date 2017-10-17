<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;
use Cake\Event\Event;
use ArrayObject;
use Base\Time;
use JsonSchema\Exception\ValidationException;
use DateTimeInterface;

class ItemTable extends Table {

    public function initialize(array $config){
        $this->table('acl_item');
        $this->primaryKey('id');
        $this->belongsTo('Base/Acl.Aro');
        $this->belongsTo('Base/Acl.Aco');
        $this->belongsTo('Base/Acl.Alo');
        $this->addBehavior('Timestamp');
    }

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options){
        if(!empty($data['start'])){
            $start=Time::recognize($data['start']);

            if(!$start) {
                throw new ValidationException('Field "start" not valid.');
            }

            $data['start']=$start->format(Time::TF_DATABASE);
        }

        if(!empty($data['stop'])){
            $stop=Time::recognize($data['stop']);

            if(!$stop) {
                throw new ValidationException('Field "stop" not valid.');
            }

            $data['stop']=$stop->format(Time::TF_DATABASE);
        }
    }

    public function append($aroId,$acoId,$aloId,DateTimeInterface $start=null,DateTimeInterface $stop=null){
        $item=$this->newEntity([
            'acl_aro_id'=>$aroId,
            'acl_aco_id'=>$acoId,
            'acl_alo_id'=>$aloId,
            'start'=>$start,
            'stop'=>$stop
        ]);

        return($this->save($item));
    }

}