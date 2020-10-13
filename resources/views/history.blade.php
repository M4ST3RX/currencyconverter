@extends("layout.app")

@section("content")
    <div class="container-centered">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <ul class="nav nav-tabs nav-fill" id="tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active selected" data-toggle="tab" id="favourites-tab" href="#favourites">Favourites</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" id="history-tab" href="#history">History</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="favourites" role="tabpanel" aria-labelledby="favourites-tab">
                        <favourites></favourites>
                    </div>
                    <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-tab">
                        <history></history>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection