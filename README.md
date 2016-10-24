Semaio_CustomSku
================

Allow customers and backend users to specify customer's own SKU for the products of an online shop.

Facts
-----
* Version: 1.1.0

Functionality
-------------

In larger B2B online shops it is a typical use case that customers have custom SKUs for the products of the shop owner and they order only the products with the custom SKUs.

#### Features
- The customer can define the custom SKUs in the customer account
- THe custom SKU will be shown (if applicable) in the cart, checkout review, order/invoice/creditmemo/shipment views in the customer account
- The custom SKU will always be automatically set onto a quote item and transferred to the order item for further processing (e.g. order export)
- The custom SKU will be shown in the admin order view.
- A backend user can define the custom SKUs in the customer account

#### Backend item row data
- Please use a adminhtml theme to customize item row data
- copy /app/design/adminhtml/default/default/template/sales/items/column/name.phtml to your own adminhtml theme
- copy /app/design/adminhtml/default/default/template/sales/order/create/items/grid.phtml to your own adminhtml theme
- set your custom adminhtml theme in your project's customization module with:
    <config>
        ...
        <stores>
            <admin>
                <design>
                    <theme>
                        <default>[your_theme]</default>
                    </theme>
                </design>
            </admin>
        </stores>
        ...
    </config>

Support
-------
If you encounter any problems or bugs, please create an issue on [GitHub](https://github.com/semaio/Magento1-CustomSku/issues).

Contribution
------------
Any contribution to the development of MageSetup is highly welcome. The best possibility to provide any code is to open a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

Licence
-------
[Open Software License (OSL 3.0)](http://opensource.org/licenses/osl-3.0.php)

Copyright
---------
(c) 2016 Rouven Alexander Rieker
(c) 2016 Nicolas Graeter
