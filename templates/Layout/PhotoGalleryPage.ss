<h1>$Title</h1>

<p>$Content</p>

<% if PhotoGalleryImages %>
	
	<p style="margin-bottom:5px;"><strong>Click on a thumbnail to enlarge.</strong> Pressing the spacebar while viewing an image shall start a slideshow.</p>
	
	<% loop PhotoGalleryImages %>
		
		<a class="lightbox gallerythumb" title="$Title" rel="gallery" href="$Image.setWidth(850).URL"><img src="$Thumb.URL" width="$Thumb.Width" height="$Height.Height" /></a>
		
	<% end_loop %>

<% end_if %>

<% if Parent.ClassName = PhotoGalleryHolder %>
<p style="margin-top:15px"><a href="$Parent.Link"><strong>View All Galleries</strong></a></p>
<% end_if %>

$Form
$PageComments