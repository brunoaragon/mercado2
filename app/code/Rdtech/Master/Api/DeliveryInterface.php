<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Rdtech\Master\Api;

/**
 * @api
 */
interface DeliveryInterface
{
  /**
   * Set default shipping address
   *
   * @return boolean|array
   */
  public function getDeliveryDate();
}
