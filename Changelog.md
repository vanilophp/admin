# Vanilo Admin Changelog

## Unreleased
##### 2022-XX-YY

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
