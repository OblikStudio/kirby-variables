# kirby-variables

Allows you to easily manage language variables by putting them in separate YAML files and nesting them.

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
