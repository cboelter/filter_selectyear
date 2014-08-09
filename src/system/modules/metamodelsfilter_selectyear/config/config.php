<?php

/**
 * The MetaModels extension allows the creation of multiple collections of custom items,
 * each with its own unique set of selectable attributes, with attribute extendability.
 * The Front-End modules allow you to build powerful listing and filtering of the
 * data in each collection.
 *
 * PHP version 5
 * @package    MetaModels
 * @subpackage FilterSelectYear
 * @author     Christopher Bölter <c.boelter@cogizz.de>
 * @copyright  cogizz - digital communications
 * @license    LGPL.
 * @filesource
 */

/**
 * Frontend filter
 */
$GLOBALS['METAMODELS']['filters']['selectyear']['class']         = 'MetaModels\Filter\Setting\SelectYear';
$GLOBALS['METAMODELS']['filters']['selectyear']['image']         =
	'system/modules/metamodelsfilter_select/html/filter_select.png';
$GLOBALS['METAMODELS']['filters']['selectyear']['info_callback'] = array
(
	'MetaModels\DcGeneral\Events\Table\FilterSetting\DrawSetting',
	'modelToLabelWithAttributeAndUrlParam'
);
$GLOBALS['METAMODELS']['filters']['selectyear']['attr_filter'][] = 'timestamp';
