# easyvars

This plugin allows you to specify language variables in Kirby 3 in an easier manner with YAML files and nested keys.

# Installation

```
composer require oblik/kirby-easyvars
```
or check out the [other plugin installation methods](https://getkirby.com/docs/guide/plugins/plugin-setup-basic#the-three-plugin-installation-methods).

# Usage

Let's say you have `languages/en.php`:
```php
return array (
  'code' => 'en',
  'default' => true,
  'direction' => 'ltr',
  'locale' => 'en_US',
  'name' => 'English',
  'translations' => [
    'hello' => 'Hello',
    'button.accept' => 'Accept',
    'button.decline' => 'Decline',
  ]
);
```

Create a new file `languages/variables/en.yml' and put the variables there:
```yaml
hello: Hello
button:
  accept: Accept
  decline: Decline
```

Then change your `languages/en.php` file to the following:
```php
return array (
  'code' => 'en',
  'default' => true,
  'direction' => 'ltr',
  'locale' => 'en_US',
  'name' => 'English',
  'translations' => include option('oblik.easyvars.loader')
);
```

### That's it!
Your variables should continue to work as they did so far. In the YAML file, nested arrays are flattened and their keys are concatenated with a period (`.`). For example, the following:

```yaml
foo:
  bar: test
  baz:
    qux: test2
    lix: test3
```

is converted to:

```
Array
(
    [foo.bar] => test
    [foo.baz.qux] => test2
    [foo.baz.lix] => test3
)
```

and you can use the variables in your templates with `t('foo.baz.qux')`.
