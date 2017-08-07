{foreach $list as $image}
<li>
	<a href="javascript:void(0)" data-rel="colorbox">
		<img width="150" height="150" alt="150x150" src="{$image->getUrl('150x150')}" />
		<div class="text">
			<div class="inner">{$image->getName()}</div>
		</div>
	</a>
	<a id="r1" class="file_entry selected" tabindex="-1" role="listiem presentation" href="javascript:void(0)" title="15390735_10154079902492314_7419607583760135001_n.jpg" aria-labelledby="r1_label" aria-describedby="r1_details" style="width: 110px"><div class="image"><div role="img" style="width: 100px; height: 100px; background-image: url(&quot;http://uploadimage.testmore/ckfinder/core/connector/php/connector.php?command=Thumbnail&amp;type=Images&amp;currentFolder=%2F&amp;langCode=en&amp;hash=50f9a56a249a3227&amp;FileName=15390735_10154079902492314_7419607583760135001_n.jpg&amp;fileHash=201706301258-101&quot;);"></div></div><h5 id="r1_label">15390735_10154079902492314_7419607583760135001_n.jpg</h5><span id="r1_details" class="details" role="list presentation"><span role="listitem" class="extra">6/30/2017 0:58 PM</span><span role="listitem" aria-label="Size">101 KB</span></span></a>
</li>

{/foreach}