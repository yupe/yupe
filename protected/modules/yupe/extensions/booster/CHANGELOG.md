# ChangeLog
## Special Thanks
I would like to personally thank everyone of you that spend your valuable time helping improving this extension, by pointing out bugs and/or providing solutions that all of us can take advantage with.

Thank you all

Antonio Ramirez
Senior Web Developer
[www.clevertech.biz](http://www.clevertech.biz)

### YiiBooster version 1.0.6
- **(fix)** Now it is possible to provide custom 'class' and 'style' htmlOptions for TbProgress #216 (hijarian)
- **(fix)** Fix typo on TbCollapse (tonydspaniard)
- **(fix)** Dropdown in collapse not showing on first attempt (hijarian)
- **(fix)** 2nd header from responsive table overlaps the 1st responsive table header #259 (hijarian)
- **(fix)** datepicker 404 error #189 (tonydspaniard)
- **(fix)** TbExtendedGridView Bulk Actions Bug #155 (tonydspaniard)
- **(enh)** Add option to disable asset publication in debug mode #229 (suralc)
- **(fix)** Fixed the CSS-including behavior of TbHtml5Editor #290 #311 (hijarian)
- **(fix)** Now assets for TbDateRangePicker are being registered with default settings instead of hard-coded POS_HEAD #266 #297 (hijarian)
- **(fix)** Added correct handling of the composite primary keys in the `TbEditableField` #287 (abeel)
- **(enh)** Added masked text field type #281 (tkijewski)
- **(enh)** Added typeahead text field type #296 (tkijewski)
- **(enh)** Added number field type (xt99)
- **(enh)** TbToggleColumn now extends TbDataColumn #303 #323 (kev360)
- **(fix)** Ajax submit button does not force the POST method anymore #284 (yourilima)
- **(fix)** Fixed TimePicker #314 (marsuboss)
- **(fix)** Fixed bootstrap.datepicker.<lang>.js #341 (fdelprete)
- **(fix)** Fixed TbJEditableColumn which could not be edited when value is empty initially #339 (rumal)
- **(fix)** TimePicker did not released focus in Webkit browsers #364 (ciarand)
- **(fix)** DateRangePicker TbActiveForm field row was not closed properly #352 (despro3)
- **(enh)** Added a TbImageGallery widget #335 (magefad)
- **(fix)** Allow to use url parameter in TbTabs #360 (magefad)
- **(enh)** Add option "fontAwesomeCss" for to active Font Awesome CSS (marsuboss)
- **(enh)** Fixed TbEditable - mode(modal|inline); language,support for datepicker, app lang by default (magefad)
- **(fix)** Add option "disabled" on TbEditableField
- **(enh)** Add empty (null) value display for TbToggleColumn ("icon-question-sign" icon with "Not Set" label) (magefad)
- **(fix)** Fixed typeAheadField #396 (magefad)
- **(fix)** StickyTableHeader issue dynamic cell width #338, updated js, added compressed js (magefad)
- **(fix)** Keep document title when HTML5 history API is enabled (nevkontakte)
- **(fix)** Fixed wrong behavior of TbJsonGridView when doing AJAX updates like row deletion when there is pagination (nevkontakte)
- **(enh)** Bootstrap upgrade to 2.3.1 (magefad)
- **(fix)** Added rowHtmlOptionsExpression support for TbExtendedGridView (xt99)
- **(enh)** TbButtonGroup does not accept TbButton.dropdownOptions #149 (russ666)
- **(enh)** Added GridView visual aid on hover for sorting (Wiseon3)
- **(enh)** Updated daterangepicker plugin (magefad)
- **(fix)** CSqlDataprovider support #356 (magefad)
- **(fix)** TbTypeahead - Add attribute autocomplete="off" by default #285
- **(enh)** Update Redactor to 8.2.3 #386 (magefad)
- **(fix)** baseID in checkBoxList and radioButtonList can now be customized via htmlOptions, added container support - yii 1.1.13 (fad)
- **(fix)** Corrected close link (with twitter bootstrap recommendations) bb53
- **(fix)** Fixed label association when input has a user-defined id attribute (fixes bb72)
- **(fix)** Button input, button submit added in TbButton
- **(fix)** Fix missing close tags in TbCarousel
- **(enh)** Added CONTAINER_PREFIX constant for html div container id
- **(fix)** Added class "hide" to modal div
- **(fix)** Add support for non-link brand in TbNavbar


### YiiBooster version 1.0.5

- **(fix)** TbCarousel displayPrevAndNext set to false breaks the page (amosviedo)
- **(enh)** Bootstrap upgrade to 2.2.1 (kazuo)
- **(fix)** TbActiveForm class name is displayed on screen (sorinpohontu)
- **(fix)** TbExtendedGridView Bulk Actions Bug (tonydspaniard)
- **(enh)** Updated jquery-ui LESS (kazuo)
- **(enh)** Bootbox now can be activated/deactived at will (tonydspaniard)
- **(enh)** Added TbExtendedGridFilter widget (tonydspaniard)
- **(enh)** Added JSONStorage component (tonydspaniard)
- **(fix)** Overrided TbBox bug by upgrade (ragazzo)
- **(enh)** Now TbBox can hold multiple types of buttons (dragnet)
- **(enh)** Added bootstrap styles to TbSelect2 widget (DonFelipe)
- **(enh)** Added radioButton group list support (xpoft)
- **(fix)** Hungarian translation corrected (pappfer)
- **(fix)** renderKeys() in TbExtendedGridView generates invalid html (TrueTamTam)
- **(fix)** TbFileUpload - bug in global progressbar (appenshin)
- **(enh)** Added support to TbActiveForm to use TbSelect2 widget (tonydspaniard)
- **(enh)** Added MarkDown Editor (kazuo)
- **(fix)** 2nd header from responsive table overlaps the 1st responsive table header #246 (hijarian)
- **(fix)** Divider symbols in breadcrumbs changed to HTML entities (wkii)
- **(fix)** Divider in active items in breadcrumbs was outside of the `li` tag (wkii)
