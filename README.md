# HS translation Bundle

## Warning

This is a work in progress. Do not use this in production.

## Introduction

Manage i18n strings in the database.

## Missing translations

Missing translation strings can be automatically gathered and put in the database via a event listener.
By default, the listener is disabled. To enable it, add the following lines in `app/config.php`:
```
hs_translation:
    gather_missing_translation:
        enabled: true
```

You can bypass the gathering of terms by defining the domain they belong to:
```
hs_translation:
    gather_missing_translation:
        ...
        bypassed_domains:
            - admin
            - ...
```