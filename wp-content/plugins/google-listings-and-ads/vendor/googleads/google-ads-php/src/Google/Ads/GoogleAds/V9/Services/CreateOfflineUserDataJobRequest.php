<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: google/ads/googleads/v9/services/offline_user_data_job_service.proto

namespace Google\Ads\GoogleAds\V9\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Request message for
 * [OfflineUserDataJobService.CreateOfflineUserDataJob][google.ads.googleads.v9.services.OfflineUserDataJobService.CreateOfflineUserDataJob].
 *
 * Generated from protobuf message <code>google.ads.googleads.v9.services.CreateOfflineUserDataJobRequest</code>
 */
class CreateOfflineUserDataJobRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Required. The ID of the customer for which to create an offline user data job.
     *
     * Generated from protobuf field <code>string customer_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $customer_id = '';
    /**
     * Required. The offline user data job to be created.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v9.resources.OfflineUserDataJob job = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     */
    protected $job = null;
    /**
     * If true, the request is validated but not executed. Only errors are
     * returned, not results.
     *
     * Generated from protobuf field <code>bool validate_only = 3;</code>
     */
    protected $validate_only = false;
    /**
     * If true, match rate range for the offline user data job is calculated and
     * made available in the resource.
     *
     * Generated from protobuf field <code>bool enable_match_rate_range_preview = 5;</code>
     */
    protected $enable_match_rate_range_preview = false;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $customer_id
     *           Required. The ID of the customer for which to create an offline user data job.
     *     @type \Google\Ads\GoogleAds\V9\Resources\OfflineUserDataJob $job
     *           Required. The offline user data job to be created.
     *     @type bool $validate_only
     *           If true, the request is validated but not executed. Only errors are
     *           returned, not results.
     *     @type bool $enable_match_rate_range_preview
     *           If true, match rate range for the offline user data job is calculated and
     *           made available in the resource.
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Google\Ads\GoogleAds\V9\Services\OfflineUserDataJobService::initOnce();
        parent::__construct($data);
    }

    /**
     * Required. The ID of the customer for which to create an offline user data job.
     *
     * Generated from protobuf field <code>string customer_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customer_id;
    }

    /**
     * Required. The ID of the customer for which to create an offline user data job.
     *
     * Generated from protobuf field <code>string customer_id = 1 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param string $var
     * @return $this
     */
    public function setCustomerId($var)
    {
        GPBUtil::checkString($var, True);
        $this->customer_id = $var;

        return $this;
    }

    /**
     * Required. The offline user data job to be created.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v9.resources.OfflineUserDataJob job = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @return \Google\Ads\GoogleAds\V9\Resources\OfflineUserDataJob|null
     */
    public function getJob()
    {
        return $this->job;
    }

    public function hasJob()
    {
        return isset($this->job);
    }

    public function clearJob()
    {
        unset($this->job);
    }

    /**
     * Required. The offline user data job to be created.
     *
     * Generated from protobuf field <code>.google.ads.googleads.v9.resources.OfflineUserDataJob job = 2 [(.google.api.field_behavior) = REQUIRED];</code>
     * @param \Google\Ads\GoogleAds\V9\Resources\OfflineUserDataJob $var
     * @return $this
     */
    public function setJob($var)
    {
        GPBUtil::checkMessage($var, \Google\Ads\GoogleAds\V9\Resources\OfflineUserDataJob::class);
        $this->job = $var;

        return $this;
    }

    /**
     * If true, the request is validated but not executed. Only errors are
     * returned, not results.
     *
     * Generated from protobuf field <code>bool validate_only = 3;</code>
     * @return bool
     */
    public function getValidateOnly()
    {
        return $this->validate_only;
    }

    /**
     * If true, the request is validated but not executed. Only errors are
     * returned, not results.
     *
     * Generated from protobuf field <code>bool validate_only = 3;</code>
     * @param bool $var
     * @return $this
     */
    public function setValidateOnly($var)
    {
        GPBUtil::checkBool($var);
        $this->validate_only = $var;

        return $this;
    }

    /**
     * If true, match rate range for the offline user data job is calculated and
     * made available in the resource.
     *
     * Generated from protobuf field <code>bool enable_match_rate_range_preview = 5;</code>
     * @return bool
     */
    public function getEnableMatchRateRangePreview()
    {
        return $this->enable_match_rate_range_preview;
    }

    /**
     * If true, match rate range for the offline user data job is calculated and
     * made available in the resource.
     *
     * Generated from protobuf field <code>bool enable_match_rate_range_preview = 5;</code>
     * @param bool $var
     * @return $this
     */
    public function setEnableMatchRateRangePreview($var)
    {
        GPBUtil::checkBool($var);
        $this->enable_match_rate_range_preview = $var;

        return $this;
    }

}

