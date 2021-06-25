#!/bin/bash

bin/magento setup:static-content:deploy -f
bin/magento cache:clean
bin/magento cache:flush

echo "All clear"
