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

use MetaModels\Filter\Rules\SimpleQuery;
use MetaModels\Filter\Setting\Simple;
use MetaModels\Filter\IFilter;
use \MetaModels\Filter\Rules\StaticIdList as MetaModelFilterRuleStaticIdList;

/**
 * Filter "select year field" for FE-filtering, based on filters by the meta models team.
 *
 * @package    MetaModels
 * @subpackage FilterSelectYear
 * @author     Christopher Bölter <metamodels@boelter.eu>
 */
class SelectYear extends SimpleLookup
{
    /**
     * Overrides the parent implementation to always return true, as this setting is always available for FE filtering.
     *
     * @return bool true as this setting is always available.
     */
    public function enableFEFilterWidget()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    protected function getParamName()
    {
        if ($this->get('urlparam')) {
            return $this->get('urlparam');
        }

        $objAttribute = $this->getMetaModel()->getAttributeById($this->get('attr_id'));
        if ($objAttribute) {
            return $objAttribute->getColName();
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    protected function isActiveFrontendFilterValue($arrWidget, $arrFilterUrl, $strKeyOption)
    {
        return in_array($strKeyOption, (array) $arrWidget['value']) ? true : false;
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameterFilterOptions($objAttribute, $arrIds, &$arrCount = null)
    {
        $arrOptions = $objAttribute->getFilterOptions(
            $this->get('onlypossible') ? $arrIds : null,
            (bool) $this->get('onlyused'),
            $arrCount
        );

        $arrNewOptions = array();
        // Sort the values, first char uppercase.
        foreach ($arrOptions as $strOptionsValue => $strOptionLabel) {
            if ($strOptionsValue == '-' || $strOptionLabel == '-') {
                continue;
            }

            $parsedYear                 = \Date::parse('Y', $strOptionsValue);
            $arrNewOptions[$parsedYear] = $parsedYear;
        }
        arsort($arrNewOptions);
        $arrOptions = $arrNewOptions;

        return $arrOptions;
    }

    /**
     * {@inheritdoc}
     */
    public function prepareRules(IFilter $objFilter, $arrFilterUrl)
    {
        $objMetaModel  = $this->getMetaModel();
        $objAttribute  = $objMetaModel->getAttributeById($this->get('attr_id'));
        $strParamName  = $this->getParamName();
        $strParamValue = $arrFilterUrl[$strParamName];

        if ($objAttribute && $strParamName && $strParamValue) {
            $strQuery = sprintf(
                'SELECT id FROM %s WHERE FROM_UNIXTIME(%s, "%%Y") = ?',
                $this->getMetaModel()->getTableName(),
                $objAttribute->getColName()
            );

            $objFilter->addFilterRule(new SimpleQuery($strQuery, array($strParamValue)));
            return;
        }

        $objFilter->addFilterRule(new MetaModelFilterRuleStaticIdList(null));
    }
}
