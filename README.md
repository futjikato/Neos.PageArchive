# Neos Page Freezer

This page is in early development stage and you
probably don´t want to use it in production
environments.

## Installation

`composer require futjikato/pagefreeze`

### Usage

Add the `Futjikato.PageArchive:FreezableMixin`
mixin to your page node types you want to be
able to freeze.

Example:
```
'Vendor.Site.Page:NewsArticle':
  superTypes:
    'TYPO3.Neos.NodeTypes:Page': true
    'Futjikato.PageArchive:FreezableMixin': true
```

This will add the "Freeze page" checkbox in the
inspector. Just check that box and save to freeze
the page.

Frozen pages will not show up in your page tree
and cannot be edited.

To unfreeze go to the new "page freezer" module
in your admin burger menu.
There you find a list with all frozen pages.
Simply hit the "Unfreeze" button next to the
page you want to unfreeze. The page
will now be back in the tree and editable.