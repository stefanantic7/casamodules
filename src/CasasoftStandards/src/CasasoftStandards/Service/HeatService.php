<?php
namespace CasasoftStandards\Service;

use Zend\Http\Request;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

use Doctrine\ORM\Tools\Pagination\Paginator;

class HeatService {

    public $items = [];

    public function __construct($translator){
        $this->translator = $translator;

        //set default categorys
        $category_options = $this->getDefaultOptions();
        foreach ($category_options as $key => $options) {
            $category = new Category;
            $category->populate($options);
            $category->setKey($key);
            $this->addItem($category, $key);
        }

        $this->groups = $this->getDefaultGroupOptions();
    }

    public function createService(ServiceLocatorInterface $serviceLocator){
        return $this;
    }

    public function getDefaultOptions(){

        return [
            'electric' => [
                'label' => $this->translator->translate('Electric heating', 'casasoft-standards')
            ],
            'geothermal-probe' => [
                'label' => $this->translator->translate('Geothermal-probe heating', 'casasoft-standards')
            ],
            'district' => [
                'label' => $this->translator->translate('District heating', 'casasoft-standards')
            ],
            'gas' => [
                'label' => $this->translator->translate('Gas heating', 'casasoft-standards')
            ],
            'wood' => [
                'label' => $this->translator->translate('Wood heating', 'casasoft-standards')
            ],
            'air-water-heatpump' => [
                'label' => $this->translator->translate('Air-water-heatpump heating', 'casasoft-standards')
            ],
            'oil' => [
                'label' => $this->translator->translate('Oil heating', 'casasoft-standards')
            ],
            'pellet' => [
                'label' => $this->translator->translate('Pellet heating', 'casasoft-standards')
            ],
            'heatpump' => [
                'label' => $this->translator->translate('Heatpump heating', 'casasoft-standards')
            ],
            'floor' => [
                'label' => $this->translator->translate('Floor heating', 'casasoft-standards')
            ],
            'radiators' => [
                'label' => $this->translator->translate('Radiators', 'casasoft-standards')
            ],
        ];
    }

    public function getDefaultGroupOptions(){
        $groups = [
            'heatGeneration' => [
                'label' => $this->translator->translate('Heat generation', 'casasoft-standards'),
                'heat_slugs' => [
                    'electric',
                    'geothermal-probe',
                    'district',
                    'gas',
                    'wood',
                    'air-water-heatpump',
                    'oil',
                    'pellet',
                    'heatpump'
                ],
            ],
            'heatDistribution' => [
                'label' => $this->translator->translate('Heat distribution', 'casasoft-standards'),
                'heat_slugs' => [
                    'floor',
                    'radiators'
                ],
            ],
        ];

        return $groups;
    }

    public function hasSlugInGroup($slug, $groupslug){
        if (array_key_exists($groupslug, $this->groups)) {
            if (in_array($slug, $this->groups[$groupslug]['heat_slugs'])) {
                return true;
            }
        }
        return false;
    }

    public function hasASlugInGroup($slugs, $groupslug){
        foreach ($slugs as $slug) {
            if ($this->hasSlugInGroup($slug, $groupslug)) {
                return true;
            }
        }
        return false;
    }

    public function addItem($obj, $key = null) {
        if ($key == null) {
            $this->items[] = $obj;
        } else {
            if (isset($this->items[$key])) {
                throw new KeyHasUseException("Key $key already in use.");
            }
            else {
                $this->items[$key] = $obj;
            }
        }
    }

    public function deleteItem($key) {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        }
        else {
            throw new \Exception("Invalid key $key.");
        }
    }

    public function getGroup($key) {
        if (isset($this->groups[$key])) {
            return $this->groups[$key];
        }
        else {
            return false;
        }
    }

    public function getItem($key) {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        } else {
            return false;
        }
    }

    public function getItems(){
        return $this->items;
    }

    public function keys() {
        return array_keys($this->items);
    }

    public function length() {
        return count($this->items);
    }

    public function keyExists($key) {
        return isset($this->items[$key]);
    }

}