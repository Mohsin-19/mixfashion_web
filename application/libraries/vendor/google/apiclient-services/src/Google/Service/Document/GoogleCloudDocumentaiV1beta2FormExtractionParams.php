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

class Google_Service_Document_GoogleCloudDocumentaiV1beta2FormExtractionParams extends Google_Collection
{
  protected $collection_key = 'keyValuePairHints';
  public $enabled;
  protected $keyValuePairHintsType = 'Google_Service_Document_GoogleCloudDocumentaiV1beta2KeyValuePairHint';
  protected $keyValuePairHintsDataType = 'array';
  public $modelVersion;

  public function setEnabled($enabled)
  {
    $this->enabled = $enabled;
  }
  public function getEnabled()
  {
    return $this->enabled;
  }
  /**
   * @param Google_Service_Document_GoogleCloudDocumentaiV1beta2KeyValuePairHint
   */
  public function setKeyValuePairHints($keyValuePairHints)
  {
    $this->keyValuePairHints = $keyValuePairHints;
  }
  /**
   * @return Google_Service_Document_GoogleCloudDocumentaiV1beta2KeyValuePairHint
   */
  public function getKeyValuePairHints()
  {
    return $this->keyValuePairHints;
  }
  public function setModelVersion($modelVersion)
  {
    $this->modelVersion = $modelVersion;
  }
  public function getModelVersion()
  {
    return $this->modelVersion;
  }
}
