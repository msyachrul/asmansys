<div class="btn-group">
	<a href="{{ $urlDetail }}" class="btn btn-secondary">Detail</a>
	@if (isset($urlIntegration))
	&nbsp
	<a href="{{ $urlIntegration }}" class="btn btn-secondary">Certificate</a>
	@endif
</div>