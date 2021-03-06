<?php
namespace CasasoftStandards\Service;

use Zend\Http\Request;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Heat {
    private $key;
    public function getKey(){return $this->key;}
    public function setKey($key){$this->key = $key;}

    private $icon;
    public function getIcon(){return $this->icon;}
    public function setIcon($icon){$this->icon = $icon;}

    private $label;
    public function getLabel(){return $this->label;}
    public function setLabel($label){$this->label = $label;}

    private $translator;
    public function __construct(){
    }
    public function populate($data){
        if (isset($data['key'])) {
            $this->key = $data['key'];
        } 
        if (isset($data['icon'])){
            $this->icon = $data['icon'];
        }
        if (isset($data['label'])){
            $this->label = $data['label'];
        }
    }

    public function __toString() {
        return $this->label;
    }
}