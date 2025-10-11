<div class="container w-100 mb-3 border-bottom border-top border-primary border-2">
    <div class="row">
        @foreach($detailsHeader as $detailHeader)
            <div class="col text-lg-center fw-bold py-4">{{ $detailHeader }}</div>
        @endforeach
    </div>
    <div class="row">
        @foreach($details as $detail)
            <div class="col text-lg-center py-4">{{ $detail }}</div>
        @endforeach
    </div>
</div>
