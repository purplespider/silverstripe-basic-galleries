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
	
        <% if PaginatedGalleries.MoreThanOnePage %>
            <% with $PaginatedGalleries %>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <% if $NotFirstPage %>
                            <li class="page-item">
                                <a class="page-link prev" href="{$PrevLink}" aria-label="Previous page">
                                    <span aria-hidden="true">Previous</span>
                                </a>
                            </li>
                        <% end_if %>

                        <% loop $PaginationSummary(4) %>
                            <% if $CurrentBool %>
                                <li class="page-item active" aria-current="page"><a class="page-link" href="#">$PageNum</a></li>
                            <% else %>
                                <% if $Link %>
                                    <li class="page-item"><a class="page-link" href="$Link">$PageNum</a></li>
                                <% else %>
                                <li class="page-item disabled">...</li>
                                <% end_if %>
                            <% end_if %>
                        <% end_loop %>

                        <% if $NotLastPage %>
                            <li class="page-item">
                                <a class="page-link prev" href="{$NextLink}" aria-label="Next page">
                                    <span aria-hidden="true">Next</span>
                                </a>
                            </li>
                        <% end_if %>
                    </ul>
                </nav>
            <% end_with %>
        <% end_if %>

<% else %>
		<p><strong>Sorry, we don't have any photo galleries yet. </strong>Please check back later.</p>
<% end_if %>

$Form
$PageComments
