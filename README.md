# TYPO3 Plates integration
## Integration of the [Plates](http://platesphp.com/) template engine into TYPO3.

## What is Plates?
Plates is a native template system for PHP. It's fast, easy to use and you don't have to learn any new syntax. Sounds great, right?

## About this extension

Tired of using Fluid? You don't even know what Fluid is? You're too lazy to learn You prefer native PHP templates? I've got you covered!
This extension that allows you to use the [Plates](http://platesphp.com/) inside TYPO3 (almost, I swear) the same way as you can
work with Fluid inside TYPO3.


## How to try out
0. I assume you have a working TYPO3 installation and composer installed and know how stuff works. Proper documentation will follow, but for now, you're on your own.
1. Install this extension (just download the source code and put it into `packages/` of your favorite TYPO3 project)
2. Assign the `PLATESTEMPLATE` to an existing page object, like this:
```typoscript
page = PAGE
page.10 = PLATESTEMPLATE
page.10.templateRootPath = EXT:sitepackage/Resources/Private/Templates/
```
3. Create a template file in your configured path (`EXT:sitepackage/Resources/Private/Templates/`) called `default.php` and put some code in there. You can also provide a custom name with the templateName option.
   If no name is set, there is a fallback to "default".
```php
    <p>Hello, <?=$this->e($data['title'])?></p>

```
This will put out the page title in the frontend. Of course, you can use any PHP code you want, including loops, conditions etc. Just refer to [Plates Documentation](http://platesphp.com/) for more information.
4. Open the page in your browser and look at the result. You should see the page title in a paragraph tag.


## Project goals
Provide a simple, flexible and easy to use template alternative to Fluid that simplifies stuff for new integrators,
but also looks not too unfamiliar to those who are used to working with Fluid.

## Contribution
Just open an issue and I will respond. If you want to contribute, just fork this repository and create a pull request. I will review your contribution, give you feedback.

## Disclaimer
This extension is currently a proof-of-concept and is not meant to be used in production. It is not feature-complete. It is not tested. It is not secure. Use it at your own risk.

