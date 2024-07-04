# Vanilo Admin Changelog

## Unreleased
##### 2024-XX-YY

- Fixed the impossibility to fold out subtaxons
- Added language field to the channel form
- Added the new v4.1 taxon content fields (`subtitle`, `excerpt`, `description`, `top_content`, `bottom_content`) to the taxon form
- Added the link editing feature on product forms
- Added the `admin_link_to()` helper function
- Added JSON-capable handling of order index, along with `?number=XXX` filter
- Changed the minimum Vanilo requirement to v4.1

## 4.0.0
##### 2024-05-06

- Added Vanilo v4 support
- Added PHP 8.3 support
- Added Laravel 11 support
- Dropped Vanilo v3 support
- Dropped PHP 8.0 & 8.1 support
- Dropped Laravel 9 support
- Upgraded to AppShell 4, Bootstrap 5.3 and to Konekt Components v3
- Upgraded migrations to ACL v2
- Upgraded to Laravel Media Library v11
- Changed minimally required Laravel version to v10.43
- Changed minimally required Gears version to v1.12
- Changed minimally required Concord version to v1.15
- Changed the image index to use thumbnails instead of the carousel
- Changed most of the common CRUD components to use the generic AppShell components
- Changed the order list side menu item to include `?status=open`
- Removed the implicit `status=open` filter from '/manage/order' if no explicit status query was given  
- Improved the UI
- Fixed the link to master products on the order item list
- Added the JSON variant of product index responses
- Added updating the sort order when setting the primary image (uses MediaLibrary default sorting facility)
- Added Tax Category CRUD
- Added optional pricelist plugin support to channel form
- Added the `currency` field to the channels form (VFW 4 feature)
- Added the `is_hidden` field to property screens
- Added the `backorder` field to product and variant forms (VFW 4 feature)
- Added tax category editing to product forms
- Added multichannel editing features to products, shipping methods and payment methods
- Added the emission of `OrderProcessingStarted` event when changing the order status (forward port from v3.7)
- Added the listing of order item adjustments
- Added the `domain` field to the channel form
- Added billing and shipping zones to the channel form
- Added zone support to payment methods
- Added an alternative route `vanilo.admin.alt.master_product_variant.show` that shows a variant, but doesn't require passing the master id

## 3.7.1
##### 2023-12-17

- Added PHP 8.3 support

## 3.7.0
##### 2023-12-15

- Added the emission of `OrderProcessingStarted` (added in v3.7) event when changing the order status
- Fixed the link to master products on the order item list (backport from v4-dev)

## 3.6.0
##### 2023-03-12

- Added Laravel 10 support
- Added Zone CRUD
- Added zone and calculator editing option to shipping methods
- Added zone to shipping method list
- Added the payment `subtype` field to the order/payments list
- Added adjustments (like shipping fee, promotion, etc.) to the bottom of the order item list
- Added alternate color to the new `processing` order status
- Changed minimum Vanilo requirement to v3.6.2
- Changed minimum AppShell requirement to v3.9
- Changed minimum Address module requirement to v2.7


## 3.5.1
##### 2023-02-24

- Fixed the product index pagination bug due to the multi-model collection

## 3.5.0
##### 2023-02-23

- Added the `description` field to the master product variant screen
- Added filters widget on top of the order list
- Added number filter to the order list
- Added the enhanced status filter to the order list
- Added shipping method and shipment lists to the order page
- Removed the "Show closed orders"/"Hide closed orders" button in favour of the new status filter
- Changed the status badge color to `warning` for cancelled orders in the order list
- Changed minimum Vanilo requirement to v3.5.1
- Changed minimum AppShell requirement to v3.7

## 3.4.1
##### 2023-02-11

- Fixed broken pagination links on product admin

## 3.4.0
##### 2023-01-25

- Added Carrier CRUD
- Added Shipping method CRUD
- Changed minimal Vanilo requirement to v3.4.1

## 3.3.0
##### 2023-01-06

- Added listing of Master products along with classic products
- Added `original_price` field to the product form
- Added webp image support
- Added master product variant CRUD
- Changed minimal Media Library requirement from 10.0 to v10.3.6 (for webp support)
- Changed minimal Vanilo requirement to v3.3
- Changed minimum Concord requirement to v1.12
- Fixed master product creation & edit form (fields were missing)
- Fixed missing Media for/forId validation messages

## 3.2.0
##### Never

This release was skipped in order to keep version parity match with Vanilo Framework.

## 3.1.0
##### 2022-11-17

- Added Master product CRUD
- Added link to product when listing order items
- Added Channel to order show page (if an order has an assigned one)
- Added Enum v4 support
- Changed minimum Laravel requirement to 9.2
- Changed minimum AppShell requirement to v3.3
- Fixed Payment method listing error in case of unconfigured gateways
- Fixed Order display error for orders without shipping address 

## 3.0.1
##### 2022-05-23

- Fixed invalid route error after assign categories to product

## 3.0.0
##### 2022-05-21

- Extracted from Vanilo Framework, the Admin is now a standalone and optional module 
- Changed route names from `vanilo.x.y` to `vanilo.admin.x.y`
- Upgrade to AppShell 3.0 (vuejs -> alpinejs)
- Fixed missing payment methods breadcrumbs

---

The Changelog of earlier versions can be found at [Changelog.old.md](Changelog.old.md).
