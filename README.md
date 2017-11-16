# Ternary - TurbineCSS Plugin
##### CAUTION THIS PLUGIN USES EVAL COULD CAUSE MAJOR SECURITY ISSUES

This plugin adds the ability to use ternary statements as property values in TurbineCSS.

Sample Use Cases:
- If it is a holiday change the colors and background to a holiday themes.
- If enviroment is in debug mode display special hidden elements.

# Setup & Usage:

*Setup*:
- Copy `ternary.php` into the `plugins` folder of TurbineCSS.
- Add `ternary` to plugin list:
```
@turbine
    plugins:ternary
```

*Usage*:
Template: `condition ? true : false`

Basic Ex.
```php
@constants
    debug: true

#foo
    display: $debug == true ? "block" : "none";
```
Result:
```css
#foo { display: block; }
```

Advanced Ex.
```php
#foo
    color: date("Y") == 2017 ? "#87AE4F" : "#".date("Y")."BB";
```

Result for True:
```css
#foo { color: #87AE4F; }
```

Result for False: (the "2018" part of the hex color code would be the evaluated year)
```css
#foo { color: #2018BB; }
```