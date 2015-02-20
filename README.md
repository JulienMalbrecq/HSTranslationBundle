# HS translation Bundle

## Introduction

Manage i18n strings in the database.

## Installation

### Via composer

Add the repository to your composer.json:
```
    ...
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/JulienMalbrecq/HSTranslationBundle.git"
        }
    ],
    ...
```

Add then the bundle to the list of requirements:
```
    ...
    "require": {
        "hs/translation-bundle": "dev-master",
        ...
    },
    ...
```

## Basic Configuration

Configure first the directory that will be used to generate the translation 'trigger' files in `config.yml`.
The languages and translation domains used by your application have to be defined there too:
```
hs_translation:
    translation_directory: %kernel.root_dir%/Resources/translations # this is the default translation directory
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

You can gather the translation via the `translation:update` command using the `db` format too:
```
app\console translation:update --output-format=db --force fr AcmeDemoBundle
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