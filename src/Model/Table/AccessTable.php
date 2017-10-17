<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;
use DateTimeInterface;
use DateTime;
use Cake\ORM\Query;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;

class AccessTable extends Table {

    static public function whereTime($alias,DateTimeInterface $time=null){
        $time=$time?$time:new DateTime();

        return([
            ['OR'=>[
                $alias.'.start is NULL',
                $alias.'.start <="'.$time->format('Y-m-d H:i:s').'"'
            ]],
            ['OR'=>[
                $alias.'.stop is NULL',
                $alias.'.stop >="'.$time->format('Y-m-d H:i:s').'"'
            ]]
        ]);
    }

    public function initialize(array $config){
        $this->table('acl_access');
        $this->primaryKey(false);
        $this->belongsTo('Base/Acl.Aro');
        $this->belongsTo('Base/Acl.Aco');
        $this->belongsTo('Base/Acl.Alo');
    }

    public function check($aroId,$acoId,$aloId,DateTimeInterface $time=null){
        return($this->find()->where([
            'acl_aro_id'=>$aroId,
            'acl_aco_id'=>$acoId,
            'acl_alo_id'=>$aloId,
        ])->where(self::whereTime($this->alias(),$time))->first()?1:0);
    }

    public function checkName($aro,$aco,$alo,DateTimeInterface $time=null){
        $query=$this->find();

        if(is_string($aro) and mb_substr($aro,0,1)=='@'){
            $query=$query->join([
                'table'=>$this->Aro->AroName->table(),
                'alias'=>$this->Aro->AroName->alias(),
                'conditions'=>[$this->Aro->AroName->alias().'.id='.$this->alias().'.acl_aro_id']
            ])->where([$this->AclAro->AroName->alias().'.name'=>mb_substr($aro,1)]);
        }
        else {
            $query=$query->where([$this->alias().'.acl_aro_id'=>$aro]);
        }

        if(is_string($aco) and mb_substr($aco,0,1)=='@'){
            $query=$query->join([
                'table'=>$this->Aco->AcoName->table(),
                'alias'=>$this->Aco->AcoName->alias(),
                'conditions'=>[$this->Aco->AcoName->alias().'.id='.$this->alias().'.acl_aco_id']
            ])->where([$this->Aro->AcoName->alias().'.name'=>mb_substr($aco,1)]);
        }
        else {
            $query=$query->where([$this->alias().'.acl_aco_id'=>$aco]);
        }

        if(is_string($alo) and mb_substr($alo,0,1)=='@'){
            $query=$query->join([
                'table'=>$this->Alo->AloName->table(),
                'alias'=>$this->Alo->AloName->alias(),
                'conditions'=>[$this->Alo->AloName->alias().'.id='.$this->alias().'.acl_alo_id']
            ])->where([$this->Alo->AloName->alias().'.name'=>mb_substr($alo,1)]);
        }
        else {
            $query=$query->where([$this->alias().'.acl_alo_id'=>$aro]);
        }

        return($query->where(self::whereTime($this->alias(),$time))->first()?1:0);
    }

    public function join(Query $query,$aroId,$field,$aloId,array $options=[]){
        $time=Hash::get($options,'time',new DateTime());
        $alias=Hash::get($options,'alias',$this->alias());

        $query=$query->join([
            'table'=>$this->table(),
            'alias'=>$alias,
            'conditions'=>[$alias.'.acl_aco_id='.$field]
        ])->where([
            $alias.'.acl_aro_id'=>$aroId,
            $alias.'.acl_alo_id'=>$aloId
        ])->where(self::whereTime($alias,$time));

        return($query);
    }

    public function joinName(Query $query,$aro,$field,$alo,array $options=[]){
        $time=Hash::get($options,'time',new DateTime());
        $alias=Hash::get($options,'alias',$this->alias());

        $query=$query->join([
            'table'=>$this->table(),
            'alias'=>$alias,
            'conditions'=>[$alias.'.acl_aco_id='.$field]
        ]);

        if(is_string($aro) and mb_substr($aro,0,1)=='@'){
            $query=$query->join([
                'table'=>$this->Aro->AroName->table(),
                'alias'=>$alias.'AroName',
                'conditions'=>[$alias.'AroName.id='.$alias.'.acl_aro_id']
            ])->where([$alias.'AroName.name'=>mb_substr($aro,1)]);
        }
        else {
            $query=$query->where([$alias.'.acl_aro_id'=>$aro]);
        }

        if(is_string($alo) and mb_substr($alo,0,1)=='@'){
            $query=$query->join([
                'table'=>$this->Alo->AloName->table(),
                'alias'=>$alias.'AloName',
                'conditions'=>[$alias.'AloName.id='.$alias.'.acl_alo_id']
            ])->where([$alias.'AloName.name'=>mb_substr($alo,1)]);
        }
        else {
            $query=$query->where([$alias.'.acl_alo_id'=>$alo]);
        }

        $query=$query->where(self::whereTime($alias,$time));

        return($query);
    }

    public function joinLeft(Query $query,$aroId,$field,$aloId,array $options=[]){
        $time=Hash::get($options,'time',new DateTime());
        $alias=Hash::get($options,'alias',$this->alias());
        $aloField=Hash::get($options,'aloField',Inflector::underscore($alias));

        $query=$query->join([
            'table'=>$this->table(),
            'alias'=>$alias,
            'type'=>'LEFT',
            'conditions'=>array_merge([$alias.'.acl_aco_id='.$field],[
                $alias.'.acl_aro_id='.$aroId,
                $alias.'.acl_alo_id='.$aloId,
            ],self::whereTime($alias,$time))
        ])->select([$aloField=>$alias.'.acl_alo_id']);

        return($query);
    }
}