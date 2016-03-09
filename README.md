# Neos Page Archive

This page is in early development stage and you
probably don´t want to use it in production
environments.

## Installation

`composer require futjikato/pagearchive`

### Usage

Add the `Futjikato.PageArchive:ArchivableMixin`
mixin to your page node types you want to be
able to archive.

Example:
```
'Vendor.Site.Page:NewsArticle':
  superTypes:
    'TYPO3.Neos.NodeTypes:Page': true
    'Futjikato.PageArchive:ArchivableMixin': true
```

This will add the "Archive page" checkbox in the
inspector. Just check that box and save to archive
the page.

Archived pages will not show up in your page tree
and cannot be edited.

To remove a page from the archive go to the new
"page archive" module in your admin burger menu.
There you find a list with all archived pages.
Simply hit the "Unarchive" button next to the
page you want to remove from archive. The page
will now be back in the tree and editable.