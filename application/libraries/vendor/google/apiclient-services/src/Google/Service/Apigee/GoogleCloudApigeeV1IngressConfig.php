<?php
/*
 * Copyright 2014 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not
 * use this file except in compliance with the License. You may obtain a copy of
 * the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations under
 * the License.
 */

class Google_Service_Apigee_GoogleCloudApigeeV1IngressConfig extends Google_Collection
{
  protected $collection_key = 'environmentGroups';
  protected $environmentGroupsType = 'Google_Service_Apigee_GoogleCloudApigeeV1EnvironmentGroupConfig';
  protected $environmentGroupsDataType = 'array';
  public $name;
  public $revisionCreateTime;
  public $revisionId;
  public $uid;

  /**
   * @param Google_Service_Apigee_GoogleCloudApigeeV1EnvironmentGroupConfig
   */
  public function setEnvironmentGroups($environmentGroups)
  {
    $this->environmentGroups = $environmentGroups;
  }
  /**
   * @return Google_Service_Apigee_GoogleCloudApigeeV1EnvironmentGroupConfig
   */
  public function getEnvironmentGroups()
  {
    return $this->environmentGroups;
  }
  public function setName($name)
  {
    $this->name = $name;
  }
  public function getName()
  {
    return $this->name;
  }
  public function setRevisionCreateTime($revisionCreateTime)
  {
    $this->revisionCreateTime = $revisionCreateTime;
  }
  public function getRevisionCreateTime()
  {
    return $this->revisionCreateTime;
  }
  public function setRevisionId($revisionId)
  {
    $this->revisionId = $revisionId;
  }
  public function getRevisionId()
  {
    return $this->revisionId;
  }
  public function setUid($uid)
  {
    $this->uid = $uid;
  }
  public function getUid()
  {
    return $this->uid;
  }
}
