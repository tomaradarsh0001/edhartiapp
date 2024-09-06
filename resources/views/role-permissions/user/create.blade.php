@extends('layouts.app')

@section('title', 'Add User')

@section('content')
    <div>
        <div class="col pt-3">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-0 text-uppercase tabular-record_font pb-4">Create User</h6>
                    <form action="{{ url('users') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="password" class="form-label">password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" value="{{ old('password') }}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="emp_code" class="form-label">Mobile</label>
                                <input type="text" name="mobile_no" class="form-control" placeholder="Mobile Number"
                                value="{{ old('mobile_no') }}" required>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="dob" class="form-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" id="dob"
                                    pattern="\d{2} \d{2} \d{4}" value="{{ old('dob') }}" required>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="gender" class="form-label">Select gender</label>
                                <select class="form-select" name="gender" id="gender"
                                    aria-label="gender" required>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="emp_code" class="form-label">Employee Code</label>
                                <input type="text" name="emp_code" readonly  value="{{ $empCode ? $empCode : old('emp_code') }}" class="form-control" placeholder="Employee Code"
                                required>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="Roles" class="form-label">Select User Type</label>
                                <select class="form-select" name="sub_user_type" id="sub_user_type"
                                    aria-label="Designation" required>
                                    <option value="">Select user type</option>
                                    <option value="ldo" {{ old('sub_user_type') == 'lndo' ? 'selected' : '' }}>{!! 'L&amp;DO' !!}</option>
                                    <option value="pmu" {{ old('sub_user_type') == 'pmu' ? 'selected' : '' }}>{!! 'PMU' !!}</option>
                                </select>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                @if ($designations)
                                    <label for="Roles" class="form-label">Select Designation</label>
                                    <select class="form-select" name="designation_id" id="designation_id"
                                        aria-label="Designation" required>
                                        <option value="">Select</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}" {{ old('designation_id') == $designation->id ? 'selected' : '' }}>{!! $designation->name !!}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-lg-4 pb-4">
                                @if ($sections)
                                    <label for="Sections" class="form-label">Select Sections</label>
                                    <select class="form-select" name="sections[]" aria-label="Default select example"
                                        multiple required>
                                        <option value="">Select sections</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section->id }}" {{ in_array($section->id, old('sections', [])) ? 'selected' : '' }}>{!! $section->name !!}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            <div class="col-12 col-lg-4 pb-4">
                                <label for="Roles" class="form-label">Select Roles</label>
                                <select class="form-select" name="roles[]" aria-label="Default select example" multiple
                                required>
                                    <option value="">Select roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role }}">{{ $role }}</option>
                                    @endforeach
                                </select>
                                <div id="OldColonyNameError" class="text-danger"></div>
                            </div>
                            <div class="col-12 col-lg-4 pb-4">

                            </div>

                        </div>
                        <div class="col-12 col-lg-2">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>

                    </form>



                </div>
            </div>
        </div>


    </div>

@endsection
