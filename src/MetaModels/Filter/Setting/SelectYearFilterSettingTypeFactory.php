<?php

/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 *
 * @package    MetaModels
 * @subpackage FilterSelectYear
 * @author     Christopher Bölter <metamodels@boelter.eu>
 * @copyright  2016 Christopher Bölter
 * @license    LGPL 3.0 https://www.gnu.org/licenses/lgpl-3.0.en.html
 * @filesource
 */

namespace MetaModels\Filter\Setting;

/**
 * Class SelectYearFilterSettingTypeFactory for build up filter instance.
 *
 * @package MetaModels\Filter\Setting
 */
class SelectYearFilterSettingTypeFactory extends AbstractFilterSettingTypeFactory
{
    /**
     * {@inheritDoc}
     */
    public function __construct()
    {
        parent::__construct();

        $this
            ->setTypeName('selectyear')
            ->setTypeIcon('system/modules/metamodelsfilter_selectyear/html/filter_select.png')
            ->setTypeClass('MetaModels\Filter\Setting\SelectYear')
            ->allowAttributeTypes();

        foreach (array('timestamp') as $attribute) {
            $this->addKnownAttributeType($attribute);
        }
    }
}
