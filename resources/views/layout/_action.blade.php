<div class="btn-group">
	<a href="{{ $urlDetail }}" class="btn btn-secondary btn-sm rounded">Detail</a>
	@if (isset($urlIntegration))
	&nbsp
	<a href="{{ $urlIntegration }}" class="btn btn-secondary btn-sm rounded">Add Certificate</a>
	@endif
</div>