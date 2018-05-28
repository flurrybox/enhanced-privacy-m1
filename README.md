Magento 1 Enhanced Privacy extension for easier compliance with GDPR
------------- 

Extension allows customers to delete, anonymize, or export their personal data.

Prerequisites
------------- 
* Magento 1 CE or EE (tested with M1 CE 1.9.3.8)
* PHP 5.4+

Usage and Features
------------- 

Let your customers manage their Privacy Settings themself.
* Configuration for this module is located in 'System > Configuration > Customer > Customer Options > Privacy (GDPR)'.
* Account deletion, anonymization, and export can be done in 'My Account > Privacy Settings'.
* Customers can export their data in .zip archive containing .csv files with personal, wishlist, quote, and address data.
* Customer can delete or anonymize their account. Current password and reason is required. Account will be deleted within 1 hour (or as specified in configuration), in this time span its possible for customers to undo deletion.
* If customer has made at least one order, they are ineligible to delete their account, instead it will be anonymized.
* When a customer visits your store for the first time, a popup notification about cookie policy will be shown.
* Supports Dutch and English locale

Installation
------------- 

* Download files
* Upload the files to your Magento Root
* Flush Cache
* Logout and Login into Magento
* Go to System > Configuration > Customer > Customer Options > Privacy (GDPR)
* Enable and configure extension as necessary


Copyrights and License
-------------
Copyright (c) 2018 Flurrybox, Ltd. under GNU General Public License ("GPL") v3.0