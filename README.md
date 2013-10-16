# HS translation Bundle

## Warning

This is a work in progress. Do not use this in production.

## Introduction

Manage i18n strings in the database.

## Configuration

This is a 2 step process. First, the languages used and the translation domains have to be defined in `config.yml`:
```
hs_translation:
    languages:
        en: English
        fr: French
        nl: Dutch

    domains:
        messages: Messages
        validators: Form validators
```

Then, you can insert the configured languages and domains by using the provided installation command:
```
php app/console hs:translation:install
```

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