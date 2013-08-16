<?php

$template = array(

'title' => 'Columbus',


'css' => '.property-listing {
  border: 1px solid #000;
  padding: 10px;
  background: #efefef;
  overflow: hidden;
}

.property-listing ul {
  margin: 0 !important;
  padding: 0 !important;
  list-style: none !important;
}
.property-listing h3 {
  margin: 1em 0 .3em 0 !important;
  padding: .3em !important;
  background: #dfdfdf;
}
.property-listing p {
  margin: 0 !important;
}

.property-listing .image {
}
.property-listing .image img {
  width: 100% !important;
  height: auto !important;
  max-width: 100% !important;
}

.property-listing .gallery {
  overflow: hidden;
  margin-right: -1%;
}
.property-listing .gallery li {
  display: block;
  float: left !important;
  margin: 1% 1% 0 0 !important;
  padding: 0 !important;
  width: 9%;
  height: 30px;
  overflow: hidden;
}
.property-listing .gallery a {
  display: block;
  margin: 0 !important;
  border: none !important;
  padding: 0 !important;
  width: 100%;
  height: 100%;
}
.property-listing .gallery img {
  display: block;
  margin: 0 !important;
  border: none !important;
  padding: 0 !important;
  width: 100% !important;
  height: auto !important;
}

.property-listing .price,
.property-listing .mls {
  float: left;
  margin: .5em 1em 0 0 !important;
  font-size: 1.2em;
  font-weight: 600;
}
.property-listing .address {
  clear: both;
  margin: .3em 0 0 0 !important;
  font-size: 1.2em;
  font-weight: 600;
}
.property-listing .features {
  margin: .5em 0 1em 0 !important;
  font-weight: 600;
}
.property-listing .features span {
  padding-right: 1.5em;
}
.property-listing .amenities {
  margin: .5em 0 1em 0 !important;
  overflow: hidden;
}
.property-listing .amenities span {
  display: block;
  float: left;
  width: 10em;
  font-style: italic;
  padding: 0 .3em 0 0;
}
.property-listing .desc {
  margin: .5em 0 0 0 !important;
}
.property-listing .custom_google_map {
  width: 100% !important;
}
.property-listing .actions {
  clear: both;
  float: right;
  margin: .5em 0 0 0 !important;
  overflow: hidden;
}
.property-listing .actions a {
  float: left !important;
  text-decoration: none !important;
}
.property-listing .compliance {
  clear: both;
  margin: .5em 0;
  font-size: .8em;
}
.property-listing .clearfix {
  clear: both;
}

.page-compliance {
  clear: both;
  margin: .8em 0;
  font-size: .8em;
}
.page-compliance p {
  margin: 0 !important;
  padding: 0 !important;
  line-height: 1.1em !important;
  font-size: 10px !important;
}',


'snippet_body' => '<div class="property-listing">
  <div class="image">[image]</div>
  <div class="gallery">[gallery]</div>
  <p class="price">[price]</p>
  <p class="mls">MLS#: [mls_id]</p>
  <p class="address">[address]</p>
  <div class="features">
    [if attribute=\'beds\']<span>Beds: [beds]</span>[/if][if attribute=\'baths\']<span>Baths: [baths]</span>[/if][if attribute=\'half_baths\']<span>Half-Baths: [half_baths]</span>[/if][if attribute=\'sqft\']<span>[sqft] sqft</span>[/if]
  </div>
  <h3>Description</h3>
  <div class="desc">[desc]</div>
  <h3>Amenities</h3>
  <div class="amenities">[amenities]</div>
  <h3>Location</h3>
  <div class="location">[map]</div>
  <div class="actions">[favorite_link_toggle]</div>
  <div class="compliance">[compliance]</div>
</div>',


'before_widget' => '<!-- Place content here that you want to appear before the listing. May include shortcodes -->',


'after_widget' => '<!-- Place content here that you want to appear before the listing. May include shortcodes -->
<div class=\'page-compliance\'>[compliance]</div>',

);
