<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Rdtech\Masterprice\Api;

/**
 * @api
 */
interface ApidiscountInterface
{
  /**
   * Insert Table Price
   *
   * @return boolean|array
   */
  public function insertDiscount();
}
