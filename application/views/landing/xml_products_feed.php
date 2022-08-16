<?php

header('Content-type: text/xml'); ?>
<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
  <channel>
    <title>Shatkahonbd</title>
    <link>https://www.shatkahonbd.com</link>
    <description>Click for your daily needs</description>
    <?php foreach ($products as $key => $product) :  ?>
      <item>
        <g:id>SKU-<?= $product->id ?></g:id>
        <g:title><?= character_limiter($product->name, 150) ?? 'name' ?></g:title>
        <g:description><?= htmlspecialchars(strip_tags($product->description)) ?? 'desc' ?></g:description>
        <g:link><?= site_url("/product/" . $product->id ?? 'id') ?></g:link>
        <g:image_link><?= site_url("/images/product/" . $product->photo ?? 'photo') ?></g:image_link>
        <g:brand>Unknown</g:brand>
        <g:availability><?= $product->available == "Yes" ? "in stock" : "out of stock" ?></g:availability>
        <g:condition>new</g:condition>
        <?php
        if ($product->discount_price && $product->has_offer == "Yes") {
          $card_price = $product->discount_price;
        } else {
          $card_price = $product->sale_price;
        }
        ?>
        <g:price>BDT <?= $card_price ?></g:price>
        <g:shipping>
          <g:country>BD</g:country>
          <g:service>Standard</g:service>
          <g:price>BDT 60</g:price>
        </g:shipping>
        <g:quantity_to_sell_on_facebook>500</g:quantity_to_sell_on_facebook>
        <g:google_product_category><?= $product->cat_name ?? "Unknown" ?> &gt; <?= $product->sub_cat_name ?? "Unknown" ?></g:google_product_category>
      </item>
    <?php endforeach; ?>
  </channel>
</rss>