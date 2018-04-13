<% require css("purplespider/basic-galleries: client/dist/css/basic-galleries.css") %>

<h1>$Title</h1>

<p>$Content</p>

<% if PhotoGalleryImages %>
		
	<% loop PhotoGalleryImages %>
		
		<a class="lightbox" title="$Title" rel="gallery" href="$Image.FitMax(1200,1200).URL"><img src="$Image.Fill(300,300).URL" /></a>
		
	<% end_loop %>

<% end_if %>

<% if Parent.ClassName = PhotoGalleryHolder %>
<p><a href="$Parent.Link"><strong>View All Galleries</strong></a></p>
<% end_if %>

$Form
$PageComments