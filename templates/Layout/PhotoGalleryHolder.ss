<h1>$Title</h1>

$Content

<% if Galleries %>
		<% loop Galleries %>
			<% if PhotoGalleryImages %>
				<% with PhotoGalleryImages.First %>
				<div class="gallerythumb">
					<p><a href="$PhotoGalleryPage.Link"><img src="$Thumb.URL" width="$Thumb.Width" height="$Thumb.Height" /></a></p>
					<p><a href="$PhotoGalleryPage.Link">$PhotoGalleryPage.Title</a></p>
				</div>
				<% end_with %>
			<% end_if %>
		<% end_loop %>
	
	<% if Galleries.MoreThanOnePage %>
		<div class="pagination">
		    <% if Galleries.NotFirstPage %>
		        <a class="prev" href="$Galleries.PrevLink">Prev</a>
		    <% end_if %>
		    <% loop Galleries.Pages %>
		        <% if CurrentBool %>
		            $PageNum
		        <% else %>
		            <% if Link %>
		                <a href="$Link">$PageNum</a>
		            <% else %>
		                ...
		            <% end_if %>
		        <% end_if %>
		        <% end_loop %>
		    <% if Galleries.NotLastPage %>
		        <a class="next" href="$Galleries.NextLink">Next</a>
		    <% end_if %>
	    </div>
	<% end_if %>

<% else %>
	<div class="contenttext">
		<p><strong>Sorry, we don't have any photo galleries yet. </strong>Please check back another time.</p>
	</div>
<% end_if %>

$Form
$PageComments