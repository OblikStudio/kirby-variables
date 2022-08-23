# kirby-variables

Allows you to easily manage language variables by putting them in separate YAML files and nesting them.

## ⚠ Deprecated!

By putting variables in separate files, you aren't really gaining much. You'd be much better off having a "variables" or "texts" tab in your `site.yml` and just putting simple `text` fields in there, optionally with help text, placeholder, etc.

If you really need to load variables from a file, you could do it like this:

```php
'translations' => Yaml::decode(F::read(kirby()->root('languages') . '/vars/en.yml'))
```

Or, alternatively, you could use [bnomei/autoloader-for-kirby](https://github.com/bnomei/autoloader-for-kirby).

# Installation

With [Composer](https://packagist.org/packages/oblik/kirby-variables):

```
composer require oblik/kirby-variables
```

# Usage

After you've installed the plugin and you open your site, the plugin will run and it will automatically get the variables from your PHP files and put them in YAML files in the same directory. After that, you can remove the variables from your PHP files, as they're no longer needed. Then, use the YAML files to manage your variables.

Your variables should continue to work as they did so far. In the YAML file, nested arrays are flattened and their keys are concatenated with a period (`.`). For example, the following:

```yaml
foo:
  bar: test
  baz:
    qux: test2
```

...is converted to:

```
Array
(
    [foo.bar] => test
    [foo.baz.qux] => test2
)
```

...and you can use the variables in your templates with `t('foo.baz.qux')`.

## Config

### `folder`

Sets where the YAML files are stored:

```php
'oblik.variables.folder' => function ($kirby) {
    return $kirby->root('content') . '/_variables';
}
```
