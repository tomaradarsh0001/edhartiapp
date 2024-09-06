@extends('layouts.app')

@section('title', 'Vendor')

@section('content') 
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">Logistic</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Vendors/Suppliers</li>
            </ol>
        </nav>
    </div>
</div>
<div>
    <div class="col pt-3">
        <div class="card">
            <div class="card-body m-3">
                <!-- <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Edit Vendor details</h6> -->
                <form action="{{ route('supplier.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row align-items-end my-3">
                        <div class="col-12 col-lg-4">
                            <label for="name" class="form-label">Update Name:</label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ $data->name }}" placeholder="Update Name">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="contact_no" class="form-label">Update Number:</label>
                            <input type="text" name="contact_no" id="contact_no" class="form-control"
                                value="{{ $data->contact_no }}" placeholder="Update Number">
                        </div>
                        <div class="col-12 col-lg-4">
                            <label for="email" class="form-label">Update Email:</label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ $data->email }}" placeholder="Update Email">
                        </div>
                    </div>
                        <div class="col-12 col-lg-12">
                            <label for="office_address" class="form-label">Update Address:</label>
                            <input type="text" name="office_address" id="office_address" class="form-control"
                                value="{{ $data->office_address }}" placeholder="Update Address">
                        </div>
                    <div class="row align-items-end my-3">
                        <div class="col-12 col-lg-6">
                           <label class="form-label" for="status">Status:</label>
                            <select id="status" name="status" class="form-control">
                             <option value="active" {{ $data->status == 'active' ? 'selected' : '' }}>Active</option>
                             <option value="inactive" {{ $data->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                         </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="is_tender" name="is_tender" class="form-control">Is Tender:</label>
                               <select id="is_tender" name="is_tender" class="form-control">
                               <option value="active" {{ $data->is_tender == 'active' ? 'selected' : '' }}>Active</option>
                               <option value="inactive" {{ $data->is_tender == 'inactive' ? 'selected' : '' }}>Inactive</option>
                           </select>
                        </div>
                    </div>    
                    <div class="row align-items-end my-3">
                    <div class="col-12 col-lg-6">
                    <label class="form-label" for="from_tender">From Tender:</label>
                    <input type="date" id="from_tender" name="from_tender" value="{{ $data->from_tender }}" class="form-control">
                </div>

                <div class="col-12 col-lg-6">
                    <label class="form-label" for="to_tender">To Tender:</label>
                    <input type="date" id="to_tender" name="to_tender" value="{{ $data->to_tender }}" class="form-control">
                </div>
            </div>

                        <div class="col-12 col-lg-2 my-4">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>



            </div>
        </div>
    </div>


</div>
@endsection