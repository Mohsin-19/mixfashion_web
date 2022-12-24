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

class Google_Service_SecretManager_Replication extends Google_Model
{
  protected $automaticType = 'Google_Service_SecretManager_Automatic';
  protected $automaticDataType = '';
  protected $userManagedType = 'Google_Service_SecretManager_UserManaged';
  protected $userManagedDataType = '';

  /**
   * @param Google_Service_SecretManager_Automatic
   */
  public function setAutomatic(Google_Service_SecretManager_Automatic $automatic)
  {
    $this->automatic = $automatic;
  }
  /**
   * @return Google_Service_SecretManager_Automatic
   */
  public function getAutomatic()
  {
    return $this->automatic;
  }
  /**
   * @param Google_Service_SecretManager_UserManaged
   */
  public function setUserManaged(Google_Service_SecretManager_UserManaged $userManaged)
  {
    $this->userManaged = $userManaged;
  }
  /**
   * @return Google_Service_SecretManager_UserManaged
   */
  public function getUserManaged()
  {
    return $this->userManaged;
  }
}
