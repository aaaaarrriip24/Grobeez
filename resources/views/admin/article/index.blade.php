@extends('layouts.app')
@section('content')
<div class="container">
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ url('articles') }}">Article</a></li>
            <li class="breadcrumb-item active" aria-current="page"><a href="#" data-bs-toggle="modal"
                    data-bs-target="#addModal">Add</a></li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-hover table-striped data-table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Title</th>
                        <th scope="col">Paragraph</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->title }}</td>
                        <td>{{ $d->paragraph }}</td>
                        <td>{{ $d->created_at }}</td>
                        <td>
                            <button class="btn btn-sm btn-light updateUser mb-2" value="{{ $d->id }}" data-id="{{ $d->id }}" data-bs-toggle='modal' data-bs-target='#updateModal' >Update</button>
                            <a href="{{ url('articles/destroy/'.$d->id) }}" class='btn btn-sm btn-danger deleteUser mb-2' value="{{ $d->id }}" data-id="{{ $d->id }}">Delete</a>
                            <a href="{{ asset('storage/'.$d->headerImage) }}" class='btn btn-sm btn-primary mb-2' target='_blank'>Peek Header</a>
                            <a href="{{ asset('storage/'.$d->flyerImage) }}" class='btn btn-sm btn-success mb-2' target='_blank'>Peek Flyer</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('articles') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Article</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" placeholder="Title for Article"
                                id="floatingTextarea" name="title" required>
                            <label for="floatingTextarea">Title</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Paragraph for Article" id="floatingTextarea2"
                                name="paragraph" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Paragraph</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Header Image</label>
                        <input type="file" class="form-control" id="exampleheaderImage" name="headerImage" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Flyer Image</label>
                        <input type="file" class="form-control" id="exampleflyerImage" name="flyerImage" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ url('articles/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input hidden type="text" name="id" class="id">
                <input hidden type="text" name="oldheaderImage" class="oldheaderImage">
                <input hidden type="text" name="oldflyerImage" class="oldflyerImage">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Article</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <div class="form-floating">
                            <input class="form-control form-control-sm title" placeholder="Title for Article"
                                id="floatingTextarea" name="title" required>
                            <label for="floatingTextarea">Title</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control paragraph" placeholder="Paragraph for Article"
                                id="floatingTextarea2" name="paragraph" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Paragraph</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Header Image</label>
                        <input type="file" class="form-control" id="exampleheaderImage" name="headerImage">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Flyer Image</label>
                        <input type="file" class="form-control" id="exampleflyerImage" name="flyerImage">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $(document).ready(function () {
        $(document).on('click', '.updateUser', function () {
            var id = $(this).val();
            // alert(id);
            $('#editModal').modal('show');

            $.ajax({
                type: "GET",
                url: base_url + "articles/" + id,
                success: function (response) {
                    console.log(response);
                    $('.id').val(id);
                    $('.title').val(response.data.title);
                    $('.paragraph').val(response.data.paragraph);
                    $('.oldheaderImage').val(response.data.headerImage);
                    $('.oldflyerImage').val(response.data.flyerImage);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".dt-buttons").addClass("d-none");
    });
</script>
@endsection
