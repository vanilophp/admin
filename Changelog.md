# Vanilo Admin Changelog

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
