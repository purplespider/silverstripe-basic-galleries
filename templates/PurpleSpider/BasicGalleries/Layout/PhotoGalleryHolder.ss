<% require css("purplespider/basic-galleries: client/dist/css/basic-galleries.css") %>

<h1>$Title</h1>

$Content

<% if ChildHolders %>
	<h2>Gallery Collections</h2>
		
		<% loop ChildHolders %>
			<% if AllGalleries %>
				<% if AllGalleries.First.PhotoGalleryImages %>
					<% with AllGalleries.First.PhotoGalleryImages.First %>
						<a class="galleryholder__gallerylink" href="$ParentPhotoGalleryPage.Parent.Link">
							<img src="$Image.Fill(300,200).URL" />
							<span class="galleryholder__gallerylink__title">$ParentPhotoGalleryPage.Parent.Title</span>
						</a>
					<% end_with %>
				<% end_if %>
			<% end_if %>
		<% end_loop %>
		
	<div class="clear"></div>
	
	<% if Galleries %>
		<h2>Other Galleries</h2>
	<% end_if %>
	
<% end_if %>

<% if Galleries %>
		<% loop Galleries %>
			<% if PhotoGalleryImages %>
				<% with PhotoGalleryImages.First %>
					<a class="galleryholder__gallerylink" href="$ParentPhotoGalleryPage.Link">
						<img src="$Image.Fill(300,200).URL" />
						<span class="galleryholder__gallerylink__title">$ParentPhotoGalleryPage.Title</span>
					</a>
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
		<p><strong>Sorry, we don't have any photo galleries yet. </strong>Please check back later.</p>
<% end_if %>

$Form
$PageComments