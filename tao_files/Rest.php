<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2013-2014 (original work) Open Assessment Technologies SA
 *
 */


//THIS IS PPSDM MODIFIED. LOCATION IS taoGroups/controller/
namespace oat\taoGroups\controller;

use core_kernel_classes_Property;
use oat\generis\model\user\PasswordConstraintsException;
use \tao_actions_CommonRestModule;
use oat\taoGroups\models\CrudGroupsService;
use oat\taoGroups\models\GroupsService;

/**
 *
 * @author plichart
 */
class Rest extends tao_actions_CommonRestModule
{
    const CLASS_URI = 'http://www.tao.lu/Ontologies/TAOGroup.rdf#Group';

    const PROPERTY_MEMBERS_URI = 'http://www.tao.lu/Ontologies/TAOGroup.rdf#member';
    /**
     * @return CrudGroupsService
     */
    protected function getCrudService()
    {
        if (!$this->service) {
            $this->service = CrudGroupsService::singleton();
        }
        return $this->service;
    }

    /**
     * Optionnaly a specific rest controller may declare
     * aliases for parameters used for the rest communication
     */
    protected function getParametersAliases()
    {
        return array_merge(parent::getParametersAliases(), array(
            "member" => GroupsService::PROPERTY_MEMBERS_URI
        ));
    }

    /**
     * Optionnal Requirements for parameters to be sent on every service
     * you may use either the alias or the uri, if the parameter identifier
     * is set it will become mandatory for the method/operation in $key
     * Default Parameters Requirents are applied
     * type by default is not required and the root class type is applied
     *
     * @example :"post"=> array("login", "password")
     */
    protected function getParametersRequirements()
    {
        return array();
    }

    public function post()
    {
        try {
            /** @var \core_kernel_classes_Resource $testTakerResource */
            $testTakerResource = parent::post();

            $this->returnSuccess([
                'success' => true,
                'uri' => $testTakerResource->getUri(),
            ], false);
        } catch (PasswordConstraintsException $e) {
            $this->returnFailure(new common_exception_RestApi($e->getMessage()));
        } catch (common_exception_ValidationFailed $e) {
            $alias = $this->reverseSearchAlias($e->getField());
            $this->returnFailure(new common_exception_ValidationFailed($alias, null, $e->getCode()));
        } catch (Exception $e) {
            $this->returnFailure($e);
        }
    }

    public function put($uri = null)
    {

        //must use short name : mail NOT email, etc
        $uri2 = $this->getRequestParameter('uri');
        $subj = $this->getRequestParameter('member');
//        print_r($this->getParameters());
////         $this->returnFailure(new common_exception_RestApi('Not implemented.'));
        try {
            /** @var \core_kernel_classes_Resource $testTakerResource */
            $testTakerResource = parent::put($uri2);

//            $par = $this->getParameters();
//            echo $uri2;

//   print_r($par[self::PROPERTY_MEMBERS_URI]);

            $user = new \core_kernel_classes_Resource($subj);
            $user->setPropertyValue(new core_kernel_classes_Property(self::PROPERTY_MEMBERS_URI), $uri2);


            $this->returnSuccess([
                'success' => true,
                'uri' => $uri2,
            ], false);
        } catch (PasswordConstraintsException $e) {
            $this->returnFailure(new common_exception_RestApi($e->getMessage()));
        } catch (common_exception_ValidationFailed $e) {
            $alias = $this->reverseSearchAlias($e->getField());
            $this->returnFailure(new common_exception_ValidationFailed($alias, null, $e->getCode()));
        } catch (Exception $e) {
            $this->returnFailure($e);
        }
    }


}