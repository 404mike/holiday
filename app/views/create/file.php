		
	<span id="create_new_story" style="display:none">Finish?</span>

	<div id="total_upload_process"></div>

	<form id="upload" method="post" action="/upload/file/post" enctype="multipart/form-data">
		<div id="drop">
			Drop Here

			<a>Browse</a>
			<input type="file" name="upl" multiple />
		</div>

		<ul>
			<!-- The file uploads will be shown here -->
		</ul>

	</form>


	<div id="create_story_loading">
		<h2>Gathering data</h2>
		<img src="/loading/loading-bubbles.svg" width="64" height="64" />
	</div>