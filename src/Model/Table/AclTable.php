<?php
namespace Base\Acl\Model\Table;

use Cake\ORM\Table;
use Cake\Core\Configure;
use Cake\Utility\Hash;

class AclTable extends Table {

    protected $_aclExtend=[];
    protected $_aclOption=[];

    protected function _initializeAcl($type){
        $extend=Configure::read('Base.Acl.'.$type);
        $this->_aclExtend=isset($extend)?$extend:[];

        $this->_aclOption=[
            'contain'=>[],
            'filter'=>[],
            'sorter'=>[],
            'search'=>[]
        ];

        foreach($this->_aclExtend as $alias=>$extend){
            $associations=Hash::get($extend,'association',[]);

            if(!empty($associations)){
                $this->addAssociations($associations);
            }

            $behaviors=Hash::get($extend,'behavior',[]);

            if(!empty($behaviors)){
                foreach($behaviors as $name=>$options){
                    $this->addBehavior($name,$options);
                }
            }

            $cc=Hash::get($extend,'contain',[]);

            foreach($cc as $name=>$c){
                $this->_aclOption['contain'][$name]=$c;
            }

            $ff=Hash::get($extend,'filter',[]);

            foreach($ff as $name=>$f){
                $this->_aclOption['filter'][$name]=$f;
            }

            $ss=Hash::get($extend,'sorter',[]);

            foreach($ss as $name=>$s){
                $this->_aclOption['sorter'][$name]=$s;
            }

            $ss=Hash::get($extend,'search',[]);

            foreach($ss as $s){
                $this->_aclOption['search'][]=$s;
            }
        }
    }

    public function aclContain(){
        return($this->_aclOption['contain']);
    }

    public function aclFilter(){
        return($this->_aclOption['filter']);
    }

    public function aclSorter(){
        return($this->_aclOption['sorter']);
    }

    public function aclSearch(){
        return($this->_aclOption['search']);
    }


}