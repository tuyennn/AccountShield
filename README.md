# Account Shield - Magento 2
---

Account Shield Magento 2 module is implements the user authentication security methods such Account Lockout, Password Expiry etc outside Default Magento 2 protection engine.

[![License: GPL v3](https://img.shields.io/badge/License-GPL%20v3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.me/thinghost)

---
## [![Alt GhoSter](http://thinghost.info/wp-content/uploads/2015/12/ghoster.png "thinghost.info")](http://thinghost.info) Overview

- [Extension on GitHub](https://github.com/tuyennn/AccountShield)
- [Direct download link](https://github.com/tuyennn/AccountShield/tarball/master)

## Main Features

* Prevent a Customer or an Admin user fails certain number of login attempts due to invalid password then that user's account will be locked out for certain time period.
* Configured maximum login attempts in Admin.
* Unlock those account were marked as Locked.
* Slowing down online password guessing attacks.
* Protect from the spam bot attacks etc.
* Of course, this protection was outside from default Implemented Magento Security Modules

## Configure and Manage the Account Shield

* Enable - Enable or disable an Account Lockout.
* Threshold - Number of consecutive failed sign in attempts. (Default is 3).
* Interval Duration - Number of seconds defined how long an account will remain as locked out (Default is 900 Seconds)

## Installation with Composer

* Connect to your server with SSH
* Navigation to your project and run these commands
 
```bash
composer require ghoster/accountshield


php bin/magento setup:upgrade
rm -rf pub/static/* 
rm -rf var/*

php bin/magento setup:static-content:deploy
```

## Installation without Composer

* Download the files from github: [Direct download link](https://github.com/tuyennn/AccountShield/tarball/master)
* Extract archive and copy all directories to app/code/GhoSter/AccountShield
* Go to project home directory and execute these commands

```bash
php bin/magento setup:upgrade
rm -rf pub/static/* 
rm -rf var/*

php bin/magento setup:static-content:deploy
```
## Licence

[Open Software License (OSL 3.0)](http://opensource.org/licenses/osl-3.0.php)


## Donation

If this project help you reduce time to develop, you can give me a cup of coffee :) 

[![paypal](https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif)](https://www.paypal.me/thinghost)