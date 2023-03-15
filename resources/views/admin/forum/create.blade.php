@extends('admin/layouts.app')
@section('pageTitle', 'Thêm diễn đàn')
@section('content')
<div class="nk-block-head-sub"><a class="back-to" href="{{ url()->previous() }}"><em class="icon ni ni-arrow-left"></em><span>Quay lại</span></a></div>

	<div class="card shadow mb-4">
		<div class="card-body ">
			<form action="{{ route('forum.store') }}" method="POST">

                @csrf
		 		<label>Tên<sup>*</sup></label>
		 		<input type="text" required
                name="name"
		 		class="form-control mb-4 col-6">
		 			 		
		 		<label>Mô tả</label>
		 		<textarea 
                cols="50" 
                rows="20" 
                name="description"
                class="form-control mb-4"
                ></textarea>

		 		<button type="submit" class="btn btn-info">Thêm diễn đàn</button>
		 	</form>
   		</div>
	</div>
	
    



@endsection

@section('additional-scripts')
<script>


</script>
@endsection