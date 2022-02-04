**Version 1.0** (04.02.2022)

Custom class "Mautic" to embed Mautic to the page

## CONFIGURATION OPTIONS
$Mautic_URL: URL to Mautic installation
$Mautic_inlineTracking: Embed tracking code inside html
$Mautic_inlineFormScript: Embed form tracking code inside html

## CONFIGURATION FILE
```
"mautic": {
  "url": "https://example.ccom/mautic",
  "inlineTracking": 0;
  "inlineFormScript": 0;
}
```

## USAGE
Return form
```
[mautic type="form" id="FormID"]
```

Return dynamic content
```
[mautic type="content" slot="SlotName"][/mautic]
```
