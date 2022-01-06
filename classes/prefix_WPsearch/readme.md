**Version 2.1.1** (06.01.2022)

Custom class "prefix_WPsearch" to improve search query.

## CONFIGURATION OPTIONS
* $WPsearch_acf: list of advanced custom fields you want to search content in
* $WPsearch_tax: list of taxonomies you want to search content in

## CONFIGURATION FILE
```
"WPsearch": {
  "acf": {
    "0": "ACF FIELD NAME"
  },
  "taxonomies": {
    "0": "TAXONOMY SLUG"
  }
}
```

## USAGE
Add all ACF field names and taxonomy slugs
