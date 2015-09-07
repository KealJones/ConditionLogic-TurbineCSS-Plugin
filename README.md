# ConditionLogic-TurbineCSS-Plugin
##### CAUTION THIS PLUGIN CURRENTLY USES EVAL COULD CAUSE MAJOR SECURITY ISSUES

This plugin adds the ability to use if statment type logic in TurbineCSS.

This can be used for alot of potential use cases.
ex. Testing if its a holiday, changes the logo path in your css.

# Use:
As the value of any css property use: `cond(condition,true,false)`

Ex.
```
@turbine
    plugins:cond

@constants
    sundayColor:#C02222

#foo
    color:cond(date('j') == 7,$sundayColor,#fff)
```

# Todo:
1. Fix up single instance condition statements
2. Create switch statement type logic for multiple tests
