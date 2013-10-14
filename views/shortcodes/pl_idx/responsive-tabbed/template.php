<?php

$template = array(

'title' => 'Responsive Tabbed Template',

'css' => '
/* Responsive Listings and Form */ 
body{font-size:100%}.pl_border-box{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}/* normalize.css v1.1.2 | MIT License | git.io/normalize */article,aside,details,figcaption,figure,footer,header,hgroup,main,nav,section,summary{display:block}audio,canvas,video{display:inline-block;*display:inline;*zoom:1}audio:not([controls]){display:none;height:0}[hidden]{display:none}html{font-size:100%;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%;font-family:sans-serif}button,input,select,textarea{font-family:sans-serif}body{margin:0}a:focus{outline:thin dotted}a:active,a:hover{outline:0}h1{font-size:2em;margin:0.67em 0}h2{font-size:1.5em;margin:0.83em 0}h3{font-size:1.17em;margin:1em 0}h4{font-size:1em;margin:1.33em 0}h5{font-size:0.83em;margin:1.67em 0}h6{font-size:0.67em;margin:2.33em 0}abbr[title]{border-bottom:1px dotted}b,strong{font-weight:bold}blockquote{margin:1em 40px}dfn{font-style:italic}hr{-moz-box-sizing:content-box;box-sizing:content-box;height:0}mark{background:#ff0;color:#000}p,pre{margin:1em 0}code,kbd,pre,samp{font-family:monospace,serif;_font-family:"courier new",monospace;font-size:1em}pre{white-space:pre;white-space:pre-wrap;word-wrap:break-word}q{quotes:none}q:before,q:after{content:"";content:none}small{font-size:80%}sub{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline;top:-0.5em}sub{bottom:-0.25em}dl,menu,ol,ul{margin:1em 0}dd{margin:0 0 0 40px}menu,ol,ul{padding:0 0 0 40px}nav ul,nav ol{list-style:none;list-style-image:none}img{border:0;-ms-interpolation-mode:bicubic}svg:not(:root){overflow:hidden}figure,form{margin:0}fieldset{border:1px solid silver;margin:0 2px;padding:0.35em 0.625em 0.75em}legend{border:0;padding:0;white-space:normal;*margin-left:-7px}button,input,select,textarea{font-size:100%;margin:0;vertical-align:baseline;*vertical-align:middle}button,input{line-height:normal}button,select{text-transform:none}button,html input[type="button"]{-webkit-appearance:button;cursor:pointer;*overflow:visible}input[type="reset"],input[type="submit"]{-webkit-appearance:button;cursor:pointer;*overflow:visible}button[disabled],html input[disabled]{cursor:default}input[type="checkbox"],input[type="radio"]{box-sizing:border-box;padding:0;*height:13px;*width:13px}input[type="search"]{-webkit-appearance:textfield;-moz-box-sizing:content-box;-webkit-box-sizing:content-box;box-sizing:content-box}input[type="search"]::-webkit-search-cancel-button,input[type="search"]::-webkit-search-decoration{-webkit-appearance:none}button::-moz-focus-inner,input::-moz-focus-inner{border:0;padding:0}textarea{overflow:auto;vertical-align:top}table{border-collapse:collapse;border-spacing:0}.pl_reset,.pl_col-1,.pl_col-111,.pl_col-112,.pl_col-122,.pl_col-123,.pl_col-124,.pl_col-135,.pl_col-12345,.pl_listings,.pl_listing,.pl_form,.pl_form-item,.pl_property,.pl_property .pl_property-slideshow,ul.pl_property-amenities{margin:0;padding:0;list-style-type:none;border-width:0;border:0;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.pl_clearfix,.pl_listing-compl{zoom:1}.pl_clearfix:before,.pl_listing-compl:before,.pl_clearfix:after,.pl_listing-compl:after{content:"\0020";display:block;height:0;overflow:hidden}.pl_clearfix:after,.pl_listing-compl:after{clear:both}@media screen and (max-width: 27em){.hide-mobile{display:none}}@media screen and (max-width: 40em){.hide-tablet{display:none}}@media screen and (min-width: 60em){.hide-desktop{display:none}}.pl_col-1,.pl_col-111,.pl_col-112,.pl_col-122,.pl_col-123,.pl_col-124,.pl_col-135,.pl_col-12345{max-width:70em;margin:0 auto;clear:both}.pl_col,ul.pl_property-amenities li{width:100%}.pl_col-full{width:100%}@media screen and (min-width: 40em){.pl_col-122 .pl_col,.pl_col-122 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-122 li,.pl_col-123 .pl_col,.pl_col-123 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-123 li,.pl_col-124 .pl_col,.pl_col-124 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-124 li{width:50%}.pl_col-135 .pl_col,.pl_col-135 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-135 li{width:33.33333%}}@media screen and (min-width: 60em){.pl_col-112 .pl_col,.pl_col-112 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-112 li{width:50%}.pl_col-123 .pl_col,.pl_col-123 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-123 li{width:33.33333%}.pl_col-124 .pl_col,.pl_col-124 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-124 li{width:25%}.pl_col-135 .pl_col,.pl_col-135 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-135 li{width:20%}}@media screen and (min-width: 27em){.pl_col-12345 .pl_col,.pl_col-12345 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-12345 li{width:50%}}@media screen and (min-width: 37em){.pl_col-12345 .pl_col,.pl_col-12345 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-12345 li{width:33.33333%}}@media screen and (min-width: 47em){.pl_col-12345 .pl_col,.pl_col-12345 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-12345 li{width:25%}}@media screen and (min-width: 60em){.pl_col-12345 .pl_col,.pl_col-12345 ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-12345 li{width:20%}}.pl_col-sidebar .pl_col,.pl_col-sidebar ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-sidebar li{float:left;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}@media screen and (min-width: 40em){.pl_col-sidebar .pl_col-sidebar--two-thirds{width:66.66667%;padding-right:20px}.pl_col-sidebar .pl_col-sidebar--one-third{width:33.33333%}}.pl_listings,.pl_listing{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.pl_listing{float:left;width:100%;margin-bottom:20px;padding:10px}.pl_listing-address{font-size:1em;line-height:1em;height:2em;overflow:hidden}.pl_listing-img-wrapper,.pl_listing-info{display:inline-block}.pl_listing-img-wrapper{overflow:hidden;vertical-align:top;width:100%}.pl_listing-img-wrapper a{display:inline-block;width:100%;height:100%}.pl_listing-img-wrapper img{width:100%}.pl_listing-fav{position:absolute;margin-top:-40px;background:rgba(0,0,0,0.8);padding:10px}.pl_listing-fav a{width:16px;height:16px;text-indent:-9999px;background:url("../img/star.png") no-repeat;display:block}.pl_listing-info{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.pl_listing-meta{font-size:1em;line-height:1em;height:1em;overflow:hidden;text-align:center}.pl_listing-meta span{padding:0 10px 0 0}.pl_listing-desc{font-size:0.8em;line-height:1.2em;height:3.6em;overflow:hidden}.pl_listing-compl img{max-width:25%;float:left;padding:0 5px 5px 0}.pl_listing-compl p{font-size:0.3em;margin:0}@media screen and (min-width: 40em){.pl_col-111 .pl_listing-img-wrapper{width:58%}.pl_col-111 .pl_listing-info{width:40%;padding-left:10px}.pl_col-111 .pl_listing-address{font-size:1.2em;line-height:1.2em;height:1.2em;overflow:hidden}.pl_col-111 .pl_listing-meta{height:3em;font-size:1em;line-height:1em;height:4.4em;overflow:hidden;text-align:center}.pl_col-111 .pl_listing-meta .pl_listing-price{width:100%;float:left;font-size:1.6em;line-height:2em;height:2em;overflow:hidden}.pl_col-112 .pl_listing-img-wrapper{width:50%}.pl_col-112 .pl_listing-info{width:49%;padding-left:10px}.pl_col-112 .pl_listing-address{font-size:1.2em;line-height:1.2em;height:1.2em;overflow:hidden}.pl_col-112 .pl_listing-meta{height:3em;font-size:1em;line-height:1em;height:4.4em;overflow:hidden;text-align:center}.pl_col-112 .pl_listing-meta .pl_listing-price{width:100%;float:left;font-size:1.6em;line-height:2em;height:2em;overflow:hidden}}@media screen and (min-width: 50em) and (max-width: 60em){.pl_col-122 .pl_listing-address,.pl_col-123 .pl_listing-address{font-size:1em;line-height:1em;height:1em;overflow:hidden}}@media screen and (min-width: 60em){.pl_col-122 .pl_listing-info{width:100%}}@media screen and (min-width: 60em) and (max-width: 70em){.pl_col-112 .pl_listing-desc{display:none}.pl_col-122 .pl_listing-desc{display:none}}@media screen and (min-width: 65em){.pl_col-122 .pl_listing-address{font-size:1em;line-height:1em;height:1em;overflow:hidden}}@media screen and (min-width: 70em){.pl_col-112 .pl_listing-meta{margin:0}.pl_col-122 .pl_listing-desc{font-size:0.8em;line-height:1.2em;height:2.4em;overflow:hidden;display:block}}.pl_form,.pl_form-item{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.pl_form form,.pl_form-item form{width:100%}.pl_form-group{float:left}@media screen and (min-width: 27em){.pl_form-group .pl_form-item--half{width:50%}}.pl_form-group--right,.pl_form-item--right{float:right}.pl_form-item{float:left;width:100%;margin-bottom:10px;padding:10px}.pl_form-item label{width:100%;float:left;font-size:0.8em;line-height:1.2em;height:1.5em;overflow:hidden}.pl_form-item select{width:100%}.pl_form-item input[type="text"],.pl_form-item input[type="email"],.pl_form-item input[type="password"],.pl_form-item textarea{width:100%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.pl_form-item--btn input[type="submit"]{width:100%}@media screen and (min-width: 27em){.pl_form-group.pl_form-group--input-btn .pl_form-item--input{width:70%}.pl_form-group.pl_form-group--input-btn .pl_form-item--btn{width:30%}}@media screen and (min-width: 40em){.pl_form-group.pl_form-group--input-btn .pl_form-item--input{width:80%}.pl_form-group.pl_form-group--input-btn .pl_form-item--btn{width:20%}}.pl_property{max-width:70em;margin:0 auto;clear:both;padding:0 10px}.pl_property .pl_property-slideshow{max-width:60em;margin:0 auto;clear:both}.pl_property-item{margin-bottom:30px;background:#eee}ul.pl_property-amenities li{-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;float:left}.pl_listings #container{width:100% !important}.dataTables_paginate a{font-size:0.8em !important}.pl_listing .pl_listing-img-wrapper img{width:100% !important;max-width:100% !important}.pl_col-1 tr,.pl_col-111 tr,.pl_col-112 tr,.pl_col-122 tr,.pl_col-123 tr,.pl_col-124 tr,.pl_col-135 tr,.pl_col-12345 tr{width:100%;float:left;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box}.pl_col-1 tr td,.pl_col-111 tr td,.pl_col-112 tr td,.pl_col-122 tr td,.pl_col-123 tr td,.pl_col-124 tr td,.pl_col-135 tr td,.pl_col-12345 tr td{padding:0 !important}.pl_col-1 tr td .pl_col,.pl_col-1 tr td ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-1 tr td li,.pl_col-111 tr td .pl_col,.pl_col-111 tr td ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-111 tr td li,.pl_col-112 tr td .pl_col,.pl_col-112 tr td ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-112 tr td li,.pl_col-122 tr td .pl_col,.pl_col-122 tr td ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-122 tr td li,.pl_col-123 tr td .pl_col,.pl_col-123 tr td ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-123 tr td li,.pl_col-124 tr td .pl_col,.pl_col-124 tr td ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-124 tr td li,.pl_col-135 tr td .pl_col,.pl_col-135 tr td ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-135 tr td li,.pl_col-12345 tr td .pl_col,.pl_col-12345 tr td ul.pl_property-amenities li,ul.pl_property-amenities .pl_col-12345 tr td li{width:100% !important}.pl_col-1 tr td .pl_col .pl_listing-fav,.pl_col-1 tr td ul.pl_property-amenities li .pl_listing-fav,ul.pl_property-amenities .pl_col-1 tr td li .pl_listing-fav,.pl_col-111 tr td .pl_col .pl_listing-fav,.pl_col-111 tr td ul.pl_property-amenities li .pl_listing-fav,ul.pl_property-amenities .pl_col-111 tr td li .pl_listing-fav,.pl_col-112 tr td .pl_col .pl_listing-fav,.pl_col-112 tr td ul.pl_property-amenities li .pl_listing-fav,ul.pl_property-amenities .pl_col-112 tr td li .pl_listing-fav,.pl_col-122 tr td .pl_col .pl_listing-fav,.pl_col-122 tr td ul.pl_property-amenities li .pl_listing-fav,ul.pl_property-amenities .pl_col-122 tr td li .pl_listing-fav,.pl_col-123 tr td .pl_col .pl_listing-fav,.pl_col-123 tr td ul.pl_property-amenities li .pl_listing-fav,ul.pl_property-amenities .pl_col-123 tr td li .pl_listing-fav,.pl_col-124 tr td .pl_col .pl_listing-fav,.pl_col-124 tr td ul.pl_property-amenities li .pl_listing-fav,ul.pl_property-amenities .pl_col-124 tr td li .pl_listing-fav,.pl_col-135 tr td .pl_col .pl_listing-fav,.pl_col-135 tr td ul.pl_property-amenities li .pl_listing-fav,ul.pl_property-amenities .pl_col-135 tr td li .pl_listing-fav,.pl_col-12345 tr td .pl_col .pl_listing-fav,.pl_col-12345 tr td ul.pl_property-amenities li .pl_listing-fav,ul.pl_property-amenities .pl_col-12345 tr td li .pl_listing-fav{display:none}@media screen and (min-width: 40em){.pl_col-122 tr{width:50%}.pl_col-122 tr.odd{padding-right:5px}.pl_col-122 tr.even{padding-left:5px}}@media print{*{background:transparent !important;color:#000 !important;box-shadow:none !important;text-shadow:none !important}a{text-decoration:underline}a:visited{text-decoration:underline}a[href]:after{content:" (" attr(href) ")"}abbr[title]:after{content:" (" attr(title) ")"}.ir a:after{content:""}pre,blockquote{border:1px solid #999;page-break-inside:avoid}thead{display:table-header-group}tr{page-break-inside:avoid}img{page-break-inside:avoid;max-width:100% !important}@page{margin:0.5cm}p,h2,h3{orphans:3;widows:3}h2,h3{page-break-after:avoid}}h1,hr{width:100%}@media screen and (min-width: 27em){h1,.pl_listing-address a{color:green}}@media screen and (min-width: 40em){h1,.pl_listing-address a{color:blue}}@media screen and (min-width: 60em){h1,.pl_listing-address a{color:red}}@media screen and (min-width: 70em){h1,.pl_listing-address a{color:violet}}a{text-decoration:none}

/* Hide the map if not in map view */
#idx_list #idx_map_item,
#idx_gallery #idx_map_item {
	display: none;
}
		
/* jQuery UI and Sort Fixes */
.ui-tabs .ui-widget-content,.ui-tabs .ui-corner-all,.ui-tabs .ui-tabs .ui-corner-all,.ui-tabs .ui-state-default,.ui-tabs .ui-widget-content .ui-state-default,.ui-tabs .ui-widget-header,.ui-tabs .ui-widget-header.ui-state-default,.ui-tabs .ui-corner-top{margin:0;padding:0;list-style-type:none;border-width:0;border:0;background:transparent}.ui-tabs.ui-widget-content{margin:0;padding:0;list-style-type:none;border-width:0;border:0;background:transparent}.ui-tabs ul.ui-tabs-nav{border-bottom:1px solid #d3d3d3;border-bottom-right-radius:0;border-bottom-left-radius:0;margin:0 !important}.ui-tabs ul.ui-tabs-nav li.ui-state-default{background:#d3d3d3;margin-right:0.5em;margin-bottom:0 !important}.ui-tabs ul.ui-tabs-nav li.ui-tabs-selected{background:#fff}.ui-tabs ul.ui-tabs-nav li.ui-state-active{background:#fff}.ui-tabs ul.ui-tabs-nav li.ui-state-hover{background:#d5d5d5}.ui-tabs ul.ui-tabs-nav li.ui-corner-top{border-top-right-radius:2px;border-top-left-radius:2px}.ui-tabs .ui-tabs-panel{padding:0 !important}#pl_idx .sort_wrapper{margin:15px 0;display:inline-block;width:100%}#pl_idx .sort_wrapper .sort_item{width:33.33333%}#pl_idx .sort_wrapper .sort_item label[for="sort_by"]{display:none}#pl_idx .sort_wrapper .sort_item select{width:80%}@media screen and (min-width: 40em){#pl_idx .sort_wrapper .sort_item{width:20em}#pl_idx .sort_wrapper .sort_item label[for="sort_by"]{display:inline-block;width:30%;padding-right:20px}#pl_idx .sort_wrapper .sort_item select{width:60%}}#pl_idx .sort_wrapper .sort_item label[for="sort_type"]{display:none}#pl_idx .dataTables_length{display:none}
',

'snippet_body' => '
[search_form]
<div id="pl_idx">
	<!-- tabs -->
	<ul>
		<li><a class="pl_idx_tab_listings" href="#idx_list">Listings</a></li>
		<li><a class="pl_idx_tab_map" href="#idx_map">Map</a></li>
		<li><a class="pl_idx_tab_gallery" href="#idx_gallery">Gallery</a></li>
	</ul>
	<!-- tab panels, everything starts in the first panel -->
	<div id="idx_list" class="pl_listings pl_col-111">
		<div id="idx_items" class="pl_idx_tab_listings">
			<div id="idx_map_item">[search_map]</div>
			<div id="idx_list_item" class="pl_listings">[search_listings]</div>
		</div>
	</div>
	<div id="idx_map" class="pl_listings pl_col-122"></div>
	<div id="idx_gallery" class="pl_listings pl_col-122"></div>
</div>
',

'search_form' => '
<div class="pl_form pl_col-124">
	
    <div class="pl_form-item pl_col no-search">
      <label>Min Beds</label>
      [min_beds]
    </div>

    <div class="pl_form-item pl_col hide-tablet no-search">
      <label>Min Baths</label>
      [min_baths]
    </div>

    <div class="pl_form-item pl_col hide-tablet no-search">
      <label>Min Price</label>
      [min_price]
    </div>

    <div class="pl_form-item pl_col no-search">
      <label>Max Price</label>
      [max_price]
    </div>

    <div class="pl_form-item pl_col no-search">
      <label>Purchase Type</label>
      [purchase_types]
    </div>

    <div class="pl_form-item pl_col">
      <label>City</label>
      [cities]
    </div>

    <div class="pl_form-item pl_col">
      <label>State</label>
      [states]
    </div>

    <div class="pl_form-item pl_col">
      <label>Zip Code</label>
      [zips]
    </div>
  
    <div class="pl_form-group pl_col pl_form-group--right">
      <div class="pl_form-item pl_form-item--btn">
        <input type="submit" value="Search" />
      </div>
    </div>
		
	<div class="pl_clearfix"></div>

</div>	
',

'search_listings' => '
<div class="pl_listing pl_col">
      
    <div class="pl_listing-inner">

      <p class="pl_listing-address">
        <a href="[url]">[full_address]</a>
      </p>
      
      <div class="pl_listing-img-wrapper">
        <a href="[url]">[image width=300]</a>
        <div class="pl_listing-fav">
          <a href="#">Save</a>
        </div>
      </div>

      <div class="pl_listing-info">

        <p class="pl_listing-meta">
          <span class="pl_listing-price">[price]</span>
          <span class="pl_listing-beds">[beds] beds</span>
          <span class="pl_listing-baths">[baths] baths</span>
          <span class="pl_listing-sqft">[sqft] sqft</span>
        </p>

        <p class="pl_listing-desc">[desc]</p>

        <div class="pl_listing-compl">[compliance]</div>
      
      </div>
    
    </div>

  </div>
',

'javascript' => '
jQuery(function($) {
	// when a tab is selected, move the listings to the new tab
	$("#pl_idx").tabs({
		select: function(event, ui) {
			var idx_items = $("#idx_items").detach();
			$(ui.panel).append(idx_items);
		}
	});

	$("#pl_idx").bind("tabsshow", function(event, ui) {
		if (ui.panel.id == "idx_map") {
			mapRefresh();
		}
	});

	function mapRefresh() {
		var pl_map = $("#pl_idx .custom_google_map").data("pl_map");
		// TODO: remove after updates to blueprint
		if (!pl_map && map) {
			pl_map = map;
		}
		if (pl_map) {
			google.maps.event.trigger(pl_map.map,"resize");
			pl_map.center_on_markers();
		}
	}
});',

// 'before_widget' => '
// <div class="pl-tpl-idx-responsive-tabbed">',

// 'after_widget' => '</div>',

'sc_api_ver' => 1,

'tmpl_ver' => '1.0',

'group' => 'Index',

'description' => 'This search page includes list, gallery and map views in a search page.',

'keywords' => 'tabs,map,list,gallery',

);
