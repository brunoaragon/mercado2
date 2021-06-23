<?php

/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Rdtech\Masterprice\Api;

/**
 * @api
 */
interface ApitablepriceproductInterface
{
  /**
   * Set default shipping address
   *
   * @return boolean|array
   */
  public function insertTablePriceProduct();
}
